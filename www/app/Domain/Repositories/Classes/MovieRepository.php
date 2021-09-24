<?php

namespace App\Domain\Repositories\Classes;

use App\Domain\Repositories\Interfaces\IMovieRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MovieRepository extends AbstractRepository implements IMovieRepository
{
    /**
     * @param string $with
     * @param array $wherePivotCondition
     * @param array $orderBy
     * @return LengthAwarePaginator
     */
    public function wherePivotPaginate(string $with,array $wherePivotCondition = [] , array $orderBy = []): LengthAwarePaginator
    {
        return $this->model->whereHas($with, function ($q) use ($wherePivotCondition) {
            return $q->where($wherePivotCondition);
        })->when(!empty($orderBy), function ($query) use ($orderBy) {
            foreach ($orderBy as $key=>$value) {
                $query->orderBy($key,$value);
            }
        })->paginate(config('movies.element_number_per_page'));
    }
}
