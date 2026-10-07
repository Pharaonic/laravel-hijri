<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Carbon\Laravel\ServiceProvider as CarbonServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;

/**
 * Hijri dates must not change how Gregorian dates on the same page (or in the
 * same long-running process) print their month names.
 */
final class HijriTranslatorIsolationTest extends TestCase
{
    private const TEMPLATE = "@hijri(\$date) | {{ \$date->translatedFormat('F') }} | {{ \$date->isoFormat('MMMM') }}";

    protected function getPackageProviders($app): array
    {
        // Laravel apps discover Carbon's provider, which follows App::setLocale().
        return array_merge(parent::getPackageProviders($app), [
            CarbonServiceProvider::class,
        ]);
    }

    private function render(string $template, array $data = []): string
    {
        ob_start();
        extract($data);
        eval('?>'.Blade::compileString($template));

        return trim((string) ob_get_clean());
    }

    private function renderPage(): string
    {
        return $this->render(self::TEMPLATE, ['date' => Carbon::parse('2024-03-11')]);
    }

    public function test_gregorian_month_names_stay_gregorian_in_english(): void
    {
        App::setLocale('en');

        $this->assertSame('1 Ramadan 1445 | March | March', $this->renderPage());
    }

    public function test_gregorian_month_names_stay_gregorian_in_arabic(): void
    {
        App::setLocale('ar');

        $this->assertSame('1 رَمضان 1445 | مارس | مارس', $this->renderPage());
    }

    public function test_gregorian_month_names_stay_gregorian_in_a_regional_arabic_locale(): void
    {
        App::setLocale('ar_EG');

        $this->assertSame('1 رَمضان 1445 | مارس | مارس', $this->renderPage());
    }

    public function test_the_component_does_not_change_gregorian_month_names(): void
    {
        App::setLocale('en');

        $this->assertSame(
            '<time datetime="2024-03-11">1 Ramadan 1445</time> | March | March',
            Blade::render(
                "<x-hijri-date :date=\"\$date\" /> | {{ \$date->translatedFormat('F') }} | {{ \$date->isoFormat('MMMM') }}",
                ['date' => Carbon::parse('2024-03-11')]
            )
        );
    }

    public function test_repeated_renders_do_not_change_the_gregorian_output(): void
    {
        App::setLocale('en');

        for ($i = 0; $i < 200; $i++) {
            $this->assertSame('1 Ramadan 1445 | March | March', $this->renderPage());
        }
    }

    public function test_it_keeps_the_29th_of_safar(): void
    {
        $this->assertSame('29 Safar 1442', $this->render("@hijri('2020-10-16', 'D MMMM YYYY', 'en', 0)"));
    }
}
