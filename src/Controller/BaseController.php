<?php

namespace Foco\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BaseController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function successResponse(Response $response, $data = null, $message = "Requisição realizada com sucesso")
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $paginatedData = $data->toArray();
            $paginator = [
                'total' => $paginatedData['total'],
                'pages' => $paginatedData['last_page'],
            ];
            $data = $paginatedData['data'];
        } else {
            $paginator = null;
        }

        return $response->withJson([
            'success' => true,
            'data' => $data,
            'paginator' => $paginator,
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