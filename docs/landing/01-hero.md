---
view: components.packages.package-hero
badges:
  - label: Laravel Package
    color: blue
  - label: "{package.latestVersionLabel}"
    color: green
  - label: "{package.license} License"
    color: purple
  - label: "{package.downloadsShort}+ downloads"
    color: blue
eyebrow: "{package.name}"
title: Every date, in
highlight: the Hijri calendar
buttons:
  - label: View Full Documentation
    href: "{card.docsUrl}"
    style: primary
    icon: arrow-right
  - label: View on GitHub
    href: "{package.githubUrl}"
    style: ghost
    external: true
install: "{card.install}"
labels:
  copy: Copy
  copied: Copied!
---

Laravel Hijri teaches Carbon the Islamic calendar. Call `toHijri()` on any date in your app, turn Hijri input back into Gregorian dates you can store and query, and print `1 Ramadan 1445` or `1 رَمضان 1445` in your views with one Blade directive.
