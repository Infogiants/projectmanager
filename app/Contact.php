<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'first_name',
        'last_name',
        'about',
        'email',
        'phone'
    ];
}
