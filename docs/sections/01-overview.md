:::badges
- Laravel Package {color=blue}
- {release.label} {color=green}
- {package.license} License {color=purple}
:::

# Laravel Hijri

Laravel Hijri adds Hijri (Islamic) calendar support to your Laravel application. It registers the [PHP Hijri](https://github.com/Pharaonic/php-hijri) Carbon mixin, so every Carbon date (including `now()` and Eloquent date attributes) can convert to and from Hijri. It also ships an `@hijri` Blade directive, a Hijri date validation rule, English and Arabic translations, and a global day adjustment you set once in config.

:::features
### Carbon Integration {icon="clock"}
Call `toHijri()`, `Carbon::fromHijri()` and `Carbon::parseHijri()` on any Carbon date, with no setup.

### Blade Directive {icon="code"}
Print a Hijri date in any view with `@hijri($date)`, in the app locale and your default format.

### Validation Rule {icon="shield-check"}
Validate Hijri input such as `1445-09-01` with `HijriDateRule`, with English and Arabic messages.

### Day Adjustment {icon="switch"}
Shift every conversion by a number of days to match local moon sighting, globally or per call.

### Arabic & English Names {icon="translate"}
Month names switch between Arabic (`رَمضان`) and transliterated English (`Ramadan`) by locale.

### Publishable Config {icon="document"}
One small config file, with the day adjustment readable from `HIJRI_ADJUSTMENT` in `.env`.
:::

:::info Quick Tip
Store dates in Gregorian in your database and convert to Hijri only when you display them. Your queries, sorting and date math keep working as usual.
:::
