<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameServer extends Model
{
    
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
    ];
    
    /**
     * The user owner of this game server
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * The game of this game server
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }
    
    /**
     * The host server that belongs this game server
     */
    public function hostServer()
    {
        return $this->belongsTo('App\Models\HostServer');
    }
    
}
