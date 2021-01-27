<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;

class Permission extends Model
{   
    protected $fillable = [
        'name',
        'slug'       
    ];
    
    public function roles() {

       return $this->belongsToMany(Role::class,'roles_permissions');

    }

    public function users() {

       return $this->belongsToMany(User::class,'users_permissions');

    }
}
