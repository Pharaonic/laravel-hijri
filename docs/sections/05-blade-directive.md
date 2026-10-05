## Blade Directive

`@hijri` prints a Gregorian date as an escaped Hijri string.

```blade
@hijri($date, $format = null, $locale = null, $adjustment = null)
```

| Argument | Type | Default |
| --- | --- | --- |
| `$date` | `DateTimeInterface`, `string` or `null` | Required |
| `$format` | `string` (Carbon `isoFormat` tokens) | `config('pharaonic.hijri.format')`, `D MMMM YYYY` |
| `$locale` | `string` | `app()->getLocale()` |
| `$adjustment` | `int` | The global adjustment |

### Default Format

With only a date, the directive uses the configured format and the current app locale:

```blade title="resources/views/posts/show.blade.php"
<time>@hijri($post->published_at)</time>
{{-- 1 Ramadan 1445 --}}
```

### Custom Format and Locale

```blade
@hijri('2024-03-11', 'dddd D MMMM YYYY', 'ar')
{{-- الاثنين 1 رَمضان 1445 --}}

@hijri($order->created_at, 'YYYY/MM/DD')
{{-- 1445/09/01 --}}
```

### Custom Adjustment

```blade
@hijri($event->starts_at, null, null, 0)
```

### Empty Values

A `null` or empty string date renders nothing, so you don't need an `@if` around nullable columns:

```blade
@hijri($user->verified_at)
```

### Outside Blade

The directive calls `Pharaonic\Laravel\Hijri\Support\HijriFormatter::format()`. Call it directly in controllers, notifications or API resources to get the same output:

```php
use Pharaonic\Laravel\Hijri\Support\HijriFormatter;

HijriFormatter::format($post->published_at);                       // "1 Ramadan 1445"
HijriFormatter::format('2024-03-11', 'dddd D MMMM YYYY', 'ar');   // "الاثنين 1 رَمضان 1445"
```
