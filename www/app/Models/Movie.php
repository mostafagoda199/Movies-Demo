<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $with = ['genres'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'title',
        'popularity',
        'poster_path',
        'release_date',
        'vote_average',
        'vote_count',
        'overview',
    ];

    public $incrementing = false;

    /**
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genres::class,'movie_genres')->withTimestamps();
    }


    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'recent_movies')->withTimestamps();
    }
}
