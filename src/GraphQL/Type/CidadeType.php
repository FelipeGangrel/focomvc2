<?php

namespace Foco\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

use Foco\GraphQL\Types;

class CidadeType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Cidade',
            'description' => 'Cidade no sistema',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'nome' => [
                        'type' => Types::string(),
                    ],
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
}