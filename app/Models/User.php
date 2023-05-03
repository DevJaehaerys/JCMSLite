<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $fillable = [
        'name', 'steamid', 'avatar', 'balance', 'group',
    ];

    protected $casts = [
        'balance' => 'float',
    ];
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

}
