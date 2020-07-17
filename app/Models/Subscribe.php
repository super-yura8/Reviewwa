<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribe';
    protected $fillable = ['user_id', 'subscriber_id'];
    public $timestamps = false;
}
