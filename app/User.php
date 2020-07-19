<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isAnyAdmin()
    {
        return $this->hasAnyRole(['admin', 'super-admin']);
    }

    public function reviews()
    {
        return $this->hasMany('App\Model\Review');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Likes');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function subscribers()
    {
        return $this->hasMany('App\Models\Subscribe');
    }
}
