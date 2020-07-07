<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = ['content','user_id','review_id'];

    public function review()
    {
        return $this->belongsTo('App\Model\Review');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
