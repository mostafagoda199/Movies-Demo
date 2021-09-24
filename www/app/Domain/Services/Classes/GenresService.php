<?php

namespace App\Domain\Services\Classes;

use App\Domain\Repositories\Interfaces\IGenresRepository;
use App\Domain\Services\Interfaces\IGenresService;
use App\Exceptions\CustomExceptions\ApiValidationException;
use App\Http\Resources\GenresResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use Throwable;

class GenresService implements IGenresService
{
    public function __construct(private IGenresRepository $genresRepository)
    {
    }

    /**
     * @throws ApiValidationException
     */
    public function seedMoviesGenres() : ?string
    {
        try {
            $response =  Http::get(config('movies.call_api').'genre/movie/list?api_key='.config('movies.api_key'))->json();
            if (isset($response['genres'])&& !empty($response['genres'])){
                foreach ($response['genres'] as $genre) {
                    $this->genresRepository->updateOrCreate($genre);
                }
            }
        }catch (Throwable $exception) {
            throw new ApiValidationException(trans('message.invalid_seed'));
        }
        return trans('message.seeding_success');
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getMoviesGenres(): AnonymousResourceCollection
    {
       return GenresResource::collection($this->genresRepository->getPaginate());
    }

}
