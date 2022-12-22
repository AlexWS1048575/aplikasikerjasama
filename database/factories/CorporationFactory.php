<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corporation>
 */
class CorporationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'title' => $this->faker->text(),
            'document_no' => $this->faker->text(),
            'assignment_date' => $this->faker->date(),
            'summary' => $this->faker->text(),
            'duration' => $this->faker->date(),
            'status_id' => $this->faker->sentence(),
            'type_id' => $this->faker->imageUrl(),
            'corporationtype_id' => $this->faker->text(),
        ];
    }
}
