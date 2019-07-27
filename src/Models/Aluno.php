<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = "alunos";
    protected $fillable = ['nome', 'email'];

    public function endereco()
    {
        return $this->morphOne('\Models\Endereco', 'enderecoable');
    }
}
