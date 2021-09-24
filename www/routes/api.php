<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenresMovieController;
use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/seed-genres',[GenresMovieController::class,'seedMovieGenres']);
    Route::get('/list-genres',[GenresMovieController::class,'getMovieGenres'])->name('genres.list');
    Route::get('/movie/{id}',[MoviesController::class,'getMovie'])->name('movie.show');
    Route::get('/rated-movies',[MoviesController::class,'listMovies'])->name('list.rated.movies');
    Route::get('/recent-movies',[MoviesController::class,'listRecentMovies'])->name('list.recent.movies');
    Route::post('/logout', [AuthController::class, 'logout']);
});


