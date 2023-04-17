<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'steamid', 'avatar', 'balance',
    ];

    protected $casts = [
        'balance' => 'float',
    ];
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
