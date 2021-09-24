<?php

namespace App\Domain\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IMovieRepository
{
    public function wherePivotPaginate(string $with,array $wherePivotCondition = [],array $orderBy = []): LengthAwarePaginator;
}
