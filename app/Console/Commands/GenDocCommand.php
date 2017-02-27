<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class GenDocCommand extends Command
{
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:renderdocs';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates and render HTML documentation of the API";
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->callSilent('api:docs', [
            "--name"        => env("API_NAME", "My API"),
            "--use-version" => env("API_VERSION", "v1"),
            "--output-file" => base_path('docs') . '/documentation.apib'
        ]);
        
        passthru("aglio --theme-variables streak -i docs/documentation.apib -o docs/index.html --theme-template triple", $status_code);
        
        if ($status_code !== 0)
            $this->error("Error while rendering documentation. You need `aglio` globally installed.");
        else
            $this->info("Documentation was rendered successfully.");
    }
}
