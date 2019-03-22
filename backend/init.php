<?php
/**
 * API Server Init
 */

define('BACKEND', __DIR__);

include '../vendor/autoload.php';

try {
    $app = Petstore\App::getInstance();
    $app->run();
} catch (\Exception $exception) {
    $data = [
        'error'   => str_replace('Exception', '', get_class($exception)),
        'code'    => $exception->getCode() ? $exception->getCode() : 500,
        'message' => $exception->getMessage(),
    ];

    header('Content-Type: application/json');
    print json_encode($data);
    exit();
}
