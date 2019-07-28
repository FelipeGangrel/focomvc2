<?php

namespace Foco\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BaseController
{
    protected $container;
    protected $database;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->database = $container->database;
    }

    public function successResponse(Response $response, $data)
    {
        $return = [
            'data' => isset($data['data']) ? $data['data'] : $data,
            'paginator' => isset($data['paginator']) ? $data['paginator'] : null,
            'success' => true,
        ];
        return $response->withJson($return);
    }
}