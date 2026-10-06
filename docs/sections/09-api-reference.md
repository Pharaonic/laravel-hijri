## API Reference

### Carbon Methods

Added to `Carbon\Carbon` (and so to `Illuminate\Support\Carbon`) by the `Pharaonic\Hijri\HijriCarbon` mixin.

| Method | Description | Returns |
| --- | --- | --- |
| `$date->toHijri(?int $adjustment = null)` | Converts the Gregorian date to Hijri. The adjustment applies to this call only. | `Pharaonic\Hijri\Hijri` |
| `Carbon::fromHijri(int $year, int $month, int $day, $tz = null, ?int $adjustment = null)` | Creates a Gregorian date (midnight) from Hijri parts. Throws `InvalidHijriDateException` for a date that doesn't exist. | `Carbon\Carbon` |
| `Carbon::parseHijri(string $date, $tz = null, ?int $adjustment = null)` | Parses `YYYY-MM-DD[ HH:MM[:SS]]` as Hijri and returns the Gregorian date. Throws `InvalidHijriDateException` on bad input. | `Carbon\Carbon` |
| `Carbon::setHijriAdjustment(int $days)` | Sets the global day adjustment. | `void` |
| `Carbon::getHijriAdjustment()` | Gets the global day adjustment. | `int` |

### Hijri Class

`Pharaonic\Hijri\Hijri` extends `Carbon\Carbon`. Its date parts hold the Hijri values.

| Method | Description | Returns |
| --- | --- | --- |
| `Hijri::fromGregorian($time = null, $tz = null, ?int $adjustment = null)` | Converts any Carbon-supported input (string, `DateTimeInterface`, `null` for now) to Hijri. | `Hijri` |
| `Hijri::parse($time = null, $tz = null)` | Same as `fromGregorian()` with the global adjustment. | `Hijri` |
| `$hijri->locale(string $locale)` | Sets the locale and the matching Arabic or English month names. With no argument, returns the current locale. | `Hijri` or `string` |
| `$hijri->format(string $format)` | PHP `date()` format with translated day and month names. | `string` |
| `$hijri->isoFormat(string $format)` | Carbon ISO format with translated names. | `string` |
| `$hijri->year`, `->month`, `->day` | The Hijri year, month and day. | `int` |
| `$hijri->monthName` | The Hijri month name in the current locale. | `string` |
| `$hijri->dayName` | The weekday name in the current locale. | `string` |

### Package Classes

| Class / Member | Description | Returns |
| --- | --- | --- |
| `HijriFormatter::format($date, ?string $format = null, ?string $locale = null, ?int $adjustment = null)` | Formats a Gregorian `DateTimeInterface` or string as Hijri. Returns `''` for `null` or `''`. Used by `@hijri` and `<x-hijri-date>`. | `string` |
| `AsHijri::class` | Eloquent cast. Reads a Gregorian column as `Hijri`, stores Carbon, Gregorian strings or `Hijri` values as Gregorian, and serializes to `Y-m-d` Hijri. | `Pharaonic\Hijri\Hijri` or `null` |
| `new HijriDateRule()` | Validation rule for Hijri `YYYY-MM-DD[ HH:MM[:SS]]` strings. | `Illuminate\Contracts\Validation\Rule` |
| `@hijri($date, $format, $locale, $adjustment)` | Blade directive that echoes `HijriFormatter::format()`, escaped. | Output |
| `<x-hijri-date :date format locale adjustment />` | Blade component that renders `HijriFormatter::format()` inside `<time datetime="Y-m-d">`. Extra attributes go on the `<time>` element. | Output |

Namespaces: `Pharaonic\Laravel\Hijri\Casts\AsHijri`, `Pharaonic\Laravel\Hijri\Support\HijriFormatter`, `Pharaonic\Laravel\Hijri\View\Components\HijriDate`, `Pharaonic\Laravel\Hijri\Rules\HijriDateRule`, `Pharaonic\Hijri\Hijri`, `Pharaonic\Hijri\Exception\InvalidHijriDateException`.

### Config and Publish Tags

| Item | Value |
| --- | --- |
| Config key | `pharaonic.hijri` (`adjustment`, `format`) |
| Config file | `config/pharaonic/hijri.php` |
| Translation namespace | `hijri` (key `hijri::validation.hijri_date`) |
| Config tags | `hijri-config`, `pharaonic-config` |
| Translation tags | `hijri-translations`, `pharaonic-translations` |
| All assets | `laravel-hijri`, `pharaonic` |
