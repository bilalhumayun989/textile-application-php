<?php

namespace Database\Factories;

use App\Models\CustomerTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTransactionFactory extends Factory
{
    protected $model = CustomerTransaction::class;

    public function definition()
    {
        $types = ['opening_balance','deposit','sale','payment_received','return','discount'];
        $type = $this->faker->randomElement($types);
        $amount = $this->faker->randomFloat(2, 1, 1000);
        $debit = 0;
        $credit = 0;

        switch ($type) {
            case 'sale':
            case 'opening_balance':
                $debit = $amount;
                break;
            default:
                $credit = $amount;
                break;
        }

        return [
            'customer_id' => User::factory(),
            'type' => $type,
            'debit' => $debit,
            'credit' => $credit,
            'description' => $this->faker->sentence,
        ];
    }
}
