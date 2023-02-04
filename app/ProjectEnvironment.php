<?php

namespace App;

use App\Environment;
use Illuminate\Database\Eloquent\Model;

class ProjectEnvironment extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'environment_id',
        'url',
        'username',
        'password',
        'summary'
    ];

    public function getEnviornment($envId) {
        $prjEnv = Environment::where('id', $envId)->first()->name;
        return $prjEnv;
    }
}
