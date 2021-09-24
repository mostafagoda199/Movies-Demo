<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     *
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique->numberBetween(1 ,300),
            'title' => $this->faker->name,
            'popularity' => $this->faker->numerify('##.##'),
            'poster_path' => $this->faker->imageUrl,
            'release_date' => $this->faker->date,
            'vote_average' => $this->faker->numerify('##.##'),
            'vote_count' => $this->faker->numberBetween(1 ,3),
            'overview' => $this->faker->sentence,
        ];
    }
}
