<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

use Foco\Controller\GraphQLController;
use Foco\Controller\AlunosController;

return function (App $app) {
    $container = $app->getContainer();

    $app->group($container->baseRoute, function () use ($app) {
        
        $app->group('/graphql', function() use ($app) {
            $app->post('/', GraphQLController::class);
        });

        $app->group('/rest', function () use ($app) {
            $app->group('/alunos', function () use ($app) {
                $app->get('', AlunosController::class . ":index");
                $app->post('', AlunosController::class . ":create");
                $app->put('/{id}', AlunosController::class . ":update");
            });
        });
        
    });
};
