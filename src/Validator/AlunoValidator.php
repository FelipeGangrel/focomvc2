<?php

namespace Foco\Validator;

use Illuminate\Validation\Rule;
use Foco\Validator\ValidatorException;

class AlunoValidator
{
    protected $factory;

    public function __construct($container)
    {
        $this->factory = new ValidatorFactory($container->database);
    }

    public function beforeCreate($data)
    {
        $validator = $this->factory->make($data, $rules = [
            'nome' => 'required|max:255',
            'email' => 'required|email|unique:alunos,email|max:255',
            'endereco.logradouro' => 'required_with:endereco.bairro,endereco.cidade_id',
            'endereco.bairro' => 'required_with:endereco.logradouro,endereco.cidade_id',
            'endereco.cidade_id' => 'required_with:endereco.logradouro,endereco.bairro',
        ], $messages = [
            'nome.required' => 'O campo nome é obrigatório!!!', // podemos adicionar mensagens customizadas também
            'nome.max' => 'O campo nome tem um comprimento superior a 255',
            'endereco.*.required_with' => 'O endereço deve ser completo ou não ser informado'
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            throw new ValidatorException("Erro de validação", 0, null, $errors);
        }
    }

    public function beforeUpdate($data, $id)
    {
        $validator = $this->factory->make($data, $rules = [
            'nome' => 'max:255',
            'email' => [
                'email',
                'max:255',
                Rule::unique('alunos')->ignore($id) // ignorar a regra caso seja o próprio aluno
            ],
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            throw new ValidatorException("Erro de validação", 0, null, $errors);
        }
    }
}