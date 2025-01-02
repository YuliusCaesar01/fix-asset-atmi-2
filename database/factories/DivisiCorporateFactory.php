<?php

namespace Database\Factories;

use App\Models\DivisiCorporate;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivisiCorporateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DivisiCorporate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_divisicorp' => $this->faker->company . ' Division',
            'kode_divisicorp' => $this->faker->unique()->text(5),
            // Add more attributes as needed
        ];
    }
}

