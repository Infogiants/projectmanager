<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Effort;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'description',
        'status',
        'estimated_hours'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function efforts()
    {
        return $this->hasMany('App\Effort', 'id', 'project_id');
    }
    public function loggedEfforts($task)
    {
        $effortHours = Effort::where([
            ['project_id', '=', $task->project_id],
            ['user_id', '=', $task->user_id],
            ['task_id', '=', $task->id]
        ])->sum('hour');
        return $effortHours;
    }
}
