---
view: components.home.faq
badge: FAQ
title: "{package.name}"
highlight: Questions
subtitle: "Quick answers about installing and using {package.name}."
---

## What is {package.name}?

{card.description} It's a free, open-source {technology.name} package by Pharaonic.

## How do I install {package.name}?

Run `composer require {package.composer}` in your project's root directory.

## What does {package.name} require?

The latest release requires {package.requiresText}.

## Is {package.name} free to use?

Yes. {package.name} is open source under the {package.license} license, so you can use it in personal and commercial projects.

## Why is the Hijri date one day off from my local calendar?

The package uses the tabular Hijri calendar, while official month starts depend on moon sighting. Set `HIJRI_ADJUSTMENT` in your `.env` (the default is `-1`), or pass an adjustment to a single call like `toHijri(0)`.

## Should I store Hijri dates in the database?

No. Store dates as Gregorian, so sorting, queries and date math keep working, and convert to Hijri when you display them. Use `Carbon::parseHijri()` to turn Hijri input into a Gregorian date before saving.

## How do I show Arabic month names?

Set the locale to Arabic: `$date->toHijri()->locale('ar')`. The `@hijri` Blade directive follows your app locale, or accepts a locale as its third argument.

## How do I validate a Hijri date from a form?

Add `new HijriDateRule()` to your rules. It accepts `YYYY-MM-DD` with an optional time and rejects dates that don't exist in the Hijri calendar.

## Where can I find the {package.name} documentation?

Read the [{package.name} documentation]({package.docsUrl}) for setup, configuration, and usage examples.

## How do I report a bug or contribute to {package.name}?

Open an issue or a pull request on [GitHub]({package.githubUrl}), or ask in the [Pharaonic Discord](https://discord.gg/XQG9RhvEvf).
