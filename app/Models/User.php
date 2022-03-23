<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected static function booted()
    {
        static::saved(function ($user) {
            Account::create([
                'user_id' => $user->user_id,
                'name'    => $user->name,
            ]);
        });
    }

    // This is needed because I changed the Id column name in the User model.
    protected $primaryKey = 'user_id';

    protected $guarded = ['user_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['account'];

    public function account()
    {
        return $this->hasOne(Account::class, 'user_id', 'user_id');
    }
}
