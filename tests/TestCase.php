<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Pharaonic\Laravel\Hijri\HijriServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            HijriServiceProvider::class,
        ];
    }
}
