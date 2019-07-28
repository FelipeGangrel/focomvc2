<?php

namespace Foco\Validator;

use Foco\Validator\ValidatorException;

class AlunoValidator
{
    protected $factory;

    public function __construct()
    {
        $this->factory = new ValidatorFactory;
    }

    public function beforeCreate($data)
    {
        $validator = $this->factory->make($data, $rules = [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            throw new ValidatorException("Erro de validação", 0, null, $errors);
        }
    }
}