<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = ['content','user_id','review_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function review()
    {
        return $this->belongsTo('App\Model\Review');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
