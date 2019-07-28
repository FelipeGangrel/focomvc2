<?php 

namespace Foco\GraphQL;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\Type;

use Foco\GraphQL\Type\AlunoType;
use Foco\GraphQL\Type\QueryType;
use Foco\GraphQL\Type\NodeType;
use Foco\GraphQL\Type\EnderecoType;
use Foco\GraphQL\Type\CidadeType;

/**
 * Funcionará como registro e factory para
 * nossos types
 */
class Types
{
    
    private static $aluno;
    public static function aluno()
    {
        return self::$aluno ?: (self::$aluno = new AlunoType());
    }

    private static $endereco;
    public static function endereco()
    {
        return self::$endereco ?: (self::$endereco = new EnderecoType());
    }

    private static $cidade;
    public static function cidade()
    {
        return self::$cidade ?: (self::$cidade = new CidadeType());
    }

    private static $query;
    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    private static $node;
    public static function node()
    {
        return self::$node ?: (self::$node = new NodeType());
    }
    
    // Adicionando types internos do GraphQL também para ficar mais fácil

    public static function boolean()
    {
        return Type::boolean();
    }

    /**
     * @return \GraphQL\Type\Definition\FloatType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return \GraphQL\Type\Definition\IDType
     */
    public static function id()
    {
        return Type::id();
    }

    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @param Type $type
     * @return NonNull
     */
    public static function nonNull($type)
    {
        return new NonNull($type);
    }
}