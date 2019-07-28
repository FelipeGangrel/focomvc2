<?php

namespace Foco\Repository;

use Foco\Model\Aluno;

class AlunosRepository extends BaseRepository
{
    protected $defaultRelations = [
        'endereco'
    ];

    public function __construct()
    {
        $this->model = new Aluno;
    }

    public function create($data)
    {
        $aluno = $this->model->create($data);
        if (isset($data['endereco'])) {
            $aluno->endereco()->create($data['endereco']);
        }
        return $this->find($aluno->id);
    }

    public function update($id, $data)
    {
        $aluno = $this->find($id);
        $aluno->fill($data);
        $aluno->save();
        if (isset($data['endereco'])) {
            $endereco = $aluno->endereco;
            if (!is_null($endereco)) {
                $endereco->fill($data['endereco']);
                $endereco->save();
            } else {
                $aluno->endereco()->create($data['endereco']);
            }
        }
        return $this->find($id);
    }
}
