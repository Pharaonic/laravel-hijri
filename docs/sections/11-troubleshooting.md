## Troubleshooting

### `Call to undefined method toHijri()`

The mixin is registered when `HijriServiceProvider` boots. Check that:

- Package discovery isn't disabled for it (`dont-discover` in your app's `composer.json`). If it is, add `Pharaonic\Laravel\Hijri\HijriServiceProvider::class` to `providers` in `config/app.php`.
- You're not calling it before the app has booted, for example in a config file.
- Run `php artisan package:discover` after installing.

### The Hijri date is off by one day

The tabular calendar can differ from your local moon sighting. Set `HIJRI_ADJUSTMENT` in `.env` (the default is `-1`), or pass an adjustment per call: `$date->toHijri(0)`. If you cache your config, run `php artisan config:cache` again.

### Changing the adjustment in config at runtime does nothing

`pharaonic.hijri.adjustment` is read only once, at boot. Use `Carbon::setHijriAdjustment($days)` to change the global value, or pass `$adjustment` to `toHijri()`, `fromHijri()`, `parseHijri()` or `@hijri`.

### Month names appear in English in an Arabic page

Arabic names are used only when the `Hijri` object's locale starts with `ar`. `toHijri()` doesn't use your app locale, so set it explicitly: `$date->toHijri()->locale('ar')`. The `@hijri` directive uses `app()->getLocale()`, so check the app locale is set before the view renders.

### `InvalidHijriDateException` when parsing

`Carbon::parseHijri()` only accepts `YYYY-MM-DD` with an optional `HH:MM[:SS]` time, and the day must exist in that Hijri month. Validate user input with `HijriDateRule` first, or catch `Pharaonic\Hijri\Exception\InvalidHijriDateException`.

### Date math on a Hijri object gives odd results

A `Hijri` object stores Hijri values in a Carbon date, so Carbon helpers like `addMonth()`, `daysInMonth` or `diffInDays()` still follow Gregorian rules. Do your date math on the Gregorian Carbon date, then call `toHijri()` on the result.

```php
// Avoid
$date->toHijri()->addDays(30);

// Prefer
$date->copy()->addDays(30)->toHijri();
```

### The validation message shows `hijri::validation.hijri_date`

The translation wasn't found for the current locale. The package ships `en` and `ar`. For other locales, publish the translations with `--tag=hijri-translations` and add `lang/vendor/hijri/{locale}/validation.php`, or set a `fallback_locale` of `en`.
