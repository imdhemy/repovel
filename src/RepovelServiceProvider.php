<?php
namespace Imdhemy;

use Illuminate\Support\ServiceProvider;
use Imdhemy\Commands\MakeRepositoryCommand;
use Imdhemy\Commands\MakeServiceCommand;

class RepovelServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfigs();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigs();
    }

    /**
     * Register config path to be published by the Command
     *
     * @return void
     */
    private function publishConfigs()
    {
        $this->publishes([
            __DIR__ . '/config/repovel.php' => config_path('repovel.php')
        ], 'repovel-configs');
    }

    /**
     * Merge the published configuration with the existing configuration.
     *
     * @return void
     */
    private function mergeConfigs()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/repovel.php',
            'repovel'
        );
    }

    /**
     * Register the package's custom Artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeServiceCommand::class,
                MakeRepositoryCommand::class
            ]);
        }
    }
}
