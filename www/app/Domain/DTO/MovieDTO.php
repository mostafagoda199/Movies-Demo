<?php

namespace App\Domain\DTO;

class MovieDTO extends DataTransferObject
{

    public int $id;
    public string  $title;
    public float  $popularity;
    public string  $poster_path;
    public string  $release_date;
    public float  $vote_average;
    public int  $vote_count;
    public string  $overview;

    public static function fromRequest($request): DataTransferObject
    {
        return new self([
            'id' => optional($request)['id'],
            'title' => optional($request)['title'],
            'popularity' => optional($request)['popularity'],
            'poster_path' => optional($request)['poster_path'],
            'release_date' => optional($request)['release_date'],
            'vote_average' => optional($request)['vote_average'],
            'vote_count' => optional($request)['vote_count'],
            'overview' => optional($request)['overview'],
        ]);
    }
}
