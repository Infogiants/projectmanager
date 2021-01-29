<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'project_category_id',
        'project_name',
        'project_type',
        'project_price',
        'project_start_date',
        'project_end_date',
        'project_status',
        'project_description',
        'client_user_id'
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'project_category_id');
    }
    
}
