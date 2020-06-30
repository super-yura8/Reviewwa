<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'review_id', 'user_id', 'like'
    ];

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function review()
    {
        $this->belongsTo('App\Model\Review');
    }
}
