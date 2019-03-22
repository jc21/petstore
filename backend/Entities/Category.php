<?php
/**
 * Petstore Category Static Methods
 */

namespace Petstore\Entities;


use \Petstore\Models\Category as CategoryModel;


class Category
{

    /**
     * @param  string $name
     * @return array
     * @throws \Exception
     */
    public static function create($name)
    {
        $category       = new CategoryModel();
        $category->name = $name;
        $category->save();

        return $category->fields();
    }


    /**
     * @param  string $name
     * @param  bool   $autocreate
     * @return array
     * @throws \Exception
     */
    public static function getByName($name, $autocreate = false)
    {
        $category = new CategoryModel();
        if ($category->loadFrom('name', $name)) {
            return $category->fields();
        } else if ($autocreate) {
            return self::create($name);
        }

        return null;
    }


    /**
     * @param  int $id
     * @return array
     * @throws \Exception
     */
    public static function getById($id)
    {
        $category = new CategoryModel();
        if ($category->loadFrom('id', $id)) {
            return $category->fields();
        }

        return null;
    }
}
