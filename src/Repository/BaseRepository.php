<?php

namespace Foco\Repository;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with($this->defaultRelations)->get();
    }

    public function allPaginated($count = 10, $page = 1)
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        return $this->model->with($this->defaultRelations)->paginate($count);
    }

    public function find($id)
    {
        return $this->model->with($this->defaultRelations)->findOrFail($id);
    }
}
