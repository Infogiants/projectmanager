<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\User;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'roles_permissions')->withTimestamps();
    }

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_roles');
    }

}
