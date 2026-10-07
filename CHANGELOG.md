# Changelog

All notable changes to this project will be documented in this file.

## 7.0.4 - Unreleased

### Documentation

- The installation requirements now list the `pharaonic/php-hijri` releases `composer.json` requires: 8.0.4+. Before, they listed older releases.
- The changelog lists the 7.0.0 notes under 7.0.0 instead of `Unreleased`, and adds the missing 7.0.1 notes.

## 7.0.3 - 2026-10-07

### Fixed

- `HijriDateRule` now accepts and rejects the 30th of Dhu Al-Hijjah by the same leap years `@hijri` uses. Before, it rejected dates such as `1425-12-30`, which `@hijri` renders, and accepted `1426-12-30`, which doesn't exist. Requires `pharaonic/php-hijri` 8.0.4+, which fix the leap years.

## 7.0.2 - 2026-10-07

### Fixed

- Rendering a Hijri date (`@hijri`) no longer changes Gregorian month names elsewhere in the app. Before, after the first Hijri date in a request, every Gregorian date printed with month names (`translatedFormat('F')`, `isoFormat('MMMM')`, `monthName`) showed Hijri names, e.g. `Rabi' Al-Awwal` instead of `March`, for the rest of the process (every request under Octane, every job on a queue worker).
- The 29th of Safar no longer renders as the 1st of Rabi' Al-Awwal.
- Requires `pharaonic/php-hijri` 8.0.3+, which contain these fixes.

## 7.0.1 - 2026-10-06

### Fixed

- Requires `pharaonic/php-hijri` 8.0.2+ (was 8.0.1+), which requires `nesbot/carbon` ^2.55. Older Carbon releases render Gregorian month names (e.g. `September`) in Hijri dates.

## 7.0.0 - 2026-10-05

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

- Added support for Laravel 7.x.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 7.