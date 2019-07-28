<?php

namespace Foco\GraphQL\Type;

use GraphQL\Type\Definition\InterfaceType;
use Foco\GraphQL\Types;
use Foco\Model\Aluno;

class NodeType extends InterfaceType
{
    public function __construct()
    {
        $config = [
            'name' => 'Node',
            'fields' => [
                'id' => Types::id()
            ],
            'resolveType' => [$this, 'resolveNodeType']
        ];
        parent::__construct($config);
    }

    public function resolveNodeType($object)
    {
        if ($object instanceof Aluno) {
            return Types::aluno();
        }
    }
}
