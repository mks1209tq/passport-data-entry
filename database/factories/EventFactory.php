<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\event;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'designation' => fake()->regexify('[A-Za-z0-9]{100}'),
            'comapanyName' => fake()->regexify('[A-Za-z0-9]{100}'),
            'category' => fake()->regexify('[A-Za-z0-9]{100}'),
            'proposalBy' => fake()->regexify('[A-Za-z0-9]{100}'),
            'company' => fake()->company(),
            'RSVP' => fake()->regexify('[A-Za-z0-9]{100}'),
            'tableAllocation' => fake()->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
