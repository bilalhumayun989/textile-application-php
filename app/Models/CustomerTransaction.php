<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'debit',
        'credit',
        'balance',
        'description',
        'payment_method',
    ];

    /**
     * Financial data is encrypted at the application level.
     */
    protected $casts = [
        'debit' => 'encrypted',
        'credit' => 'encrypted',
        'balance' => 'encrypted',
        'description' => 'encrypted',
    ];

    /**
     * Automatically calculate running balance when creating a record.
     */
    protected static function booted()
    {
        static::creating(function (CustomerTransaction $tx) {
            // Decrypt previous balance by fetching via model instance
            $lastTx = self::where('customer_id', $tx->customer_id)
                ->orderBy('id', 'desc')
                ->first();

            $previous = $lastTx ? (float)$lastTx->balance : 0;
            $tx->balance = $previous + (float)$tx->debit - (float)$tx->credit;
        });
    }

    // Eloquent will use the default pluralized name (customer_transactions);
    // explicit property removed to avoid typo.

    /**
     * Customer relationship.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
