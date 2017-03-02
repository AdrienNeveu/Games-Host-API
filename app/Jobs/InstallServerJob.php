<?php

namespace App\Jobs;

use App\Models\GameServer;
use Collective\Remote\RemoteFacade;

class InstallServerJob extends Job
{
    protected $gameServer;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GameServer $gameServer)
    {
        $this->gameServer = $gameServer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->gameServer->update(['installed' => 1]);
        
        $config = $this->gameServer->hostServer->auth_info;
        $config['timeout'] = config('app.game_install_timeout');

        RemoteFacade::connect($config)
            ->run([
                'mkdir -p ' . $config['install_path'] . '/' . $this->gameServer->id . ' && cd "$_"',
                'wget https://gameservermanagers.com/dl/' . $this->gameServer->game->linuxgsm_bin,
                'chmod +x ' . $this->gameServer->game->linuxgsm_bin,
                'yes | ./' . $this->gameServer->game->linuxgsm_bin . ' install'
            ]);
        
        $this->gameServer->update(['installed' => 2]);
    }
}
