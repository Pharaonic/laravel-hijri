<?php

namespace Pharaonic\Laravel\Hijri\Support;

use DateTimeInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Pharaonic\Hijri\Hijri;

final class HijriFormatter
{
    /**
     * Format a Gregorian date as a Hijri string using ISO format tokens.
     *
     * @param  DateTimeInterface|string|null  $date
     */
    public static function format($date, ?string $format = null, ?string $locale = null, ?int $adjustment = null): string
    {
        if ($date === null || $date === '') {
            return '';
        }

        $hijri = Hijri::fromGregorian($date, null, $adjustment);
        $hijri->locale($locale ?? App::getLocale());

        return $hijri->isoFormat($format ?? (string) Config::get('hijri.format', 'D MMMM YYYY'));
    }
}
