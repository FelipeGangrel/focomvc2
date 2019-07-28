<?php

namespace Foco\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = "enderecos";
    protected $fillable = ['logradouro', 'bairro', 'cidade_id'];
    protected $hidden = ['enderecoable_type', 'enderecoable_id'];

    public function enderecoable()
    {
        return $this->morphTo();
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }
}
