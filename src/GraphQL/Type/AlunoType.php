<?php

namespace Foco\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

use Foco\Model\Aluno;
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
                    ],
                    'email' => [
                        'type' => Types::string(),
                    ]
                ];
            },
            'interfaces' => [
                Types::node()
            ],
            'resolveField' => function(Aluno $aluno, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($aluno, $args, $context, $info);
                } else {
                    return $aluno->{$info->fieldName};
                }
            }
        ];

        parent::__construct($config);
    }

    // implementar métodos para os campos cujos nomes não existem no Model
}