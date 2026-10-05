---
view: components.packages.features
variant: compact
badge: Key Features
title: Everything you need for Hijri dates in Laravel
subtitle: Install it and every Carbon date already speaks Hijri, with no setup code.
items:
  - icon: clock
    title: Carbon Mixin
    text: Call `toHijri()` on `now()`, Eloquent dates or any Carbon instance.
  - icon: database
    title: Hijri to Gregorian
    text: "`Carbon::fromHijri()` and `Carbon::parseHijri()` give you a Gregorian date to store."
  - icon: code
    title: Blade Directive
    text: "`@hijri($date)` prints a localized Hijri date in your default format."
  - icon: shield-check
    title: Validation Rule
    text: "`HijriDateRule` rejects impossible dates like `1445-02-30`, with English and Arabic messages."
  - icon: switch
    title: Day Adjustment
    text: Match local moon sighting with `HIJRI_ADJUSTMENT`, or per call.
  - icon: translate
    title: Arabic Month Names
    text: Arabic locales get `رَمضان`, every other locale gets `Ramadan`.
---
