<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

//    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
//        // Sample log message
//        $container->get('logger')->info("Slim-Skeleton '/' route");
//
//        // Render index view
//        return $container->get('renderer')->render($response, 'index.phtml', $args);
//    });

    $app->get('/', function ($req, $res) use ($container){
        return "<h1> Hello World! </h1>";
    });

    $app->get('/detect/[{username}]', \App\Controllers\HomeController::class . ":detect");
};
