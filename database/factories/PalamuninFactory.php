<?php

namespace Database\Factories;

use App\Models\Palamunin;
use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Factories\Factory;

class PalamuninFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Palamunin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'palamunin_no' => Utility::generate_unique_token(),
            'name'         => $this->faker->name(),
        ];
    }
}
