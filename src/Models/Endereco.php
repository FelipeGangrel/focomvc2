<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = "enderecos";
    protected $fillable = ['logradouro', 'bairro', 'cidade'];

    public function enderecoable()
    {
        $this->morphTo();
    }
}
