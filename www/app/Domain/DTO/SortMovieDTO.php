<?php

namespace App\Domain\DTO;

class SortMovieDTO extends DataTransferObject
{
    public string|null $popularity;
    public string|null $vote_average;

    public static function fromRequest($request): DataTransferObject
    {
        return new self([
            'popularity' => $request->popular?? null,
            'vote_average' => $request->rated?? null,
        ]);
    }
}
