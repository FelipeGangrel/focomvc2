<?php 

namespace Foco\Repository;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\AbstractPaginator as Paginator;

class BaseRepository
{
    // classe Model do repositorio
    protected $modelClass;

    private function newQuery()
    {
        return $this->modelClass->newQuery();
    }

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int|bool                          $take
     * @param bool                              $paginate
     * 
     * @return EloquentCollection|Paginator
     */
    private function doQuery($query = null, $take = 10, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate == true) {
            return $query->paginate($take);
        }

        if ($take > 0 || $take !== false) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * @param int   $take
     * @param bool  $paginate
     * 
     * @return EloquentCollection|Paginator
     */
    public function getAll($take = 10, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string        $column
     * @param string|null   $key
     * 
     * @return \Illuminate\Support\Collection
     */
    public function pluck($column, $key = null)
    {
        return $this->newQuery()->pluck($column, $key);
    }

    /**
     * @param int   $id
     * @param bool  $fail
     * 
     * @return Model
     */
    public function findById($id, $fail = true)
    {
        if ($fail == true) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }


}