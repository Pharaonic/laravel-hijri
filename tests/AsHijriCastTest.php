<?php

namespace Pharaonic\Laravel\Hijri\Tests;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Hijri\Hijri;
use Pharaonic\Laravel\Hijri\Casts\AsHijri;

final class AsHijriCastTest extends TestCase
{
    public function test_it_reads_a_gregorian_value_as_hijri(): void
    {
        $dueDate = $this->loadedInvoice('2024-03-11 00:00:00')->due_date;

        $this->assertInstanceOf(Hijri::class, $dueDate);
        $this->assertSame('1445-09-01', $dueDate->format('Y-m-d'));
    }

    public function test_it_keeps_null_values(): void
    {
        $invoice = new Invoice(['due_date' => null]);

        $this->assertNull($invoice->due_date);
        $this->assertNull($invoice->getAttributes()['due_date']);
        $this->assertNull($this->loadedInvoice(null)->due_date);
    }

    public function test_it_stores_a_carbon_value_as_gregorian(): void
    {
        $invoice = new Invoice(['due_date' => Carbon::parse('2024-03-11 10:30:00')]);

        $this->assertSame('2024-03-11 10:30:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_stores_a_gregorian_string_as_gregorian(): void
    {
        $invoice = new Invoice(['due_date' => '2024-03-11']);

        $this->assertSame('2024-03-11 00:00:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_converts_a_hijri_value_back_to_gregorian(): void
    {
        $invoice = new Invoice(['due_date' => Hijri::fromGregorian('2024-03-11 14:30:00')]);

        $this->assertSame('2024-03-11 14:30:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_keeps_the_date_of_a_hijri_value_with_a_per_call_adjustment(): void
    {
        $invoice = new Invoice(['due_date' => Hijri::fromGregorian('2024-03-11 14:30:00', null, 1)]);

        $this->assertSame('2024-03-11 14:30:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_stores_a_changed_hijri_value_as_its_new_date(): void
    {
        $dueDate = Hijri::fromGregorian('2024-03-11 00:00:00')->setTime(9, 15);

        $invoice = new Invoice(['due_date' => $dueDate]);

        $this->assertSame('2024-03-11 09:15:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_stores_a_read_value_after_hijri_date_math(): void
    {
        $invoice = $this->loadedInvoice('2024-03-20 10:00:00');

        $invoice->due_date = $invoice->due_date?->addMonth();
        $this->assertSame('2024-04-19 10:00:00', $invoice->getAttributes()['due_date']);

        $invoice->due_date = $invoice->due_date?->startOfMonth();
        $this->assertSame('2024-04-10 00:00:00', $invoice->getAttributes()['due_date']);
    }

    public function test_it_serializes_as_a_hijri_date_string(): void
    {
        $invoice = $this->loadedInvoice('2024-03-11 00:00:00');

        $this->assertSame('1445-09-01', $invoice->toArray()['due_date']);
        $this->assertStringContainsString('"due_date":"1445-09-01"', $invoice->toJson());
    }

    public function test_changing_a_read_value_does_not_change_the_stored_value(): void
    {
        $invoice = $this->loadedInvoice('2024-03-11 00:00:00');

        $invoice->due_date?->addYear();

        // getAttributes() returns exactly what save() would write.
        $this->assertSame('2024-03-11 00:00:00', $invoice->getAttributes()['due_date']);
        $this->assertFalse($invoice->isDirty('due_date'));
    }

    public function test_it_rejects_an_invalid_date_string(): void
    {
        $this->expectException(InvalidFormatException::class);

        new Invoice(['due_date' => 'not a date']);
    }

    /**
     * Build an invoice as if it was loaded from the database.
     */
    private function loadedInvoice(?string $dueDate): Invoice
    {
        return (new Invoice)->setRawAttributes(['due_date' => $dueDate], true);
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
