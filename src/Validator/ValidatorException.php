<?php

namespace Foco\Validator;

use \Exception;
use Illuminate\Support\MessageBag;

class ValidatorException extends Exception
{
    private $errors;

    public function __construct($message, $code = 0, Exception $previous = null, $errors)
    {
        // para garantir que tudo está instanciado
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}