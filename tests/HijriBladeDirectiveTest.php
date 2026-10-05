<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;

final class HijriBladeDirectiveTest extends TestCase
{
    private function render(string $template, array $data = []): string
    {
        ob_start();
        extract($data);
        eval('?>'.Blade::compileString($template));

        return trim((string) ob_get_clean());
    }

    public function test_it_renders_with_the_default_format(): void
    {
        App::setLocale('en');

        $this->assertSame('1 Ramadan 1445', $this->render('@hijri($date)', [
            'date' => Carbon::parse('2024-03-11 10:30:00'),
        ]));
    }

    public function test_it_renders_with_a_custom_format_and_locale(): void
    {
        $this->assertSame('الاثنين 1 رَمضان 1445', $this->render("@hijri('2024-03-11', 'dddd D MMMM YYYY', 'ar')"));
    }

    public function test_it_uses_the_configured_default_format(): void
    {
        App::setLocale('en');
        config(['pharaonic.hijri.format' => 'YYYY/MM/DD']);

        $this->assertSame('1445/09/01', $this->render("@hijri('2024-03-11')"));
    }

    public function test_it_renders_nothing_for_null(): void
    {
        $this->assertSame('', $this->render('@hijri($date)', ['date' => null]));
    }
}
