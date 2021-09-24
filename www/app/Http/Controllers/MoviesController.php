<?php

namespace App\Http\Controllers;

use App\Domain\DTO\FilterMovieDTO;
use App\Domain\DTO\SortMovieDTO;
use App\Domain\Responder\Interfaces\IApiHttpResponder;
use App\Domain\Services\Interfaces\IMovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * @param IApiHttpResponder $apiHttpResponder
     * @param IMovieService $movieService
     * @auther Mustafa Goda
     */
    public function __construct(private IApiHttpResponder $apiHttpResponder, private IMovieService $movieService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listMovies(Request $request): JsonResponse
    {
        return $this->apiHttpResponder->response(data:['movies' => $this->movieService->listMovies(
            conditions: array_filter((array) FilterMovieDTO::fromRequest($request)),
            orderBy: array_filter((array) SortMovieDTO::fromRequest($request))
        )]);
    }

    /**
     * @return JsonResponse
     */
    public function listRecentMovies(): JsonResponse
    {
        return $this->apiHttpResponder->response(data:['movies' => $this->movieService->listRecentMovies()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMovie(Request $request): JsonResponse
    {
        return $this->apiHttpResponder->response(data: [$this->movieService->getMovie((int) $request?->id)]);
    }
}
