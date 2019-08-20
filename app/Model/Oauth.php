<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Oauth extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'github_id', 'username', 'name', 'email', 'avatar', 'github_url', 'blog', 'company', 'original', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'original' => 'array',
    ];

    public function discuss()
    {
        return $this->hasMany(Discuss::class);
    }
}
