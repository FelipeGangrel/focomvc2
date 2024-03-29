<?php

namespace Foco\Repository;

use Foco\Model\Aluno;
use Foco\Validator\AlunoValidator;

class AlunosRepository extends BaseRepository
{
    protected $validator;
    protected $defaultRelations = ['endereco','endereco.cidade'];

    public function __construct()
    {
        $this->model = new Aluno;
        $this->validator = new AlunoValidator;
    }

    public function create($data)
    {
        try {
            $this->validator->beforeCreate($data);

            $aluno = $this->model->create($data);
            if (isset($data['endereco'])) {
                $aluno->endereco()->create($data['endereco']);
            }
            return $this->find($aluno->id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $this->validator->beforeUpdate($data, $id);

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
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
