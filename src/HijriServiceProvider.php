<?php

namespace Pharaonic\Laravel\Hijri;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Pharaonic\Hijri\Hijri;
use Pharaonic\Hijri\HijriCarbon;

class HijriServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/hijri.php',
            'hijri'
        );
    }

    public function boot(): void
    {
        Carbon::mixin(HijriCarbon::class);

        Hijri::getInstance()->setHijriAdjustment(
            (int) $this->app->make('config')->get('hijri.adjustment', -1)
        );

        $this->loadTranslationsFrom(
            __DIR__.'/../resources/lang',
            'hijri'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/hijri.php' => $this->app->configPath('Pharaonic/hijri.php'),
            ], ['pharaonic', 'config', 'laravel-hijri', 'hijri-config']);

            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->resourcePath('lang/vendor/hijri'),
            ], ['pharaonic', 'translations', 'laravel-hijri', 'hijri-translations']);
        }
    }
}
