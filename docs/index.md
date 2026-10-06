---
name: Laravel Hijri

action:
  label: View on Packagist
  href: "{package.packagistUrl}"

views: components.packages

breadcrumbs:
  - label: Home
    href: route:home
  - label: Packages
    href: route:packages.index
  - label: "{technology.name} Packages"
    href: "url:/packages/{technology.slug}"
  - label: "{package.name}"

card:
  topic: localization
  icon: clock
  tags: hijri islamic calendar carbon date conversion arabic ramadan blade validation
  description: Hijri dates for Laravel. Convert Carbon dates both ways, print them with @hijri, and validate Hijri input.

seo:
  title: "{package.fullName} - Hijri (Islamic) Calendar Package for Laravel"
  description: "{package.name} is a Laravel package for converting Carbon dates to and from the Hijri (Islamic) calendar, with a Blade directive, a validation rule and Arabic month names. {package.downloadsShort}+ downloads, {package.license} licensed."
  keywords: laravel hijri, hijri date, islamic calendar, hijri carbon, gregorian to hijri, hijri to gregorian, laravel islamic date, hijri validation, arabic date
  author: Pharaonic
  images:
    - "{package.cover}"
  openGraph:
    type: website
    siteName: Pharaonic
  twitter:
    card: summary_large_image

schema:
  "@type": SoftwareSourceCode
  name: "{package.name}"
  description: "{package.name} is a Laravel package for converting dates between the Gregorian and Hijri (Islamic) calendars, with Carbon integration, a Blade directive and a validation rule."
  image: "{package.cover}"
  codeRepository: "{package.githubUrl}"
  programmingLanguage: PHP
  runtimePlatform: "{technology.name}"
  version: "{package.version}"
  datePublished: "{package.publishedAt}"
  dateModified: "{package.updatedAt}"
  license: "https://opensource.org/licenses/{package.license}"
  isAccessibleForFree: true
  sameAs:
    - "{package.githubUrl}"
    - "{package.packagistUrl}"
  author:
    "@id": url:/#organization
  publisher:
    "@id": url:/#organization
  interactionStatistic:
    "@type": InteractionCounter
    interactionType: https://schema.org/DownloadAction
    userInteractionCount: "{package.downloads}"
---
