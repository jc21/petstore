<?php
/**
 * Petstore User Static Methods
 */

namespace Petstore\Entities;


use \Petstore\Helper;
use \Petstore\Models\User as UserModel;


class User
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

        $user = new UserModel();

        foreach ($new_data as $field => $value) {
            $user->$field = $value;
        }

        $user->save();

        return $user->fields();
    }


    /**
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function createFromArray($request)
    {
        $array_data = Helper::getDataFromRequest($request);
        $response   = null;

        if ($array_data && count($array_data)) {
            $response = [];

            foreach ($array_data as $array_item) {
                // TODO: Other validations based on values supplied

                $user = new UserModel();

                foreach ($array_item as $user_field => $user_value) {
                    $user->$user_field = $user_value;
                }

                try {
                    $user->save();
                    $response[] = $user->fields();
                } catch (\Exception $exception) {
                    $response[] = null;
                }
            }
        } else {
            throw new \Exception('No items found in array');
        }

        return $response;
    }


    /**
     * @param  int $id
     * @return array
     * @throws \Exception
     */
    public static function getById($id)
    {
        $user = new UserModel();
        if ($user->loadFrom('id', $id)) {
            return $user->fields();
        }

        return null;
    }


    /**
     * @param  string $username
     * @param  bool   $asArray
     * @return array|UserModel
     * @throws \Exception
     */
    public static function getByUsername($username, $asArray = true)
    {
        $user = new UserModel();
        if ($user->loadFrom('username', $username)) {
            if ($asArray) {
                return $user->fields();
            } else {
                return $user;
            }
        }

        return null;
    }


    /**
     * @param  string $username
     * @param  object $request
     * @return array
     * @throws \Exception
     */
    public static function updateByUsername($username, $request)
    {
        $update_data = Helper::getDataFromRequest($request);

        if ($user = self::getByUsername($username, false)) {
            foreach ($update_data as $field => $value) {
                $user->$field = $value;
            }

            $user->save();

            return $user->fields();
        }

        return null;
    }


    /**
     * @param  string $username
     * @return bool
     * @throws \Exception
     */
    public static function deleteByUsername($username)
    {
        if ($user = self::getByUsername($username, false)) {
            return $user->delete();
        }

        return false;
    }


    /**
     * @param  object $request
     * @return bool
     * @throws \Exception
     */
    public static function login($request)
    {
        // TODO: proper auth mechanism and token response

        if ($user = self::getByUsername($request->username, false)) {
            return $user->password === $request->password;
        }

        return false;
    }


    /**
     * @param  object $request
     * @return bool
     * @throws \Exception
     */
    public static function logout($request)
    {
        // TODO: token destroy

        return true;
    }
}
