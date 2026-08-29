<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wallet;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->optional()->safeEmail,
            'phone' => $this->faker->optional()->phoneNumber,
        ];
    }
}
