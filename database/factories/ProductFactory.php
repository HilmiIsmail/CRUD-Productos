<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));
        $stock = random_int(0, 99);
        $stock =  ($stock <= 10 && $stock >= 0) ? 0 : $stock;
        return [
            'nombre' => fake()->unique()->sentence(),
            'descripcion' => fake()->text(),
            'stock' => $stock,
            'disponible' => ($stock) ? "SI" : "NO",
            'imagen' => "productos/" . fake()->picsum('public/storage/productos', 640, 480, false),
            'pvp' => fake()->randomFloat(2, 1, 9999.99),
            'user_id' => User::all()->random()->id,
        ];
    }
}
