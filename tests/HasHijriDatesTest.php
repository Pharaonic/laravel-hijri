<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Hijri\Hijri;
use Pharaonic\Laravel\Hijri\Concerns\HasHijriDates;

final class HasHijriDatesTest extends TestCase
{
    public function test_it_reads_a_model_date_as_hijri_without_replacing_the_attribute(): void
    {
        $model = new class extends Model
        {
            use HasHijriDates;

            protected $guarded = [];

            protected $casts = [
                'published_at' => 'datetime',
            ];
        };

        $model->setRawAttributes([
            'published_at' => '2024-03-11 10:30:00',
        ]);

        $hijri = $model->hijri('published_at');

        $this->assertInstanceOf(Hijri::class, $hijri);
        $this->assertSame('1445-09-01 10:30', $hijri->format('Y-m-d H:i'));
        $this->assertSame('2024-03-11', $model->published_at->toDateString());
    }

    public function test_it_returns_null_for_a_null_attribute(): void
    {
        $model = new class extends Model
        {
            use HasHijriDates;
        };

        $this->assertNull($model->hijri('published_at'));
    }
}
