<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Products::class;
    
    public function definition(): array
    {
        return [
            'productId' => $this->faker->numberBetween(1000000, 9999999),
            'productImage' => $this->faker->randomElement([
                'https://example.com/images/drug1.jpg',
                'https://example.com/images/drug2.jpg',
                'https://example.com/images/drug3.jpg'
            ]),
            'productTitle' => $this->faker->word . ' ' . $this->faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection']),
            'productCategory' => $this->faker->randomElement(['Analgesic', 'Antibiotic', 'Antipyretic', 'Antiseptic']),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'packetPrice' => $this->faker->randomFloat(2, 50, 200),
            'cartonPrice' => $this->faker->randomFloat(2, 200, 1000),
            'quantity' => $this->faker->numberBetween(10, 100),
            'expiryDate' => $this->faker->dateTimeBetween('+1 year', '+5 years')->format('Y-m-d'),
        ];
    }
}
