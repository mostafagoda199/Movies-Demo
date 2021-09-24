<?php

namespace App\Http\Controllers;

use App\Domain\Responder\Interfaces\IApiHttpResponder;
use App\Domain\Services\Interfaces\IGenresService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class GenresMovieController extends Controller
{

    /**
     * @param IApiHttpResponder $apiHttpResponder
     * @param IGenresService $genresService
     */
    public function __construct(private IApiHttpResponder $apiHttpResponder, private IGenresService $genresService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function seedMovieGenres(): JsonResponse
    {
        return $this->apiHttpResponder->response(message: $this->genresService->seedMoviesGenres());
    }

    /**
     * @return JsonResponse
     */
    public function getMovieGenres(): JsonResponse
    {
        return $this->apiHttpResponder->response(data:['genres' => $this->genresService->getMoviesGenres()]);
    }
}
