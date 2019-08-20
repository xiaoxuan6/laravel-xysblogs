<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GithubUser extends Model
{
    public $guarded = [];

    protected $casts = [
        'original' => 'array',
    ];
}
