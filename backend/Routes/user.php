<?php
/**
 * User Routes
 *
 * @var \Bullet\App $api
 */

use \Petstore\Entities\User as User;


/**
 * METHOD /user
 */
$api->path('user', function () use ($api) {

    /**
     * POST /user
     *
     * Create a single user
     */
    $api->post(function ($request) use ($api) {
        $data     = User::create($request);
        $response = $api->response(201, $data);

        $api->format('json', function () use ($api, $response) {
            return $response;
        });
    });

    /**
     * METHOD /user/createWithArray
     */
    $api->path('createWithArray', function () use ($api) {

        /**
         * POST /user/createWithArray
         *
         * Creates new users from given array
         */
        $api->post(function ($request) use ($api) {
            $data     = User::createFromArray($request);
            $response = $api->response(201, $data);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });

    /**
     * METHOD /user/createWithList
     */
    $api->path('createWithList', function () use ($api) {

        /**
         * POST /user/createWithList
         *
         * Creates new users from given list
         */
        $api->post(function ($request) use ($api) {
            $data     = User::createFromArray($request);
            $response = $api->response(201, $data);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });

    /**
     * METHOD /user/login
     */
    $api->path('login', function () use ($api) {

        /**
         * GET /user/login
         *
         * Logs in a user
         */
        $api->get(function ($request) use ($api) {
            $data     = User::login($request);
            $response = $api->response(200, $data);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });

    /**
     * METHOD /user/logout
     */
    $api->path('logout', function () use ($api) {

        /**
         * GET /user/logout
         *
         * Logs out a user
         */
        $api->get(function ($request) use ($api) {
            $data     = User::login($request);
            $response = $api->response(200, $data);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });

    /**
     * METHOD /user/123
     */
    $api->param('slug', function ($request, $username) use ($api) {

        /**
         * GET /user/*
         */
        $api->get(function () use ($api, $username) {
            $user = User::getByUsername($username);

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
         * PUT /user/*
         */
        $api->put(function ($request) use ($api, $username) {
            $user = User::updateByUsername($username, $request);

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
         * DELETE /user/*
         */
        $api->delete(function () use ($api, $username) {
            $deleted  = User::deleteByUsername($username);
            $response = $api->response($deleted ? 200 : 400);

            $api->format('json', function () use ($api, $response) {
                return $response;
            });
        });
    });

});

