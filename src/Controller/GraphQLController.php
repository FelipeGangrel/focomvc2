<?php

namespace Foco\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

use GraphQL\GraphQL;
use GraphQL\Validator\Rules\DisableIntrospection;
use GraphQL\Validator\DocumentValidator;
use GraphQL\Validator\Rules\QueryDepth;
use GraphQL\Error\FormattedError;
use GraphQL\Type\Schema;

use Foco\GraphQL\Types;
use Foco\GraphQL\AppContext;

class GraphQLController extends BaseController
{
    protected $maxDepth;
    protected $introspection;
    protected $debug;

    public function __construct(ContainerInterface $container, int $maxDepth = 15, bool $introspection = true, int $debug = 0)
    {
        parent::__construct($container);

        $this->maxDepth = $maxDepth;
        $this->introspection = $introspection;
        $this->debug = $debug;
    }

    public function __invoke(Request $request, Response $response)
    {

        try {

            $appContext = new AppContext();
            $appContext->request = $request;

            $input = json_decode($request->getBody(), true);
            $query = isset($input['query']) ? $input['query'] : null;
            $variableValues = isset($input['variables']) ? $input['variables'] : null;

            $schema = new Schema([
                'query' => Types::query()
            ]);

            $schema->assertValid();

            $result = GraphQL::executeQuery(
                $schema,
                $query,
                null,
                $appContext,
                (array) $variableValues
            );

            $output = $result->toArray($this->debug);

            if (!$this->introspection) {
                DocumentValidator::addRule(new DisableIntrospection());
            }

            DocumentValidator::addRule(new QueryDepth($this->maxDepth));
        } catch (\Exception $e) {
            $output['errors'] = [
                FormattedError::createFromException($e, $this->debug)
            ];
        }

        return $response->withJson($output);
    }
}
