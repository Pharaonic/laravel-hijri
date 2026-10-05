---
view: components.packages.quick-look
title: A quick look
subtitle: Convert both ways with Carbon, then print the result in Blade.
file: routes/web.php
language: php
code: |
  use Carbon\Carbon;

  Route::get('/today', function () {
      $hijri = Carbon::parse('2024-03-11')->toHijri();  // Pharaonic\Hijri\Hijri

      $hijri->format('Y-m-d');                         // "1445-09-01"
      $hijri->locale('ar')->isoFormat('D MMMM YYYY');  // "1 رَمضان 1445"

      $eid = Carbon::fromHijri($hijri->year, 10, 1);   // Gregorian Carbon date

      return view('today', compact('eid'));            // @hijri($eid) in the view
  });
---
