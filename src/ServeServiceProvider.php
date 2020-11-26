<?php

namespace Malico\Serve;

use Illuminate\Support\ServiceProvider;
use Malico\Serve\Commands\ServeCommand;

class ServeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCommands();
    }

    /**
     * Register Serve Commands
     *
     * @return void
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    ServeCommand::class,
                ]
            );
        }
    }
}
