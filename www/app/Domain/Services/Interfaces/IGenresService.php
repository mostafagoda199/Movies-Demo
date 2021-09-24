<?php

namespace App\Domain\Services\Interfaces;

interface IGenresService
{
    public function seedMoviesGenres();

    public function getMoviesGenres();
}
