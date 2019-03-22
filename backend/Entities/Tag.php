<?php
/**
 * Petstore Tag Static Methods
 */

namespace Petstore\Entities;


use \Petstore\Models\Tag as TagModel;


class Tag
{

    /**
     * @param  string $name
     * @return array
     * @throws \Exception
     */
    public static function create($name)
    {
        $tag       = new TagModel();
        $tag->name = $name;
        $tag->save();

        return $tag->fields();
    }


    /**
     * @param  string $name
     * @param  bool   $autocreate
     * @return array
     * @throws \Exception
     */
    public static function getByName($name, $autocreate = false)
    {
        $tag = new TagModel();
        if ($tag->loadFrom('name', $name)) {
            return $tag->fields();
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
        $tag = new TagModel();
        if ($tag->loadFrom('id', $id)) {
            return $tag->fields();
        }

        return null;
    }
}
