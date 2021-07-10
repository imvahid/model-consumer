<?php

namespace Milyoona\ModelConsumer;

use Illuminate\Support\ServiceProvider;

class ModelConsumerServiceProvider extends ServiceProvider
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
        // Register Commands
        if ($this->app->runningInConsole()) {
            $commands = array_diff(scandir(__DIR__.'/Console/Commands'), array('.', '..'));
            $basenames = [];
            foreach($commands as $index => $command) {
                $basenames[$index] = '\Milyoona\ModelConsumer\Console\Commands' . '\\' . basename($command, '.php');
            }
            $basenames = array_merge($basenames, ['\Laravelista\LumenVendorPublish\VendorPublishCommand']);
            $this->commands($basenames);
        }

        // Main config
        $this->publishes([
            __DIR__.'/config/milyoona_model_consumer.php' => $this->config_path('milyoona_model_consumer.php')
        ], 'milyoona_model_consumer');

        // For migrate new migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/news');

        // Base migrations
        foreach( array_diff(scandir(__DIR__.'/database/migrations/base'), array('.', '..')) as $migration) {
            $this->publishes([
                __DIR__.'/database/migrations/base/' . $migration => $this->database_path(date('Y_m_d_His') . '_create_' . basename($migration, '.php') .  '_table.php')
            ], 'base_' . basename($migration, '.php') );
        }
        // Free migrations
        foreach( array_diff(scandir(__DIR__.'/database/migrations/free'), array('.', '..')) as $migration) {
            $this->publishes([
                __DIR__.'/database/migrations/free/' . $migration => $this->database_path(date('Y_m_d_His') . '_create_' . basename($migration, '.php')  .  '_table.php')
            ], 'free_' . basename($migration, '.php') );
        }
    }

    // Helper function
    public function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
    public function database_path($path = '')
    {
        return app()->basePath() . '/database/migrations' . ($path ? '/' . $path : $path);
    }
}
