# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

### Added

- Automatic registration of the PHP Hijri Carbon mixin.
- Publishable `hijri.php` configuration with global day adjustment.
- `HijriDateRule` Laravel validation rule (`Pharaonic\Laravel\Hijri\Rules\HijriDateRule`).
- English and Arabic validation translations.
- `@hijri($date, $format = null, $locale = null, $adjustment = null)` Blade directive with a configurable default `pharaonic.hijri.format`.

### Changed

- Reworked the package to act as a Laravel integration layer on top of `pharaonic/php-hijri`.
- Centralized Hijri adjustment configuration through the published package config.
- Reduced framework-independent date logic inside the Laravel package.

### Compatibility

- Added support for Laravel 10.x on PHP 8.1, 8.2 and 8.3.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 10.
- Requires `pharaonic/php-hijri` 8.1.1+ (PHP 8.1), 8.2.1+ (PHP 8.2) or 8.3.1+ (PHP 8.3), which require `nesbot/carbon` ^2.55 (^2.62.1 on PHP 8.2+). Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.
- Translations publish to Laravel's `lang/vendor/hijri` directory.