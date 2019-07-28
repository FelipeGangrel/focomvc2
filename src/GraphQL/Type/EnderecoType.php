<?php

namespace Foco\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

use Foco\Model\Endereco;
use Foco\GraphQL\Types;

class EnderecoType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Endereco',
            'description' => 'Endereço de uma entidade no sistema',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'logradouro' => [
                        'type' => Types::string(),
                    ],
                    'bairro' => [
                        'type' => Types::string(),
                    ],
                ];
            },
            'interfaces' => [
                Types::node()
            ],
            'resolveField' => function(Endereco $aluno, $args, $context, ResolveInfo $info) {
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
