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

    public function successResponse(Response $response, $data = null, $message = "Requisição realizada com sucesso")
    {
        return $response->withJson([
            'success' => true,
            'data' => isset($data['data']) ? $data['data'] : $data,
            'paginator' => isset($data['paginator']) ? $data['paginator'] : null,
            'message' => $message,
            'errors' => null
        ]);
    }

    public function errorResponse(Response $response, $errors, $message = "Requisição resultou em falha")
    {
        return $response->withJson([
            'success' => false,
            'data' => null,
            'paginator' => null,
            'message' => $message,
            'errors' => $errors
        ]);
    }
}