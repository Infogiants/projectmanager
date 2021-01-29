<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MileStone extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'description',
        'start_date',
        'end_date'
    ];
}
