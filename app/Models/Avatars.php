<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatars extends Model
{
    protected $table = 'avatars';
    public $timestamps = false;
    protected $fillable = ['avatar_big', 'avatar_small'];

    public function user()
    {
        return $this->belongsToMany('App\User','user_to_avatars');
    }
}
