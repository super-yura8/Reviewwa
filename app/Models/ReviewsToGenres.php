<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewsToGenres extends Model
{
    protected $table = 'review_to_genre';
    protected $fillable = ['name'];
    public $timestamps = false;
}
