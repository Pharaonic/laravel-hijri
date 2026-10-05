<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hijri Day Adjustment
    |--------------------------------------------------------------------------
    |
    | The core calculator uses a tabular Hijri calendar. Local moon sighting
    | may differ by a day or two, so this value is applied globally when no
    | per-call adjustment is provided. The historic Pharaonic default is -1.
    |
    */

    'adjustment' => (int) env('HIJRI_ADJUSTMENT', -1),

    /*
    |--------------------------------------------------------------------------
    | Default Display Format
    |--------------------------------------------------------------------------
    |
    | The ISO format (Carbon isoFormat tokens) used by the @hijri Blade
    | directive when no explicit format is passed.
    |
    */

    'format' => 'D MMMM YYYY',
];
