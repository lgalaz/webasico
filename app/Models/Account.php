<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts';

    protected $primaryKey = 'account_id';

    protected $guarded = ['account_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function websites()
    {
        return $this->hasMany(Website::class, 'account_id', 'account_id');
    }
}
