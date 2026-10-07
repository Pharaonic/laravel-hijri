# Changelog

All notable changes to this project will be documented in this file.

## 9.0.1 - 2026-10-07

### Fixed

- Rendering a Hijri date (`@hijri`) no longer changes Gregorian month names elsewhere in the app. Before, after the first Hijri date in a request, every Gregorian date printed with month names (`translatedFormat('F')`, `isoFormat('MMMM')`, `monthName`) showed Hijri names, e.g. `Rabi' Al-Awwal` instead of `March`, for the rest of the process (every request under Octane, every job on a queue worker).
- The 29th of Safar no longer renders as the 1st of Rabi' Al-Awwal.
- Requires `pharaonic/php-hijri` 8.0.3+ or 8.1.2+ or 8.2.3+, which contain these fixes.

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

- Added support for Laravel 9.x on PHP 8.0, 8.1 and 8.2.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 9.
- Requires `pharaonic/php-hijri` 8.0.2+ (PHP 8.0), 8.1.1+ (PHP 8.1) or 8.2.1+ (PHP 8.2), which require `nesbot/carbon` ^2.55 (^2.62.1 on PHP 8.2). Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.
- Translations now publish to Laravel 9's `lang/vendor/hijri` directory instead of `resources/lang/vendor/hijri`.