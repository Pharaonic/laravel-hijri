<?php

namespace Pharaonic\Laravel\Hijri;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Pharaonic\Hijri\HijriCarbon;

class HijriServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::mixin(HijriCarbon::class);
    }
}
