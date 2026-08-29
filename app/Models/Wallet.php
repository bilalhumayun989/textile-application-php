<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    /**
     * Use encryption to protect wallet identity details.
     */
    protected $casts = [
        'name' => 'encrypted',
        'email' => 'encrypted',
        'phone' => 'encrypted',
    ];

    public function entries()
    {
        return $this->hasMany(WalletEntry::class);
    }

    public function nets()
    {
        return $this->hasMany(WalletNet::class);
    }
}