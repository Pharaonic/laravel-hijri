## Basic Usage

The service provider registers the `Pharaonic\Hijri\HijriCarbon` mixin on `Carbon\Carbon` when your app boots. Every Carbon instance, including `Illuminate\Support\Carbon` from `now()` and Eloquent date attributes, gets the Hijri methods.

### Gregorian to Hijri

`toHijri()` returns a `Pharaonic\Hijri\Hijri` object. It extends Carbon, so its year, month and day are the Hijri values and all the usual formatting methods work.

```php
use Carbon\Carbon;

$hijri = Carbon::parse('2024-03-11 10:30:00')->toHijri();

$hijri->year;                 // 1445
$hijri->month;                // 9
$hijri->day;                  // 1
$hijri->format('Y-m-d H:i');  // "1445-09-01 10:30"
```

It works on any date your app already has:

```php
now()->toHijri()->format('Y-m-d');
$post->created_at->toHijri()->format('Y-m-d');
```

### Hijri to Gregorian

Build a Gregorian Carbon date from Hijri year, month and day:

```php
Carbon::fromHijri(1445, 9, 1)->toDateString();   // "2024-03-11"
Carbon::fromHijri(1446, 10, 1)->toDateString();  // "2025-03-31"
```

Or parse a Hijri string in `YYYY-MM-DD` format, with an optional `HH:MM[:SS]` time part:

```php
Carbon::parseHijri('1445-09-01')->toDateString();           // "2024-03-11"
Carbon::parseHijri('1445-09-01 14:30')->toDateTimeString(); // "2024-03-11 14:30:00"
```

Both accept a timezone as the next argument, and both throw `Pharaonic\Hijri\Exception\InvalidHijriDateException` for a date that doesn't exist (such as `1445-02-30`) or a string in another format.

### Formatting

Format a `Hijri` object with `format()` or `isoFormat()`. Set the locale to get Arabic or English month and day names:

```php
$hijri = Carbon::parse('2024-03-11')->toHijri();

$hijri->locale('en')->isoFormat('dddd D MMMM YYYY'); // "Monday 1 Ramadan 1445"
$hijri->locale('ar')->isoFormat('dddd D MMMM YYYY'); // "الاثنين 1 رَمضان 1445"
```

In Blade views, the [`@hijri` directive](#blade-directive) or the [`<x-hijri-date>` component](#blade-component) does this in one step.

### Eloquent Cast

Cast a date column with `AsHijri` to read it as a `Hijri` object. The column keeps its Gregorian value in the database.

```php
use Pharaonic\Laravel\Hijri\Casts\AsHijri;

class Invoice extends Model
{
    protected function casts(): array
    {
        return [
            'due_date' => AsHijri::class,
        ];
    }
}

$invoice->due_date->format('Y-m-d');   // "1445-09-01"
$invoice->toArray()['due_date'];        // "1445-09-01"
```

You can assign a Carbon date, a Gregorian date string or a `Hijri` object. All of them are stored as Gregorian dates. The cast uses the global adjustment.

:::tip Date Math
Changing the returned `Hijri` object doesn't change the model. To change the date, assign the result back, for example `$invoice->due_date = $invoice->due_date->addMonth()`, which adds one Hijri month.
:::

:::warning Queries
A `Hijri` object formats as a Hijri date, so pass its Gregorian date to queries: `Invoice::where('due_date', $date->toGregorian())`.
:::

### Per-call Adjustment

Pass an adjustment in days to override the global one for a single conversion. It doesn't change the global value.

```php
Carbon::parse('2024-03-11')->toHijri(0)->format('Y-m-d');  // "1445-09-02"
Carbon::parse('2024-03-11')->toHijri(1)->format('Y-m-d');  // "1445-09-03"

Carbon::fromHijri(1445, 9, 1, null, 0);
Carbon::parseHijri('1445-09-01', null, 0);
```

### Changing the Global Adjustment

Read or change the default adjustment at runtime, for example per tenant or per user region:

```php
Carbon::getHijriAdjustment(); // -1

Carbon::setHijriAdjustment(0);
```

:::warning Shared State
The adjustment is a static value shared by the whole PHP process. On Laravel Octane or a long-running queue worker, a value you set during one request or job stays for the next. Prefer a per-call adjustment when it depends on the user.
:::
