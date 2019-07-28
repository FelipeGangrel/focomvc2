<?php

namespace Foco\Repository;

use Foco\Model\Aluno;
use Foco\Validator\AlunoValidator;

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
        try {

            $validator = new AlunoValidator;
            $validator->beforeCreate($data)->validate();

            $aluno = $this->model->create($data);
            if (isset($data['endereco'])) {
                $aluno->endereco()->create($data['endereco']);
            }
            return $this->find($aluno->id);
        } catch (\Foco\Validator\ValidatorException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
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
