<?php

namespace Pharaonic\Laravel\Hijri\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Pharaonic\Hijri\Hijri;

/**
 * Store a Gregorian date and read it back as a Hijri date.
 *
 * @implements CastsAttributes<Hijri|null, mixed>
 */
final class AsHijri implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * Always build a fresh Hijri instance, so changes made to a previously
     * read value are never written back to the database on save.
     */
    public bool $withoutObjectCaching = true;

    /**
     * Convert the stored Gregorian value to a Hijri date.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, mixed $value, array $attributes): ?Hijri
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Hijri::fromGregorian($value);
    }

    /**
     * Prepare the value for storage as a Gregorian date.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Hijri extends Carbon, so its date parts hold the Hijri values and
        // must be converted back before they are treated as a Gregorian date.
        if ($value instanceof Hijri) {
            $value = Hijri::fromHijri($value->year, $value->month, $value->day, $value->getTimezone())
                ->setTime($value->hour, $value->minute, $value->second, $value->microsecond);
        }

        return $model->fromDateTime($value);
    }

    /**
     * Get the serialized representation of the value for arrays and JSON.
     *
     * Eloquent passes DateTimeInterface values through serializeDate() before
     * calling this method, so the Hijri date is rebuilt from the raw value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function serialize($model, string $key, mixed $value, array $attributes): ?string
    {
        return $this->get($model, $key, $attributes[$key] ?? null, $attributes)?->format('Y-m-d');
    }
}
