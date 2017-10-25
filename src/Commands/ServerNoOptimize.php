<?php

namespace Nox0121\LaravelUtilityCommand\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ServerNoOptimize extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'server:no-optimize';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a serial scripts for stop optimization';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $env = $this->option('env') ? ' --env='. $this->option('env') : '';

        $this->runExec('php artisan clear-compiled');
        $this->runExec('php artisan route:clear');
        $this->runExec('php artisan view:clear');
        $this->runExec('php artisan config:clear');
        $this->runExec('php artisan cache:clear');
        $this->runExec('php artisan key:generate');
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('env', null, InputOption::VALUE_OPTIONAL, 'Environment to pass to migrate command')
        );
    }
    /**
     * Utility function to run exec()
     *
     * @return mixed
     */
    private function runExec($command)
    {
        $this->comment('Running command: '. $command);
        exec($command, $output, $return);
        if (!empty($output)) {
            foreach ($output as $line) {
                if ($return !== false) {
                    $this->info($line);
                } else {
                    $this->error($line);
                }
            }
        }
    }
}
