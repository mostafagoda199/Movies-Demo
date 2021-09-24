<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('title',255)->nullable();
            $table->string('poster_path',255)->nullable();
            $table->double('popularity',11)->default(0.0);
            $table->double('vote_average',11)->default(0.0);
            $table->integer('vote_count')->default(0);
            $table->date('release_date')->nullable();
            $table->text('overview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
