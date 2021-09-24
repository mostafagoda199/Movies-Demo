<?php

namespace Tests\Feature;

use App\Jobs\SeedPerPage;
use App\Models\Genres;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TopRatedMoviesTest extends TestCase
{
    /**
     * @auther Mustafa Goda
     */
    public function testSeedTopRatedMovies()
    {
        Http::fake([
            config('movies.call_api') . 'movie/*' => Http::response([
                'total_pages' => 1,
                'results' => json_decode(file_get_contents(storage_path('test_files/movies.json')),true)]),
        ]);
        $seedTopRatedPerPage = new SeedPerPage('top_rated',2);
        $seedTopRatedPerPage->handle();
        $this->assertDatabaseHas('movies',['id'=>709629]);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testUnAuthorizedUserCannotShowTopRatedMovies()
    {
        Movie::factory(20)->create();
        $response = $this->json('get', route('list.rated.movies'),headers: ['Accept'=>'application/json']);
        $response->assertStatus(401);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testGetListOfMovies()
    {
        $this->actingAs(User::factory()->create());
        Movie::factory(20)->create();
        $response = $this->json('get', route('list.rated.movies'),headers: ['Accept'=>'application/json']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message','data' => []]);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testUserCanListMoviesByCategory()
    {
        $this->actingAs(User::factory()->create());
        Genres::factory(5)->create();
        $genre = Genres::factory()->create();
        Movie::factory(20)->create()->each(function ($movie) {
           $genres = Genres::factory()->create();
           $genres->movies()->attach($movie->id);
        });
        Movie::factory(8)->create()->each(function ($movie) use($genre) {
           $genre->movies()->attach($movie->id);
        });
        $response = $this->json('get', route('list.rated.movies'),['category'=>$genre->id],headers: ['Accept'=>'application/json']);
        $response->assertStatus(200);
        $response->assertJsonCount(8,'data.movies');
        $response->assertJsonStructure(['message','data' => []]);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testUserCanListSortedMoviesByPopularity()
    {
        $this->actingAs(User::factory()->create());
        Movie::factory(20)->create()->each(function ($movie) {
            $genres = Genres::factory()->create();
            $genres->movies()->attach($movie->id);
        });

        $firstResponse = $this->json('get', route('list.rated.movies'), ['popular'=>'desc'],['Accept'=>'application/json']);
        $secondResponse = $this->json('get', route('list.rated.movies'), ['popular'=>'asc'],['Accept'=>'application/json']);
        $this->assertNotEquals(
            $firstResponse->json('data.movies.0.popularity'),
            $secondResponse->json('data.movies.0.popularity')
        );
    }

    /**
     * @auther Mustafa Goda
     */
    public function testUserCanListSortedMoviesByRate()
    {
        $this->actingAs(User::factory()->create());
        Movie::factory(20)->create()->each(function ($movie) {
            $genres = Genres::factory()->create();
            $genres->movies()->attach($movie->id);
        });

        $firstResponse = $this->json('get', route('list.rated.movies'), ['rated'=>'desc'],['Accept'=>'application/json']);
        $secondResponse =   $this->json('get', route('list.rated.movies'), ['rated'=>'asc'],['Accept'=>'application/json']);
         $this->assertNotEquals(
             $firstResponse->json('data.movies.0.vote_average'),
             $secondResponse->json('data.movies.0.vote_average')
         );
    }
}
