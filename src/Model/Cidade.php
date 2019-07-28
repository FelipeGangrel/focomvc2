<?php

namespace Foco\Model;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = "cidades";
    
    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }
}