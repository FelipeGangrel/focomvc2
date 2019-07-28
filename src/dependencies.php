<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // baseRoute
    $container['baseRoute'] = function ($c) {
        return $c->get('settings')['baseRoute'];
    };

    // database com eloquent
    $container['database'] = function ($c) {
        $settings = $c->get('settings')['db'];
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($settings);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    /**
     * Controllers
     * Todos os controllers não registrados aqui 
     * receberão por padrão apenas um objeto do tipo \Slim\Container
     */
    $container['AlunosController'] = function ($c) {
        return new Foco\Controller\AlunosController($c);
    };

    $container['GraphQLController'] = function ($c) {

        $settings = $c->get('settings')['graphql'];

        $maxDepth = $settings['maxDepth'];
        $introspection = $settings['introspection'];
        $debug = $settings['debug'];

        return new Foco\Controller\GraphQLController($c, $maxDepth, $introspection, $debug);
    };
};
