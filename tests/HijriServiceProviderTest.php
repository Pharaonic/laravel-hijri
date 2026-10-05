<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Pharaonic\Hijri\Hijri;

final class HijriServiceProviderTest extends TestCase
{
    public function test_it_registers_the_carbon_mixin(): void
    {
        $hijri = Carbon::parse('2024-03-11')->toHijri();

        $this->assertInstanceOf(Hijri::class, $hijri);
        $this->assertSame('1445-09-01', $hijri->format('Y-m-d'));
    }

    public function test_it_applies_the_configured_adjustment(): void
    {
        $this->assertSame(-1, Hijri::getInstance()->getHijriAdjustment());
    }
}
