<?php

namespace Pharaonic\Laravel\Hijri\View\Components;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\View\Component;
use Pharaonic\Laravel\Hijri\Support\HijriFormatter;

final class HijriDate extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  DateTimeInterface|string|null  $date
     */
    public function __construct(
        public $date = null,
        public ?string $format = null,
        public ?string $locale = null,
        public ?int $adjustment = null,
    ) {}

    /**
     * Skip rendering for null or empty dates.
     */
    public function shouldRender(): bool
    {
        return $this->date !== null && $this->date !== '';
    }

    /**
     * The Gregorian date for the `datetime` attribute.
     */
    public function datetime(): string
    {
        return Carbon::parse($this->date)->toDateString();
    }

    /**
     * The formatted Hijri date.
     */
    public function hijri(): string
    {
        return HijriFormatter::format($this->date, $this->format, $this->locale, $this->adjustment);
    }

    public function render(): string
    {
        return <<<'blade'
            <time {{ $attributes->merge(['datetime' => $datetime()]) }}>{{ $hijri() }}</time>
            blade;
    }
}
