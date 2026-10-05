## Validation

`Pharaonic\Laravel\Hijri\Rules\HijriDateRule` checks that the input is a real Hijri date in `YYYY-MM-DD` format, with an optional `HH:MM[:SS]` time part.

```php title="app/Http/Controllers/BookingController.php"
use Pharaonic\Laravel\Hijri\Rules\HijriDateRule;

$request->validate([
    'date' => ['required', new HijriDateRule()],
]);
```

### What Passes

| Value | Result |
| --- | --- |
| `1445-09-01` | Passes |
| `1445-9-1` | Passes |
| `1445-09-01 14:30` | Passes |
| `1445-02-30` | Fails (Safar has 29 days in the tabular calendar) |
| `01/09/1445` | Fails (wrong format) |
| `null`, `123`, blank string | Fails (not a non-empty string) |

The rule parses the value with `Carbon::parseHijri()`, so anything that passes can be converted the same way.

### Error Message

The message comes from the `hijri::validation.hijri_date` translation key:

| Locale | Message |
| --- | --- |
| `en` | The :attribute must be a valid Hijri date. |
| `ar` | يجب أن يكون حقل :attribute تاريخًا هجريًا صالحًا. |

To change the wording, publish the translations (`--tag=hijri-translations`) and edit `resources/lang/vendor/hijri/{locale}/validation.php`. See [Localization](#localization).

:::info Nullable Fields
The rule fails on an empty value. For optional fields, add `nullable` so Laravel skips the rule when the field is empty: `['nullable', new HijriDateRule()]`.
:::
