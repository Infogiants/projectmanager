<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'about',
        'email',
        'phone'       
    ];
}
