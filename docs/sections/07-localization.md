## Localization

### Month and Day Names

A `Hijri` object picks month names from its locale. Any locale starting with `ar` gets the Arabic names, and every other locale gets transliterated English names. Day names come from Carbon's translations for that locale.

```php
$hijri = Carbon::parse('2025-03-01')->toHijri();

$hijri->locale('en')->isoFormat('D MMMM YYYY'); // "1 Ramadan 1446"
$hijri->locale('ar')->isoFormat('D MMMM YYYY'); // "1 رَمضان 1446"
```

| # | Arabic (`ar`) | Other locales |
| --- | --- | --- |
| 1 | مُحرَّم | Muharram |
| 2 | صفَر | Safar |
| 3 | ربيع الأول | Rabi' Al-Awwal |
| 4 | ربيع الآخر | Rabi' Al-Akher |
| 5 | جمادى الأول | Jumada Al-Awwal |
| 6 | جمادى الآخرة | Jumada Al-Akherah |
| 7 | رَجب | Rajab |
| 8 | شَعبان | Sha'aban |
| 9 | رَمضان | Ramadan |
| 10 | شوّال | Shawwal |
| 11 | ذو القِعدة | Dhu Al-Qi'dah |
| 12 | ذو الحِجّة | Dhu Al-Hijjah |

The `@hijri` directive and `HijriFormatter::format()` use `app()->getLocale()` unless you pass a locale, so switching the app locale switches the output:

```php
app()->setLocale('ar');
```

### Validation Messages

The package registers its translations under the `hijri` namespace and ships `en` and `ar`. To edit them or add a language, publish them:

```bash title="Terminal" no-line-numbers
php artisan vendor:publish --tag=hijri-translations
```

Then add a folder for your locale with the same key:

```php title="lang/vendor/hijri/fr/validation.php"
return [
    'hijri_date' => 'Le champ :attribute doit être une date hégirienne valide.',
];
```
