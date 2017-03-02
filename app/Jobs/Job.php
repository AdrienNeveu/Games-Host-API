<?php

namespace App\Jobs;

use Collective\Remote\RemoteFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Job implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use InteractsWithQueue, Queueable, SerializesModels;
    
    protected function executeBinCommand($gameServer, $command, $timeout = 25)
    {
        $config = $gameServer->hostServer->auth_info;
        $config['timeout'] = $timeout;
    
        RemoteFacade::connect($config)
            ->run([
                'cd ' . $config['install_path'] . '/' . $gameServer->id,
                './' . $gameServer->game->linuxgsm_bin . ' ' . $command,
            ]);
    }
}
