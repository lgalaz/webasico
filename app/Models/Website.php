<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'websites';

    protected $primaryKey = 'website_id';

    protected $guarded = ['website_id'];

    public function account()
    {
        return $this->hasOne(Account::class, 'account_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }
}
