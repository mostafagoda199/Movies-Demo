<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Tests\TestCase;

class RecentMoviesTest extends TestCase
{
    /**
     * @auther Mustafa Goda
     */
    public function testUnAuthorizedUserCannotShowMovie()
    {
        $movie = Movie::factory()->create();
        $response = $this->json('get', route('movie.show',$movie->id),headers: ['Accept'=>'application/json']);
        $response->assertStatus(401);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testAuthorizeUserCanShowMovieDetails()
    {
        $this->actingAs(User::factory()->create());
        $movie = Movie::factory()->create();
        $this->assertDatabaseMissing('recent_movies',['user_id'=>auth()->user()->id]);
        $response = $this->json('get', route('movie.show',$movie->id),headers: ['Accept'=>'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('recent_movies',['user_id'=>auth()->user()->id]);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testAuthorizeUserCannotShowNotFoundMovie()
    {
        $this->actingAs(User::factory()->create());
        $this->assertDatabaseMissing('recent_movies',['user_id'=>auth()->user()->id]);
        $response = $this->json('get', route('movie.show',1),headers: ['Accept'=>'application/json']);
        $response->assertStatus(404);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testAuthorizeUserCanListRecentMoviesHeWatch()
    {
        $this->actingAs(User::factory()->create());
        $movie = Movie::factory()->create();
        $this->assertDatabaseMissing('recent_movies',['user_id'=>auth()->user()->id]);
        $response = $this->json('get', route('movie.show',$movie->id),headers: ['Accept'=>'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('recent_movies',['user_id'=>auth()->user()->id]);
        $recentMovies = $this->json('get', route('list.recent.movies'),headers: ['Accept'=>'application/json']);
        $recentMovies->assertStatus(200);
        $response->assertJsonStructure(['message','data' => []]);
    }
}
