<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

use Controllers\AlunosController;

return function (App $app) {
    $container = $app->getContainer();

    $app->group($container->baseRoute, function() use ($app) {
        $app->group('/alunos', function () use ($app) {
            $app->get('', AlunosController::class . ":index");
            $app->post('', AlunosController::class . ":create");
            $app->put('/{id}', AlunosController::class . ":update");
        });
    });

    // $app->get('/slim-graphql/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
    //     // Sample log message
    //     $container->get('logger')->info("Slim-Skeleton '/' route");

    //     // Render index view
    //     return $container->get('renderer')->render($response, 'index.phtml', $args);
    // });


};
