## Blade Component

`<x-hijri-date>` prints a Gregorian date as Hijri inside a `<time>` element. The `datetime` attribute holds the Gregorian date, so browsers, screen readers and search engines can read the real date.

```blade
<x-hijri-date :date="$date" format="D MMMM YYYY" locale="ar" adjustment="0" />
```

| Attribute | Type | Default |
| --- | --- | --- |
| `date` | `DateTimeInterface`, `string` or `null` | Required |
| `format` | `string` (Carbon `isoFormat` tokens) | `config('pharaonic.hijri.format')`, `D MMMM YYYY` |
| `locale` | `string` | `app()->getLocale()` |
| `adjustment` | `int` | The global adjustment |

It uses the same formatter as the [`@hijri` directive](#blade-directive), so both print the same text for the same options.

### Default Format

Bind a Carbon date or an Eloquent date attribute with `:date`:

```blade title="resources/views/posts/show.blade.php"
<x-hijri-date :date="$post->published_at" />
{{-- <time datetime="2024-03-11">1 Ramadan 1445</time> --}}
```

A plain string works without the colon:

```blade
<x-hijri-date date="2024-03-11" />
```

### Custom Format and Locale

```blade
<x-hijri-date
    :date="$post->published_at"
    format="dddd D MMMM YYYY"
    locale="ar"
/>
{{-- <time datetime="2024-03-11">الاثنين 1 رَمضان 1445</time> --}}
```

### Custom Adjustment

```blade
<x-hijri-date :date="$event->starts_at" adjustment="0" />
```

### HTML Attributes

Any attribute that isn't one of the four options goes on the `<time>` element:

```blade
<x-hijri-date :date="$post->published_at" class="text-sm text-gray-500" title="Hijri date" />
{{-- <time datetime="2024-03-11" class="text-sm text-gray-500" title="Hijri date">1 Ramadan 1445</time> --}}
```

### Empty Values

A `null` or empty string date renders nothing, not even an empty `<time>` tag:

```blade
<x-hijri-date :date="$user->verified_at" />
```

:::info Directive or Component?
Use `@hijri` when you only need the text, for example inside an attribute or a sentence. Use `<x-hijri-date>` when the date stands on its own in the page, so it gets a machine-readable `datetime`.
:::
