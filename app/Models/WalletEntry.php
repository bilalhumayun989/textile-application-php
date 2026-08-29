<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletEntry extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_id', 'type', 'amount', 'description', 'payment_method'];

    /**
     * Sensitive transaction amounts and descriptions are encrypted.
     */
    protected $casts = [
        'amount' => 'encrypted',
        'description' => 'encrypted',
        'payment_method' => 'encrypted',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}