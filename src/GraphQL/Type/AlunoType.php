<?php

namespace Foco\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

use Foco\GraphQL\Types;

class AlunoType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Aluno',
            'description' => 'Aluno no sistema',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'nome' => [
                        'type' => Types::string(),
                        'description' => 'Nome completo do Aluno',
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'E-mail no Aluno'
                    ],
                    'endereco' => [
                        'type' => Types::endereco(),
                        'description' => 'Endereço do Aluno'
                    ]
                ];
            },
            'interfaces' => [
                Types::node()
            ],
            'resolveField' => function($model, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($model, $args, $context, $info);
                } else {
                    return $model->{$info->fieldName};
                }
            }
        ];

        parent::__construct($config);
    }

    // implementar métodos para os campos cujos nomes não existem no Model
    // Este método não é necessário neste type, mas vou deixar como referência
    public function resolveEndereco($model, $args, $context, $ingo)
    {
        $endereco = $model->endereco;
        return $endereco;
    }
}