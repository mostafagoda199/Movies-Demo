<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $genres = [];
        if (isset($this->genres) && !empty($this->genres)) {
            foreach ($this->genres as $genre) {
                $genres[] =  new GenresResource($genre);
            }
        }

        return [
            'id'=>$this?->id,
            'title'=>$this?->title,
            'popularity'=>$this?->popularity,
            'poster_path'=>$this?->poster_path,
            'release_date'=>$this?->release_date,
            'vote_average'=>$this?->vote_average,
            'vote_count'=>$this?->vote_count,
            'overview'=>$this?->overview,
            'genres'=>$genres,
            'created_at'=> date('Y-m-d H:i:s',strtotime($this?->created_at)),
            'updated_at'=>date('Y-m-d H:i:s',strtotime($this?->updated_at)),
        ];
    }
}
