<?php

namespace App\Domain\Services\Classes;

use App\Domain\DTO\MovieDTO;
use App\Domain\Repositories\Interfaces\IMovieRepository;
use App\Domain\Services\Interfaces\IMovieService;
use App\Exceptions\CustomExceptions\ApiNotFoundException;
use App\Http\Resources\MovieResource;
use App\Jobs\SeedPerPage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Throwable;

class MovieService implements IMovieService
{
    public const TYPE_TOP_RELATED = 'top_rated';

    /**
     * @param IMovieRepository $movieRepository
     */
    public function __construct(private IMovieRepository $movieRepository)
    {
    }

    /**
     * @param array $conditions
     * @param array $orderBy
     * @return AnonymousResourceCollection
     */
    public function listMovies(array $conditions = [], array $orderBy = []): AnonymousResourceCollection
    {
        if (isset($conditions['genres_id'])) {
            $response = $this->movieRepository->wherePivotPaginate(
                with:'genres',
                wherePivotCondition:$conditions,
                orderBy: $orderBy
            );
        }else{
            $response = $this->movieRepository->getPaginate(
                conditions:$conditions,
                orderBy: $orderBy
            );
        }
        return MovieResource::collection($response);
    }

    public function listRecentMovies(): AnonymousResourceCollection
    {
        $response = auth()->user()->movies()->orderBy('pivot_created_at','desc')->paginate(config('movies.element_number_per_page'));
        return MovieResource::collection($response);
    }

    /**
     * @param int $id
     * @return MovieResource
     * @throws ApiNotFoundException
     */
    public function getMovie(int $id): MovieResource
    {
        try {
            $movie = $this->movieRepository->findOrFail($id);
            auth()->user()->movies()->detach($id);
            auth()->user()->movies()->attach($id);
        }catch (Throwable $exception){
            throw new ApiNotFoundException(trans('message.movie_not_found'));
        }
        return new MovieResource($movie);
    }

    /**
     * @throws Throwable
     */
    public function seedTopRatedMovies(): string
    {
        $batchJobArray = [];
        for ($page = 1; $page <= $this->totalPages(self::TYPE_TOP_RELATED); $page++) {
            $batchJobArray[] = new SeedPerPage(self::TYPE_TOP_RELATED,$page);
        }
        $batch = Bus::batch($batchJobArray)->dispatch();
        return $batch->id;
    }

    /**
     * @param string $type
     * @param int $page
     */
    public function seedTopRatedMoviesPerPage(string $type, int $page){
        $pageMovies = $this->getMoviesFrom3rdParty( $type ,$page)['results'];
        foreach ($pageMovies as $movie) {
            $movieDTO = (array) MovieDTO::fromRequest($movie);
            $movieRepo = $this->movieRepository->create($movieDTO);
            $movieRepo->genres()->attach($movie['genre_ids']);
        }
    }

    /**
     * @param string $type
     * @param int $page
     * @return mixed
     */
    private function getMoviesFrom3rdParty(string $type , int $page = 1): mixed
    {
       return Http::get(config('movies.call_api') . 'movie/' . $type . '?api_key=' . config('movies.api_key').'&language=en-US&page='.$page)->json();
    }

    /**
     * @param string $type
     * @return ?int
     */
    private function totalPages(string $type): ?int
    {
      return optional($this->getMoviesFrom3rdParty($type))['total_pages'];
    }


}
