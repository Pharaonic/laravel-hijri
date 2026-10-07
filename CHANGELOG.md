# Changelog

All notable changes to this project will be documented in this file.

## 13.0.3 - 2026-10-07

### Documentation

- The overview now lists six features: the publishable config is part of Day Adjustment, since `HIJRI_ADJUSTMENT` is the only setting it holds.

## 13.0.2 - 2026-10-07

### Fixed

- `HijriDateRule` now accepts and rejects the 30th of Dhu Al-Hijjah by the same leap years `@hijri` uses. Before, it rejected dates such as `1425-12-30`, which `@hijri` renders, and accepted `1426-12-30`, which doesn't exist. Requires `pharaonic/php-hijri` 8.3.4+ or 8.4.4+ or 8.5.4+, which fix the leap years.

## 13.0.1 - 2026-10-07

### Fixed

- Rendering a Hijri date (`@hijri`, `<x-hijri-date>`) no longer changes Gregorian month names elsewhere in the app. Before, after the first Hijri date in a request, every Gregorian date printed with month names (`translatedFormat('F')`, `isoFormat('MMMM')`, `monthName`) showed Hijri names, e.g. `Rabi' Al-Awwal` instead of `March`, for the rest of the process (every request under Octane, every job on a queue worker).
- The 29th of Safar no longer renders as the 1st of Rabi' Al-Awwal.
- Requires `pharaonic/php-hijri` 8.3.3+ or 8.4.3+ or 8.5.3+, which contain these fixes.

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

- Added support for Laravel 13.x on PHP 8.3, 8.4 and 8.5.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 13.
- Requires `pharaonic/php-hijri` 8.3.2+ (PHP 8.3), 8.4.2+ (PHP 8.4) or 8.5.2+ (PHP 8.5), which support `nesbot/carbon` 3.x as required by Laravel 13. Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.
- Requires `illuminate/view` (used by the Blade component) and no longer requires the unused `illuminate/database`.
- Translations publish to Laravel's `lang/vendor/hijri` directory.