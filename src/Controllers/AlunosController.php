<?php

namespace Controllers;

use Illuminate\Pagination\Paginator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Models\Aluno;
use Models\Endereco;

class AlunosController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $page = isset($queryParams['page']) ? $queryParams['page'] : 1;
        $limit = isset($queryParams['limit']) ? $queryParams['limit'] : 10;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Aluno::with('endereco')->paginate($limit);

        return $response->withJson($data);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $body = $request->getParsedBody();
        $aluno = Aluno::create($body);

        if (isset($body['endereco'])) {
            $aluno->endereco()->create($body['endereco']);
        }

        $data = Aluno::with(['endereco'])->find($aluno->id);

        return $response->withJson($data);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $body = $request->getParsedBody();

        try {
            
            $aluno = Aluno::findOrFail($id);
            $aluno->fill($body);
            $aluno->save();
    
            if (isset($body['endereco'])) {
                $endereco = $aluno->endereco;
    
                if (!is_null($endereco)) {
                    $endereco->fill($body['endereco']);
                    $endereco->save();
                } else {
                    $aluno->endereco()->create($body['endereco']);
                }
            }
    
            $data = Aluno::with(['endereco'])->find($id);
            return $response->withJson($data);
        } catch (\Exception $e) {
            return $response->withJson([
                'success' => false,
                'error' => $e->getMessage(),
            ]);        
        }

    }
}
