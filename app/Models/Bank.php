<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name', 'balance', 'wallet_id'];

    protected $casts = [
        'balance' => 'encrypted'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
