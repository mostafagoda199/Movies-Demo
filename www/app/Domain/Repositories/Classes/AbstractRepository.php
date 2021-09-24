<?php

namespace App\Domain\Repositories\Classes;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{

    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $data): mixed
    {
       return $this->model->updateOrCreate($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
       return $this->model->create($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findOrFail(int $id): mixed
    {
       return $this->model->findOrFail($id);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @param array $orderBy
     * @return mixed
     */
    public function getPaginate(array $conditions = [], array $with = [], array $select = ['*'],array $orderBy = []): mixed
    {
      return $this->prepareQuery($conditions,$with,$select)
            ->when(!empty($orderBy), function ($query) use ($orderBy) {
                foreach ($orderBy as $key=>$value) {
                    $query->orderBy($key,$value);
                }
            })->paginate(config('movies.element_number_per_page'));
    }

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function prepareQuery(array $conditions = [], array $with = [], array $select = []): mixed
    {
        return $this->model->with($with)->where($conditions)->select($select);
    }
}
