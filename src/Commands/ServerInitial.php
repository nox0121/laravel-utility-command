<?php

namespace Nox0121\LaravelUtilityCommand\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Artisan;

class ServerInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a serial scripts for initialization';

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

        $this->runArtisan('db:create');
        $this->runArtisan('migrate', ["--force" => true]);
        $this->runArtisan('db:seed', ["--force" => true, "--env" => "production"]);
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
