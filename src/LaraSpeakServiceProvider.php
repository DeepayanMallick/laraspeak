<?php

namespace Deepayan\LaraSpeak;

use Illuminate\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Deepayan\LaraSpeak\Conversations\ConversationRepository;
use Deepayan\LaraSpeak\Messages\MessageRepository;

class LaraSpeakServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupConfig();
        $this->setupMigrations();
        $this->setupResource();
        $this->setupAssets();
        $this->loadViewsFrom(__DIR__ . '/views', 'laraspeak');
    }
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerBroadcast();
        $this->registerLaraSpeak();
    }
    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/laraspeak.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('laraspeak.php')]);
        }
        
        $this->mergeConfigFrom($source, 'laraspeak');
    }
    /**
     * Publish migrations files.
     */
    protected function setupMigrations()
    {
        $this->publishes([
            realpath(__DIR__ . '/../database/migrations/') => database_path('migrations'),
        ], 'migrations');
    }
    /**
     * Publish views files.
     */
    protected function setupResource()
    {
        $this->publishes([
            realpath(__DIR__ . '//views/') => resource_path('views'),
        ], 'views');
    }
    public function setupAssets()
    {
        $this->publishes([
            realpath(__DIR__ . '//assets/') => public_path('vendor/deepayan/laraspeak'),
        ], 'public');
    }
    /**
     * Register LaraSpeak class.
     */
    protected function registerLaraSpeak()
    {
        $this->app->singleton('laraspeak', function (Container $app) {
            return new LaraSpeak($app['config'], $app['laraspeak.broadcast'], $app[ConversationRepository::class], $app[MessageRepository::class]);
        });

        $this->app->alias('laraspeak', LaraSpeak::class);
    }

    /**
     * Register LaraSpeak class.
     */
    protected function registerBroadcast()
    {
        $this->app->singleton('laraspeak.broadcast', function (Container $app) {
            return new Live\Broadcast($app['config']);
        });

        $this->app->alias('laraspeak.broadcast', Live\Broadcast::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'laraspeak',
            'laraspeak.broadcast',
        ];
    }
}
