<?php


namespace Lzw\ZentaoToOther;

use Illuminate\Support\ServiceProvider;

class ZentaoToOtherProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton('ZentaoToOther', function () {
            return new ZentaoToOther();
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/zto.php' => config_path('zto.php'),
        ]);

    }
}
