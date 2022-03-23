<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $guarded = ['post_id'];

    public function parentPost()
    {
        return $this->hasOne(Post::class, 'post_id');
    }

    public function website()
    {
        return $this->hasOne(Website::class, 'website_id');
    }
}
