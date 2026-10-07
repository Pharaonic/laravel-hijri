## Installation

Install the package with Composer. Laravel discovers the service provider automatically.

### Requirements

- PHP 8.1, 8.2 or 8.3
- Laravel 10.x
- `pharaonic/php-hijri` 8.1.3+ on PHP 8.1, 8.2.4+ on PHP 8.2 or 8.3.4+ on PHP 8.3, with a compatible `nesbot/carbon` (both installed automatically)

### Composer Installation

```bash title="Terminal" no-line-numbers
composer require pharaonic/laravel-hijri
```

### Publish Configuration

Publishing the config is optional. Without it, the package uses its defaults (adjustment `-1`, format `D MMMM YYYY`).

```bash title="Terminal" no-line-numbers
php artisan vendor:publish --tag=hijri-config
```

This creates `config/pharaonic/hijri.php`.

### Publish Translations

Publish the validation messages only if you want to change them or add a language.

```bash title="Terminal" no-line-numbers
php artisan vendor:publish --tag=hijri-translations
```

The files are copied to `lang/vendor/hijri`.

:::info Publish Tags
`--tag=laravel-hijri` (or `--tag=pharaonic`) publishes the config and the translations together. `pharaonic-config` and `pharaonic-translations` are also available.
:::

:::success Installation Complete
You're all set! Try `now()->toHijri()->format('Y-m-d')` in `php artisan tinker` to see today's Hijri date.
:::
