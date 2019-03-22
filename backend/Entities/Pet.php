<?php
/**
 * Petstore Pet Static Methods
 */

namespace Petstore\Entities;


use \Petstore\Helper;
use \Petstore\Models\Pet as PetModel;
use \Petstore\Models\PetHasTag as PetHasTagModel;


class Pet
{

    /**
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function create($request)
    {
        $new_data = Helper::getDataFromRequest($request);

        if (isset($new_data['id']) && $new_data['id']) {
            throw new \Exception('ID was supplied to create call, did you mean to update?');
        }

        // TODO: Other validations based on values supplied

        $pet = new PetModel();

        // Determine Category and tags and change data to match model
        self::manipulateCategoryPayload($new_data);

        // Handle tags before saving
        $tags = null;
        if (array_key_exists('tags', $new_data) && is_array($new_data['tags'])) {
            $tags = $new_data['tags'];
            unset($new_data['tags']);
        }

        // TODO: process photoUrls but for now, ignore it
        unset($new_data['photoUrls']);

        foreach ($new_data as $field => $value) {
            $pet->$field = $value;
        }

        $pet->save();

        // Save tags
        self::saveTags($pet->id, $tags);

        return self::getById($pet->id);
    }


    /**
     * @param  int $id
     * @return array
     * @throws \Exception
     */
    public static function getById($id)
    {
        $pet = new PetModel();
        if ($pet->loadFrom('id', $id)) {
            $result = $pet->fields();

            self::applyCategory($result);
            self::applyTags($result);

            return $result;
        }

        return null;
    }


    /**
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function getByStatus($request)
    {

        $statuses = Helper::getDataFromRequest($request);

        if (!is_array($statuses) || !count($statuses)) {
            throw new \Exception('No statuses to search for!');
        }

        // TODO: validate that the statuses match the enum

        $pet  = new PetModel();
        $pets = $pet->search(['status' => $statuses]);

        foreach ($pets as &$pet) {
            self::applyCategory($pet);
            self::applyTags($pet);
        }

        return $pet->search(['status' => $statuses]);
    }


    /**
     * @param  int    $id
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function updateById($id, $request)
    {
        $data = Helper::getDataFromRequest($request);

        if (!$data) {
            throw new \Exception('Data was not supplied');
        }

        $pet = new PetModel();

        // Determine Category and tags and change data to match model
        self::manipulateCategoryPayload($new_data);

        if ($pet->loadFrom('id', $id)) {
            foreach ($data as $field => $value) {
                $pet->$field = $value;
            }

            // Handle tags before saving
            $tags = null;
            if (array_key_exists('tags', $new_data) && is_array($new_data['tags'])) {
                $tags = $new_data['tags'];
                unset($new_data['tags']);
            }

            $pet->save();

            // Save tags
            self::saveTags($pet->id, $tags);

        } else {
            throw new \Exception('Could not find record');
        }

        return self::getById($pet->id);
    }


    /**
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function updateByRequest($request)
    {
        $data = Helper::getDataFromRequest($request);

        if (!isset($data['id']) || !$data) {
            throw new \Exception('ID was not supplied');
        }

        return self::updateById($data['id'], $request);
    }


    /**
     * @param  int $id
     * @return bool
     * @throws \Exception
     */
    public static function deleteById($id)
    {
        $pet = new PetModel();

        if ($pet->loadFrom('id', $id)) {
            return $pet->delete();
        }

        return false;
    }


    /**
     * @param  int    $id
     * @param  object $request
     * @return string
     */
    public static function uploadImage($id, $request)
    {
        // TODO

        return null;
    }


    /**
     * @param  array $payload
     * @throws \Exception
     */
    protected static function manipulateCategoryPayload(&$payload)
    {
        if (array_key_exists('category', $payload) && $payload['category']) {
            if ($category = Category::getByName($payload['category']['name'], true)) {
                $payload['categoryId'] = $category['id'];
            } else {
                $payload['categoryId'] = 0;
            }

            unset($payload['category']);
        }
    }


    /**
     * @param  int   $id
     * @param  array $tags
     * @throws \Exception
     */
    protected static function saveTags($id, $tags)
    {
        // Clear pre-existing tags for this pet
        $hasTags = new PetHasTagModel();
        $hasTags->searchDelete(['petId' => $id]);

        // Add new tags and create if they don't exist
        foreach ($tags as $tag) {
            $tag = Tag::getByName($tag['name'], true);

            $hasTags        = new PetHasTagModel();
            $hasTags->petId = $id;
            $hasTags->tagId = $tag['id'];
            $hasTags->save();
        }
    }


    /**
     * @param array $result
     * @throws \Exception
     */
    protected static function applyCategory(&$result)
    {
        if ($result['category']) {
            $result['category'] = Category::getById($result['category']);
        }

        unset($result['categoryId']);
    }


    /**
     * @param array $result
     * @throws \Exception
     */
    protected static function applyTags(&$result)
    {
        $result['tags'] = [];
        $hasTags        = new PetHasTagModel();
        if ($tagLinks = $hasTags->search(['petId' => $result['id']])) {
            foreach ($tagLinks as $tagLink) {
                $result['tags'][] = Tag::getById($tagLink['tagId']);
            }
        }
    }
}
