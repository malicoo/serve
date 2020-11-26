<?php

namespace Malico\Serve\Commands;

use Illuminate\Support\Str;
use Illuminate\Foundation\Console\ServeCommand as Command;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'serve:out';

    /**
     * Available Host
     *
     * @var array
     */
    protected $hosts = [];

    /**
     * Selected Host
     *
     * @var string
     */
    protected $host = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application network';

    
    /**
     * Handle Command
     *
     * @return void
     */
    public function handle()
    {
        $this->fetchHosts();
        $this->selectHost();
        
        return parent::handle();
    }

    /**
     * Get the host for the command.
     *
     * @return string
     */
    protected function host()
    {
        return $this->host;
    }

    /**
     * Select Host
     *
     * @return void
     */
    protected function selectHost() : void
    {
        $this->host = $this->choice('IP', $this->hosts, $this->option('host'));
    }
    
    /**
     * Generate Available Hosts
     *
     * @return void
     */
    protected function fetchHosts() : void
    {
        $results = explode("\n", trim(shell_exec('ifconfig | grep "inet "')));

        foreach ($results as $ip_link) {
            $this->hosts[] = $this->getIP($ip_link);
        }
    }
    /**
     * Extract host from command line
     *
     * @param string $string
     *
     * @return string
     */
    protected function getIP(string $string) : string
    {
        $str = trim($string, "\n inet");
        
        return Str::substr($str, 0, strpos($str, ' '));
    }
}
