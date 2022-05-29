<?php

namespace Sotaiga\Poliglot;

use Illuminate\Support\ServiceProvider;

class PoliglotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Registrar el Middleware que parseja la url per a obtenir l'idioma
        app('router')->aliasMiddleware('poliglot-middleware', \Sotaiga\Poliglot\PoliglotMiddleware::class);

        // Load the config file and merge it with the user's (should it get published)
        $this->mergeConfigFrom($this->getConfigFile(), 'poliglot');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Allow your user to publish the config
        $this->publishes([
            $this->getConfigFile() => config_path('poliglot.php'),
        ], 'config');
    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'poliglot.php';
    }

//    php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

}
