<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loteria extends Model
{
    protected $fillable = [
        'name', 'email', 'password',
    ];
}
