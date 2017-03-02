<?php

namespace App\Jobs;

use App\Models\GameServer;
use Collective\Remote\RemoteFacade;

class StartServerJob extends Job
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
        $this->executeBinCommand($this->gameServer, 'start');
    }
}
