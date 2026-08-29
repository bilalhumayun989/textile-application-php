<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact_info',
    ];

    /**
     * The attributes that should be cast.
     * Use encrypted cast for sensitive data.
     */
    protected $casts = [
        'name' => 'encrypted',
        'email' => 'encrypted',
        'phone' => 'encrypted',
        'address' => 'encrypted',
        'contact_info' => 'encrypted',
    ];

    /**
     * Get the transactions for the customer.
     */
    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class, 'customer_id');
    }
}
