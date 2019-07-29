<?php

namespace Foco\GraphQL\Type;

use Illuminate\Pagination\Paginator;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use Foco\GraphQL\Types;
use Foco\Repository;

class QueryType extends ObjectType
{

    protected $alunosRepo;
    protected $enderecosRepo; 

    public function __construct()
    {
        $this->alunosRepo = new Repository\AlunosRepository;
        $this->enderecosRepo = new Repository\EnderecosRepository;

        $config = [
            'name' => 'Query',
            'fields' => [
                'aluno' => [
                    'type' => Types::aluno(),
                    'description' => 'Retorna Aluno através de seu id',
                    'args' => [
                        'id' => Types::nonNull(Types::id())
                    ]
                ],
                'alunos' => [
                    'type' => Types::listOf(Types::aluno()),
                    'description' => 'Retorna uma coleção de Alunos',
                    'args' => [
                        'count' => [
                            'type' => Types::int(),
                            'description' => 'Quantidade de items a serem colocados na coleção',
                        ],
                        'page' => [
                            'type' => Types::int(),
                            'description' => 'Número da página a ser entregue'
                        ]
                    ]
                ],
                'endereco' => [
                    'type' => Types::endereco(),
                    'description' => 'Retorna um Endereco através de seu id',
                    'args' => [
                        'id' => Types::nonNull(Types::id())
                    ]
                ],
                'enderecos' => [
                    'type' => Types::listOf(Types::endereco()),
                    'description' => 'Retorna uma coleção de Enderecos',
                    'args' => [
                        'count' => [
                            'type' => Types::int(),
                            'description' => 'Quantidade de items a serem colocados na coleção',
                        ],
                        'page' => [
                            'type' => Types::int(),
                            'description' => 'Número da página a ser entregue'
                        ]
                    ]
                ]
            ],
            'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function aluno($rootValue, $args)
    {
        return $this->alunosRepo->find($args['id']);
    }

    public function alunos($rootValue, $args)
    {
        $count = $args['count'];
        $page = $args['page'];
        return $this->alunosRepo->allPaginated($count, $page);
    }

    public function endereco($rootValue, $args)
    {
        return $this->enderecosRepo->find($args['id']);
    }

    public function enderecos($rootValue, $args)
    {
        $count = $args['count'];
        $page = $args['page'];
        return $this->enderecosRepo->allPaginated($count, $page);
    }
}
