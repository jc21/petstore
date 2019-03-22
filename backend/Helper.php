<?php
/**
 * Petstore Database
 *
 * Just a JSON file :)
 */

namespace Petstore;


class Helper
{

    /**
     * @param object $request
     * @return array
     */
    public static function getDataFromRequest($request)
    {
        $data = json_decode($request->raw(), true);

        if (!$data) {
            $data = $request->post();
        }

        if (!$data) {
            $data = $request->raw();
        }

        return $data;
    }
}
