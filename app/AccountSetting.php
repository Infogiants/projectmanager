<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    protected $fillable = [
        'user_id',
        'configuration_id',
        'configuration_value'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function configuration()
    {
        return $this->hasOne('App\Configuration', 'id', 'configuration_id');
    }
}
