<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'image'       
    ];

    public function projects() 
    {
        return $this->hasMany('App\Project', 'project_category_id');
    }
}
