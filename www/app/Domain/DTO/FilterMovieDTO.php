<?php

namespace App\Domain\DTO;

class FilterMovieDTO extends DataTransferObject
{
    public int|null $genres_id;

    public static function fromRequest($request): DataTransferObject
    {
        return new self([
            'genres_id' => $request->category?? null,
        ]);
    }
}
