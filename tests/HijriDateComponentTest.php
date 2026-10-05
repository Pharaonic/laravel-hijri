<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;

final class HijriDateComponentTest extends TestCase
{
    public function test_it_renders_a_time_element_with_the_default_format(): void
    {
        App::setLocale('en');

        $this->assertSame(
            '<time datetime="2024-03-11">1 Ramadan 1445</time>',
            trim(Blade::render('<x-hijri-date :date="$date" />', [
                'date' => Carbon::parse('2024-03-11 10:30:00'),
            ]))
        );
    }

    public function test_it_accepts_format_locale_and_adjustment(): void
    {
        $this->assertSame(
            '<time datetime="2024-03-11">الاثنين 29 شَعبان 1445</time>',
            trim(Blade::render('<x-hijri-date date="2024-03-11" format="dddd D MMMM YYYY" locale="ar" :adjustment="-2" />'))
        );
    }

    public function test_it_passes_extra_attributes_to_the_time_element(): void
    {
        App::setLocale('en');

        $this->assertSame(
            '<time datetime="2024-03-11" class="text-sm">1445/09/01</time>',
            trim(Blade::render('<x-hijri-date date="2024-03-11" format="YYYY/MM/DD" class="text-sm" />'))
        );
    }

    public function test_it_renders_nothing_for_null(): void
    {
        $this->assertSame('', trim(Blade::render('<x-hijri-date :date="null" />')));
    }
}
