<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'command', 'image', 'user_id', 'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->command = str_replace('%player%', $model->user->steamid, $model->command);

            if (str_contains($model->command, '%count%')) {
                $model->command = str_replace('%count%', request()->input('count'), $model->command);
            }
        });
    }



}
