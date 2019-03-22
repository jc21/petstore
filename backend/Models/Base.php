<?php
/**
 * Model Base
 *
 * TODO: model schema (jsonschema?) and validation thereof
 */

namespace Petstore\Models;


abstract class Base
{

    /**
     * @var \mysqli
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * Which field is to be used as the identifier
     *
     * @var string
     */
    protected $idField;


    /**
     * Base constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->db = \Petstore\App::getInstance()->db;

        if (!$this->table) {
            throw new \Exception('Table is not defined on this model');
        } else if (!$this->idField) {
            throw new \Exception('ID Field is not defined on this model');
        }
    }


    /**
     * Get a field value
     *
     * @param  string $field
     * @return mixed|null
     */
    public function __get($field)
    {
        return $this->fields[$field] ?? null;
    }


    /**
     * Set a field value
     *
     * @param  string $field
     * @param  mixed  $value
     * @throws \Exception
     */
    public function __set($field, $value)
    {
        if (array_key_exists($field, $this->fields)) {
            $this->fields[$field] = $value;
        } else {
            throw new \Exception('Field does not exist on model: ' . $field);
        }
    }


    /**
     * Save the row
     *
     * @throws \Exception
     */
    public function save()
    {
        $fieldsSql = [];

        // If any fields are null (except the ID field), then throw
        $fields = $this->fields;
        unset($fields[$this->idField]);

        foreach ($fields as $field => $value) {
            if ($value === null) {
                throw new \Exception('One or more fields are not defined');
            }

            $fieldsSql[] = '`' . $field . '` = "' . addcslashes($value, '\"') . '"';
        }

        // At this point, the data should be good
        if ($this->fields[$this->idField]) {
            // Update
            $sql = 'UPDATE `' . $this->table . '` SET ' . implode($fieldsSql, ', ') . ' WHERE `' . $this->idField . '` = ' . addcslashes($this->fields[$this->idField], '\"');
        } else {
            // Insert
            $sql = 'INSERT INTO `' . $this->table . '` SET ' . implode($fieldsSql, ', ');
        }

        if (mysqli_query($this->db, $sql)) {
            // Set new insert id
            if (!$this->fields[$this->idField]) {
                $id                           = mysqli_insert_id($this->db);
                $this->fields[$this->idField] = $id;
            }
        } else {
            throw new \Exception('Could not save record: ' . mysqli_error($this->db));
        }
    }


    /**
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function loadFrom($field, $value)
    {
        if (array_key_exists($field, $this->fields)) {
            $sql    = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = "' . addcslashes($value, '\"') . '" LIMIT 0,1';
            $result = mysqli_query($this->db, $sql);

            while ($row = $result->fetch_assoc()) {
                if (array_key_exists('id', $row)) {
                    $row['id'] = (int) $row['id'];
                }

                $this->fields = $row;
            }

            mysqli_free_result($result);

            return $this->fields[$this->idField] > 0;
        }

        return false;
    }


    /**
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }


    /**
     * @param  array  $criteria
     * @param  string $operand
     * @return array|null
     */
    public function search($criteria, $operand = 'AND')
    {
        if ($criteria && count($criteria)) {

            $sqlFields = [];

            foreach ($criteria as $field => $value) {
                if (is_array($value)) {
                    foreach ($value as &$item) {
                        $item = addcslashes($item, '\"');
                    }

                    $sqlFields[] = '`' . $field . '` = IN("' . implode($value, '", "') . '")';
                } else {
                    $sqlFields[] = '`' . $field . '` = "' . addcslashes($value, '\"') . '"';
                }
            }

            $sql    = 'SELECT * FROM `' . $this->table . '` WHERE ' . implode($sqlFields, ' ' . $operand . ' ');
            $result = mysqli_query($this->db, $sql);
            $rows   = [];

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            mysqli_free_result($result);

            return $rows;
        }

        return null;
    }


    /**
     * @param  array  $criteria
     * @param  string $operand
     * @return int
     */
    public function searchDelete($criteria, $operand = 'AND')
    {
        $counter = 0;
        $rows    = $this->search($criteria, $operand);

        if ($rows) {
            foreach ($rows as $row) {
                $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $this->idField . '` = "' . addcslashes($row[$this->idField], '\"') . '" LIMIT 1';
                if ($result = mysqli_query($this->db, $sql)) {
                    $counter++;
                }
            }
        }

        return $counter;
    }


    /**
     * @return bool
     */
    public function delete()
    {
        if ($this->fields[$this->idField]) {
            $sql = 'DELETE FROM `' . $this->table . '` WHERE `' . $this->idField . '` = "' . addcslashes($this->fields[$this->idField], '\"') . '" LIMIT 1';

            if (mysqli_query($this->db, $sql)) {
                return true;
            }
        }

        return false;
    }
}
