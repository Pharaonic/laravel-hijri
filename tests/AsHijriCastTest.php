<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Pharaonic\Hijri\Hijri;
use Pharaonic\Laravel\Hijri\Casts\AsHijri;

final class AsHijriCastTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
    }

    protected function defineDatabaseMigrations(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->dateTime('due_date')->nullable();
        });
    }

    public function test_it_reads_a_gregorian_value_as_hijri(): void
    {
        $invoice = Invoice::create(['due_date' => '2024-03-11']);

        $dueDate = $invoice->fresh()?->due_date;

        $this->assertInstanceOf(Hijri::class, $dueDate);
        $this->assertSame('1445-09-01', $dueDate->format('Y-m-d'));
    }

    public function test_it_keeps_null_values(): void
    {
        $invoice = Invoice::create(['due_date' => null]);

        $this->assertNull($invoice->fresh()?->due_date);
        $this->assertNull($this->rawDueDate($invoice));
    }

    public function test_it_stores_a_carbon_value_as_gregorian(): void
    {
        $invoice = Invoice::create(['due_date' => Carbon::parse('2024-03-11 10:30:00')]);

        $this->assertSame('2024-03-11 10:30:00', $this->rawDueDate($invoice));
    }

    public function test_it_stores_a_gregorian_string_as_gregorian(): void
    {
        $invoice = Invoice::create(['due_date' => '2024-03-11']);

        $this->assertSame('2024-03-11 00:00:00', $this->rawDueDate($invoice));
    }

    public function test_it_converts_a_hijri_value_back_to_gregorian(): void
    {
        $hijri = Hijri::fromGregorian('2024-03-11 14:30:00');

        $invoice = Invoice::create(['due_date' => $hijri]);

        $this->assertSame('2024-03-11 14:30:00', $this->rawDueDate($invoice));
    }

    public function test_it_serializes_as_a_hijri_date_string(): void
    {
        $invoice = Invoice::create(['due_date' => '2024-03-11'])->fresh();

        $this->assertSame('1445-09-01', $invoice?->toArray()['due_date']);
        $this->assertStringContainsString('"due_date":"1445-09-01"', (string) $invoice?->toJson());
    }

    public function test_changing_a_read_value_does_not_change_the_database(): void
    {
        $invoice = Invoice::create(['due_date' => '2024-03-11'])->fresh();

        $invoice?->due_date?->addYear();
        $invoice?->save();

        $this->assertSame('2024-03-11 00:00:00', $this->rawDueDate($invoice));
    }

    public function test_it_rejects_an_invalid_date_string(): void
    {
        $this->expectException(InvalidFormatException::class);

        Invoice::create(['due_date' => 'not a date']);
    }

    private function rawDueDate(?Model $model): mixed
    {
        return DB::table('invoices')->where('id', $model?->getKey())->value('due_date');
    }
}

/**
 * @property Hijri|null $due_date
 */
class Invoice extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'due_date' => AsHijri::class,
        ];
    }
}
