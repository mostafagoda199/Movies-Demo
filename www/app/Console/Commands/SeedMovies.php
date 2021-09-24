<?php

namespace App\Console\Commands;

use App\Jobs\SeedGenresJob;
use App\Jobs\TopRatedMoviesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class SeedMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed top rated movies and recent movies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Start seeding genres and top rated movies');
        Bus::chain([
            new SeedGenresJob(),
            new TopRatedMoviesJob(),
        ])->dispatch();
        return 0;
    }
}
