<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Illuminate\Support\Facades\Validator;
use Pharaonic\Laravel\Hijri\Rules\HijriDateRule;

final class HijriDateTest extends TestCase
{
    public function test_it_accepts_a_valid_hijri_date(): void
    {
        $validator = Validator::make([
            'date' => '1445-09-01',
        ], [
            'date' => [new HijriDateRule],
        ]);

        $this->assertTrue($validator->passes());
    }

    public function test_it_rejects_an_invalid_hijri_date(): void
    {
        $validator = Validator::make([
            'date' => '1445-02-30',
        ], [
            'date' => [new HijriDateRule],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_it_rejects_an_invalid_format(): void
    {
        $validator = Validator::make([
            'date' => '01/09/1445',
        ], [
            'date' => [new HijriDateRule],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_it_accepts_the_30th_of_dhu_al_hijjah_in_a_leap_year(): void
    {
        $validator = Validator::make([
            'date' => '1425-12-30',
        ], [
            'date' => [new HijriDateRule],
        ]);

        $this->assertTrue($validator->passes());
    }

    public function test_it_rejects_the_30th_of_dhu_al_hijjah_in_a_common_year(): void
    {
        $validator = Validator::make([
            'date' => '1426-12-30',
        ], [
            'date' => [new HijriDateRule],
        ]);

        $this->assertTrue($validator->fails());
    }
}
