<?php 

namespace Foco\Repository;

use Foco\Model\Endereco;

class EnderecosRepository extends BaseRepository
{
    protected $defaultRelations = [];

    public function __construct()
    {
        $this->model = new Endereco;
    }

}