<?php

namespace Pharaonic\Laravel\Hijri\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use Pharaonic\Hijri\Exception\InvalidHijriDateException;
use Pharaonic\Hijri\Hijri;

final class HijriDateRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        if (! is_string($value) || trim($value) === '') {
            return false;
        }

        try {
            Hijri::parseHijri($value);
        } catch (InvalidHijriDateException) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array<string>
     */
    public function message(): string|array
    {
        return Lang::get('hijri::validation.hijri_date');
    }
}
