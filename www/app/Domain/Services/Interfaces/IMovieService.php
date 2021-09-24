<?php

namespace App\Domain\Services\Interfaces;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface IMovieService
{

    public function listMovies(array $conditions = [], array $orderBy = []): AnonymousResourceCollection;

    public function listRecentMovies(): AnonymousResourceCollection;

    public function getMovie(int $id);

    public function seedTopRatedMovies();

    public function seedTopRatedMoviesPerPage(string $type, int $page);

}
