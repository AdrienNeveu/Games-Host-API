<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostServer extends Model
{
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'auth_info'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'auth_info' => 'array',
    ];
    
    /**
     * The game servers belonging to the host server
     */
    public function gameServers()
    {
        return $this->hasMany('App\Models\GameServer');
    }
    
}
