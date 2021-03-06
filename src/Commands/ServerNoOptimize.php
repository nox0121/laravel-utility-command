<?php

namespace Nox0121\LaravelUtilityCommand\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Artisan;

class ServerNoOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:no-optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a serial scripts for stop optimization';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $env = $this->option('env') ? ' --env='. $this->option('env') : '';

        $this->runArtisan('clear-compiled');
        $this->runArtisan('route:clear');
        $this->runArtisan('view:clear');
        $this->runArtisan('config:clear');
        $this->runArtisan('cache:clear');
        $this->runArtisan('key:generate', ["--force" => true]);
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
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return int
     */
    private function runArtisan($command, array $parameters = [])
    {
        $this->comment('Running command: '. $command);

        $result = Artisan::call($command, $parameters);
        $output = Artisan::output();

        if (!empty($output)) {
            if ($result !== false) {
                $this->info($output);
            } else {
                $this->error($output);
            }
        }

        return $result;
    }
}
