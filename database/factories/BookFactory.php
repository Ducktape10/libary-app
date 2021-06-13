<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(2, 3),
            'authors' => $this->faker->name(2),
            'description' => $this->faker->text(),
            'released_at' => $this->faker->dateTime($max = 'now'),
            'cover_image' => null,
            'pages' => $this->faker->numberBetween(10, 100) + $this->faker->randomNumber($this->faker->numberBetween(1, 3)),
            'isbn' => $this->faker->ean13(),
            'in_stock' => $this->faker->numberBetween(1, 10)
        ];
    }
}
