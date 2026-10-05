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

### Changed

- Reworked the package to act as a Laravel integration layer on top of `pharaonic/php-hijri`.
- Centralized Hijri adjustment configuration through the published package config.
- Reduced framework-independent date logic inside the Laravel package.

### Compatibility

- Added support for Laravel 11.x on PHP 8.2, 8.3 and 8.4.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 11.
- Requires `pharaonic/php-hijri` 8.2.1+ (PHP 8.2), 8.3.1+ (PHP 8.3) or 8.4.1+ (PHP 8.4), which require `nesbot/carbon` ^2.62.1. Carbon 3 works with `pharaonic/php-hijri` 8.2.2+, 8.3.2+ or 8.4.2+. Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.
- Requires `illuminate/view` (used by the Blade component) and no longer requires the unused `illuminate/database`.
- Translations publish to Laravel's `lang/vendor/hijri` directory.