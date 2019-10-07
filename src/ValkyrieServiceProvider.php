<?php

namespace MikeTiEm\Valkyrie;

use Illuminate\Support\ServiceProvider;
use MikeTiEm\Valkyrie\Console\Commands\GenerateControllerCommand;
use MikeTiEm\Valkyrie\Console\Commands\GenerateModelCommand;
use MikeTiEm\Valkyrie\Console\Commands\GenerateRepositoryCommand;

class ValkyrieServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->basePath('config/valkyrie.php') => base_path('config/valkyrie.php')
        ], 'valkyrie-config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            GenerateModelCommand::class,
            GenerateControllerCommand::class,
            GenerateRepositoryCommand::class
        ]);

        $this->mergeConfigFrom($this->basePath('config/valkyrie.php'), 'valkyrie');
    }

    protected function basePath($path = '')
    {
        return __DIR__ . '/../' . $path;
    }
}