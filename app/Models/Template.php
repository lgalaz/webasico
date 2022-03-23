<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'templates';

    protected $primaryKey = 'template_id';

    protected $guarded = ['template_id'];

    public function websites()
    {
        return $this->hasMany(Website::class, 'template_id', 'template_id');
    }
}
