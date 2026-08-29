<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletNet extends Model
{
    use HasFactory;

    protected $fillable = ['wallet_id', 'received_total', 'used_total', 'net_amount', 'focus'];

    /**
     * Summary calculation data is encrypted for privacy.
     */
    protected $casts = [
        'received_total' => 'encrypted',
        'used_total' => 'encrypted',
        'net_amount' => 'encrypted',
        'focus' => 'encrypted',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}