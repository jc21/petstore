<?php
/**
 * API Index Routes
 *
 * @var \Bullet\App $api
 */


/**
 * METHOD /
 *
 * Not part of the Swagger spec but it's nice to be a self-discovering API.
 */
$api->path(['/', 'index'], function (/*$request*/) use ($api) {
    $api->get(function (/*$request*/) use ($api) {
        $data = [
            'rel'   => ['index'],
            'links' => [
                'user'  => [
                    'rel'   => ['user'],
                    'title' => 'Users',
                    'href'  => $api->url('/user'),
                ],
                'pet'   => [
                    'rel'   => ['pet'],
                    'title' => 'Pets',
                    'href'  => $api->url('/pet'),
                ],
                'store' => [
                    'rel'   => ['store'],
                    'title' => 'Stores',
                    'href'  => $api->url('/store'),
                ],
            ],
        ];

        $api->format('json', function () use ($data, $api) {
            return $api->response(200, $data);
        });
    });
});
