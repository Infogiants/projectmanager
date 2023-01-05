<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Effort extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'hour'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function task()
    {
        return $this->hasOne('App\Task', 'id', 'task_id');
    }
}
