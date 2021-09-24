<?php

namespace Database\Factories;

use App\Models\Genres;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenresFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genres::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique->numberBetween(1 ,200),
            'name' => $this->faker->name,
        ];
    }
}
