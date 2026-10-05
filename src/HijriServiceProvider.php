<?php

namespace Pharaonic\Laravel\Hijri;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pharaonic\Hijri\Hijri;
use Pharaonic\Hijri\HijriCarbon;
use Pharaonic\Laravel\Hijri\Support\HijriFormatter;

class HijriServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/hijri.php',
            'pharaonic.hijri'
        );
    }

    public function boot(): void
    {
        Carbon::mixin(HijriCarbon::class);

        Hijri::getInstance()->setHijriAdjustment(
            (int) $this->app->make('config')->get('pharaonic.hijri.adjustment', -1)
        );

        $this->loadTranslationsFrom(
            __DIR__.'/../resources/lang',
            'hijri'
        );

        Blade::directive('hijri', function ($expression) {
            return '<?php echo e(\\'.HijriFormatter::class.'::format('.$expression.')); ?>';
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/hijri.php' => $this->app->configPath('pharaonic/hijri.php'),
            ], ['pharaonic', 'laravel-hijri', 'pharaonic-config', 'hijri-config']);

            $this->publishes([
                __DIR__.'/../resources/lang' => lang_path('vendor/hijri'),
            ], ['pharaonic', 'laravel-hijri', 'pharaonic-translations', 'hijri-translations']);
        }
    }
}
