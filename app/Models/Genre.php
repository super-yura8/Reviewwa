<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function reviews()
    {
        return $this->belongsToMany('App\Model\Review', 'review_to_genre');
    }
}
