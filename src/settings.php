<?php

$devMachines = ['localhost'];
$serverName = $_SERVER['SERVER_NAME'];
$isDevMachine = in_array($serverName, $devMachines);

// url base
$baseUrl = $isDevMachine
? "http://{$serverName}/slim-graphql"
: "https://dominio.com";

// caminho para a pasta public
$publicUrl = $isDevMachine
? "{$baseUrl}/php/public/"
: "{$baseUrl}/public/";

// raiz da rota
$baseRoute = $isDevMachine
? "/slim-graphql"
: "";

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'baseRoute' => $baseRoute,

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'graphql_teste',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],

        'graphql' => [
            /* 
             * OFF (0)
             * INCLUDE_DEBUG_MESSAGE (1)
             * INCLUDE_TRACE(2)
             * RETHROW_INTERNAL_EXCEPTIONS (4)
             */
            'debug' => 4,
            'maxDepth' => 15,
            'introspection' => true,
        ],

    ],
];
