<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function Reviews()
    {
        $this->belongsToMany('App\Models\ReviewsToGenres');
    }
}
