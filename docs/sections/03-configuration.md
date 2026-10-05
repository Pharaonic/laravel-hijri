## Configuration

The config file lives at `config/pharaonic/hijri.php` after publishing and is read under the `pharaonic.hijri` key.

```php title="config/pharaonic/hijri.php"
return [
    'adjustment' => (int) env('HIJRI_ADJUSTMENT', -1),

    'format' => 'D MMMM YYYY',
];
```

### Options

| Key | Default | Description |
| --- | --- | --- |
| `adjustment` | `-1` (from `HIJRI_ADJUSTMENT`) | Days added to every Hijri conversion when no per-call adjustment is given. |
| `format` | `D MMMM YYYY` | The [Carbon `isoFormat`](https://carbon.nesbot.com/docs/#api-localization) tokens the `@hijri` directive uses when you don't pass a format. |

### Day Adjustment

The underlying calculator uses the tabular Hijri calendar. Actual month starts depend on local moon sighting and can differ by a day or two, so the adjustment lets you align the output with your region. The historic Pharaonic default is `-1`.

Set it from your environment:

```bash title=".env" no-line-numbers
HIJRI_ADJUSTMENT=0
```

```php title="tinker"
Carbon::parse('2024-03-11')->toHijri()->format('Y-m-d');  // "1445-09-01" (adjustment -1)
Carbon::parse('2024-03-11')->toHijri(0)->format('Y-m-d'); // "1445-09-02"
```

:::warning Applied at Boot
The service provider reads `pharaonic.hijri.adjustment` once while booting and stores it as the global default. Changing the config at runtime with `config([...])` doesn't change it. Use `Carbon::setHijriAdjustment()` or pass an adjustment per call instead (see [Basic Usage](#basic-usage)).
:::

### Default Format

`format` is only used by the `@hijri` directive and `HijriFormatter::format()`. It accepts any Carbon `isoFormat` pattern:

| Format | Output (`en`) |
| --- | --- |
| `D MMMM YYYY` | `1 Ramadan 1445` |
| `dddd D MMMM YYYY` | `Monday 1 Ramadan 1445` |
| `YYYY/MM/DD` | `1445/09/01` |
| `ddd, D MMM YYYY` | `Mon, 1 Ramadan 1445` |
