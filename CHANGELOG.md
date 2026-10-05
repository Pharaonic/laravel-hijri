# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

### Added

- Automatic registration of the PHP Hijri Carbon mixin.
- Publishable `hijri.php` configuration with global day adjustment.
- `HijriDate` Laravel validation rule.
- `HasHijriDates` Eloquent concern for non-invasive Hijri representations.
- English and Arabic validation translations.

### Changed

- Reworked the package to act as a Laravel integration layer on top of `pharaonic/php-hijri`.
- Centralized Hijri adjustment configuration through the published package config.
- Reduced framework-independent date logic inside the Laravel package.

### Compatibility

- Added support for Laravel 6.x.
- Uses a compatible `pharaonic/php-hijri` release as the underlying Hijri date engine.
- Maintains compatibility with the PHP and Carbon versions supported by Laravel 6.