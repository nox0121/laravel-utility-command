<?php

namespace Nox0121\LaravelUtilityCommand;

use Illuminate\Support\ServiceProvider;
use Nox0121\LaravelUtilityCommand\Commands\ServerInitial;
use Nox0121\LaravelUtilityCommand\Commands\ServerNoOptimize;
use Nox0121\LaravelUtilityCommand\Commands\ServerOptimize;
use Nox0121\LaravelUtilityCommand\Commands\DatabaseCreateCommand;

class LaravelUtilityCommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('command.server:initial', ServerInitial::class);
        $this->app->bind('command.server:no-optimize', ServerNoOptimize::class);
        $this->app->bind('command.server:optimize', ServerOptimize::class);
        $this->app->bind('command.db:create', DatabaseCreateCommand::class);

        $this->commands([
            'command.server:initial',
            'command.server:no-optimize',
            'command.server:optimize',
            'command.db:create',
        ]);

        $this->app->singleton(ConsoleOutput::class);
    }
}
