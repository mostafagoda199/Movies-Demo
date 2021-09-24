<?php

namespace App\Jobs;

use App\Domain\Services\Interfaces\IMovieService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SeedPerPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private string $type, private int $page)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        resolve(IMovieService::class)->seedTopRatedMoviesPerPage($this->type,$this->page);
    }
}
