<?php

namespace Foco\GraphQL\Type;

use Illuminate\Pagination\Paginator;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use Foco\GraphQL\Types;

class QueryType extends ObjectType
{
    public function __construct()
    {
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
                            'type' => Types::id(),
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
                            'type' => Types::id(),
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
        return \Foco\Model\Aluno::find($args['id']);
    }

    public function alunos($rootValue, $args)
    {
        $count = $args['count'];
        $page = $args['page'];
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        return \Foco\Model\Aluno::paginate($count);
    }

    public function endereco($rootValue, $args)
    {
        return \Foco\Model\Endereco::find($args['id']);
    }

    public function enderecos($rootValue, $args)
    {
        $count = $args['count'];
        $page = $args['page'];
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        return \Foco\Model\Endereco::paginate($count);
    }
}
