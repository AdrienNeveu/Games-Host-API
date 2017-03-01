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
     * @param $players
     *
     * @return integer The amount, in USD cents, to renew the  
     */
    public function getSubscriptionPrice($players)
    {
        if (!is_numeric($players) || $players < $this->minplayers || $players > $this->maxplayers)
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, "Players amount invalid");
        
        return $this->cents_per_slots * $players;
    }
}
