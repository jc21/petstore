<?php
/**
 * Pet Routes
 *
 * @var \Bullet\App $api
 */

use \Petstore\Entities\Pet as Pet;


/**
 * METHOD /pet
 */
$api->path('pet', function () use ($api) {

    /**
     * POST /pet
     *
     * Creates a new Pet
     */
    $api->post(function ($request) use ($api) {
        $data     = Pet::create($request);
        $response = $api->response(201, $data);

        $api->format('json', function () use ($api, $response) {
            return $response;
        });
    });

    /**
     * PUT /pet
     *
     * Updates a Pet
     */
    $api->put(function ($request) use ($api) {
        $user = Pet::updateByRequest($request);

        if ($user) {
            $response = $api->response(200, $user);
        } else {
            $response = $api->response(404);
        }

        $api->format('json', function () use ($api, $response) {
            return $response;
        });
    });

    /**
     * METHOD /pet/123
     */
    $api->param('int', function ($request, $id) use ($api) {

        /**
         * GET /pet/123
         *
         * Find a pet
         */
        $api->get(function () use ($api, $id) {
            $pet = Pet::getById($id);

            if ($pet) {
                $response = $api->response(200, $pet);
            } else {
                $response = $api->response(404);
            }

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });

        /**
         * POST /pet/123
         *
         * Update a Pet
         */
        $api->post(function ($request) use ($api, $id) {
            $pet = Pet::updateById($id, $request);

            if ($pet) {
                $response = $api->response(200, $pet);
            } else {
                $response = $api->response(404);
            }

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });

        /**
         * DELETE /pet/123
         *
         * Delete a Pet
         */
        $api->delete(function () use ($api, $id) {
            $deleted  = Pet::deleteById($id);
            $response = $api->response($deleted ? 200 : 400);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });

        /**
         * METHOD /pet/123/uploadImage
         */
        $api->path('uploadImage', function () use ($api, $id) {

            /**
             * POST /pet/123/uploadImage
             *
             * Uploads an image for the pet
             */
            $api->post(function ($request) use ($api, $id) {
                $deleted  = Pet::uploadImage($id, $request);
                $response = $api->response($deleted ? 200 : 400);

                $api->format('json', function () use ($api, $response) {
                    return $response;
                });
            });
        });
    });

    /**
     * METHOD pet/findByStatus
     */
    $api->path('findByStatus', function () use ($api) {

        /**
         * GET /pet/findByStatus
         *
         * Returns pets matching status(es)
         */
        $api->get(function ($request) use ($api) {
            $pets = Pet::getByStatus($request);

            if ($pets) {
                $response = $api->response(200, $pets);
            } else {
                $response = $api->response(404);
            }

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });
});
