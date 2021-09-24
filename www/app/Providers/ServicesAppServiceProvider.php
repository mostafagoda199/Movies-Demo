<?php

namespace App\Providers;

use App\Domain\Responder\Classes\ApiHttpResponder;
use App\Domain\Responder\Interfaces\IApiHttpResponder;
use App\Domain\Services\Classes\GenresService;
use App\Domain\Services\Classes\MovieService;
use App\Domain\Services\Interfaces\IGenresService;
use App\Domain\Services\Interfaces\IMovieService;

class ServicesAppServiceProvider extends AppServiceProvider
{
    /**
     * @auther Mustafa Goda
     */
    public function boot()
    {
       $this->app->singleton(IApiHttpResponder::class,ApiHttpResponder::class);
       $this->app->singleton(IGenresService::class,GenresService::class);
       $this->app->singleton(IMovieService::class,MovieService::class);
    }
}
