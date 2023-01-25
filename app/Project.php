<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;
use App\Effort;
use App\Billing;

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
        'client_user_id',
        'project_currency'
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'project_category_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne('App\User', 'id', 'client_user_id');
    }

    public function estimatedHours($project) {
        $estimatedHours = Task::where([
            ['project_id', '=', $project->id],
            ['user_id', '=', $project->user_id]
        ])->sum('estimated_hours');
        return $estimatedHours;
    }

    public function loggedHours($project) {
        $loggedHours = Effort::where([
            ['project_id', '=', $project->id],
            ['user_id', '=', $project->user_id]
        ])->sum('hour');
        return $loggedHours;
    }

    public function paidBillingAmount($project) {
        $paidAmount = Billing::where([
            ['project_id', '=', $project->id],
            ['user_id', '=', $project->user_id]
        ])->sum('amount');
        return $paidAmount;
    }
}
