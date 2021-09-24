<?php

namespace Tests\Feature;

use App\Jobs\SeedGenresJob;
use App\Models\Genres;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GenresTest extends TestCase
{
    /**
     * @auther Mustafa Goda
     */
    public function testSeedGenres()
    {
        Http::fake([
            config('movies.call_api') . 'genre/movie/*' => Http::response(['genres' => [
                ['id'=>1,'name'=>'genre'],
                ['id'=>2,'name'=>'genre2']
            ]]),
        ]);
        $seedGenresJob = new SeedGenresJob();
        $seedGenresJob->handle();
        $this->assertDatabaseHas('genres',['name'=>'genre']);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testInvalidSeedGenres()
    {
        Http::fake([
            config('movies.call_api') . 'genre/movie/*' => Http::response(['genres' => '' ]),
        ]);
        $seedGenresJob = new SeedGenresJob();
        $seedGenresJob->handle();
        $this->assertDatabaseMissing('genres',['name'=>'genre']);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testUnAuthorizedUserCannotListGenresMovies()
    {
        Genres::factory(20)->create();
        $response = $this->json('get', route('genres.list'),headers: ['Accept'=>'application/json']);
        $response->assertStatus(401);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testListGenresMovies()
    {
        $this->actingAs(User::factory()->create());
        Genres::factory(20)->create();
        $response = $this->json('get', route('genres.list'),headers: ['Accept'=>'application/json']);
        $response->assertOk();
        $response->assertJsonStructure(['message','data' => []]);
    }
}
