<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Swap\Laravel\Facades\Swap;

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
     * @param $players  The amount of players
     * @param $currency The currency to use
     *
     * @return integer The monthly cost of of this gameserver
     */
    public function getSubscriptionPrice($players, $currency = NULL)
    {
        if (!is_numeric($players) || $players < $this->minplayers || $players > $this->maxplayers)
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, "Players amount invalid");
        
        $currency == NULL ? env('CURRENCY') : $currency;
        
        if (!in_array(strtolower($currency), env('app.currencies')))
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, "Unauthorized currency");
        
        $rate = Swap::latest(env('CURRENCY') . '/' . ($currency || env('CURRENCY')))->getValue();
        
        return floor($this->cents_per_slots * $players * $rate);
    }
}
