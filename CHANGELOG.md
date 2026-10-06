# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

### Added

- Automatic registration of the PHP Hijri Carbon mixin.
- Publishable `hijri.php` configuration with global day adjustment.
- `HijriDateRule` Laravel validation rule (`Pharaonic\Laravel\Hijri\Rules\HijriDateRule`).
- English and Arabic validation translations.
- `@hijri($date, $format = null, $locale = null, $adjustment = null)` Blade directive with a configurable default `pharaonic.hijri.format`.
- `<x-hijri-date>` Blade component that renders a `<time>` element with the Gregorian `datetime` attribute.
- `AsHijri` Eloquent cast (`Pharaonic\Laravel\Hijri\Casts\AsHijri`) that reads Gregorian columns as Hijri dates and serializes them as `Y-m-d` Hijri strings.

### Changed

- Reworked the package to act as a Laravel integration layer on top of `pharaonic/php-hijri`.
- Centralized Hijri adjustment configuration through the published package config.
- Reduced framework-independent date logic inside the Laravel package.

### Compatibility

- Added support for Laravel 13.x on PHP 8.3, 8.4 and 8.5.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 13.
- Requires `pharaonic/php-hijri` 8.3.2+ (PHP 8.3), 8.4.2+ (PHP 8.4) or 8.5.2+ (PHP 8.5), which support `nesbot/carbon` 3.x as required by Laravel 13. Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.
- Requires `illuminate/view` (used by the Blade component) and no longer requires the unused `illuminate/database`.
- Translations publish to Laravel's `lang/vendor/hijri` directory.