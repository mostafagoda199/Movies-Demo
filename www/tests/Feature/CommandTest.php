<?php

namespace Tests\Feature;

use App\Jobs\SeedGenresJob;
use App\Jobs\SeedPerPage;
use App\Jobs\TopRatedMoviesJob;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * @auther Mustafa Goda
     */
    public function testSeedMoviesCommand()
    {
        $this->artisan('seed:movies')
            ->expectsOutput('Start seeding genres and top rated movies')
            ->assertExitCode(0);
    }

    /**
     * @auther Mustafa Goda
     */
    public function testSeedingInJobChainAndPatch()
    {
        Bus::fake();
        Queue::fake();
        Http::fake([
            config('movies.call_api') . 'movie/*' => Http::response(['total_pages' => 2, 'results' => []]),
        ]);
        Artisan::call('seed:movies');
        Bus::assertChained([
            SeedGenresJob::class,
            TopRatedMoviesJob::class,
        ]);
        $topRatedJob = new TopRatedMoviesJob();
        $topRatedJob->handle();
        Bus::assertBatched(function (PendingBatch $batch) {
            return $batch->name == '' &&
                $batch->jobs->count() === 2;
        });
    }

    /**
     * @auther Mustafa Goda
     */
    public function testTopRatedMoviesJobDispatchesSeedPerPage()
    {
        Queue::fake();
        Http::fake([
            config('movies.call_api') . 'movie/*' => Http::response(['total_pages' => 2, 'results' => []]),
        ]);
        $topRatedJob = new TopRatedMoviesJob();
        $topRatedJob->handle();
        Queue::assertPushed(SeedPerPage::class);
    }
}
