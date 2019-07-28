<?php

namespace Foco\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Foco\Repository\AlunosRepository;

class AlunosController extends BaseController
{
    protected $alunosRepo;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->alunosRepo = new AlunosRepository;
    }

    public function index(Request $request, Response $response, array $args)
    {
        $params = $request->getQueryParams();
        $page = isset($params['page']) ? $params['page'] : 1;
        $count = isset($params['count']) ? $params['count'] : 10;
        $data = $this->alunosRepo->allPaginated($count, $page);
        return $this->successResponse($response, $data);
    }

    public function view(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $this->alunosRepo->find($id);
        return $this->successResponse($response, $data);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $body = $request->getParsedBody();
        $data = $this->alunosRepo->create($body);
        return $response->withJson($data);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $body = $request->getParsedBody();

        try {
            $data = $this->alunosRepo->update($id, $body);
            return $response->withJson($data);
        } catch (\Exception $e) {
            return $response->withJson([
                'success' => false,
                'error' => $e->getMessage(),
            ]);        
        } 
    }
}
