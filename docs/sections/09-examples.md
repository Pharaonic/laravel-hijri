## Examples

### 1. Show Hijri Dates on a Model

Add an accessor that returns the Hijri date, and print it next to the Gregorian one.

- ===Model

  ```php title="app/Models/Post.php"
  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Pharaonic\Laravel\Hijri\Support\HijriFormatter;

  class Post extends Model
  {
      protected $casts = ['published_at' => 'datetime'];

      public function getPublishedAtHijriAttribute(): string
      {
          return HijriFormatter::format($this->published_at);
      }
  }
  ```

- ===Blade View

  ```blade title="resources/views/posts/show.blade.php"
  <article>
      <h1>{{ $post->title }}</h1>

      <p class="meta">
          {{ $post->published_at->format('j F Y') }}
          · @hijri($post->published_at, 'dddd D MMMM YYYY')
      </p>
  </article>
  ```

- ===API Output

  ```php title="app/Http/Resources/PostResource.php"
  namespace App\Http\Resources;

  use Illuminate\Http\Resources\Json\JsonResource;

  class PostResource extends JsonResource
  {
      public function toArray($request)
      {
          return [
              'title' => $this->title,
              'published_at' => $this->published_at->toDateString(),
              'published_at_hijri' => $this->published_at->toHijri()->format('Y-m-d'),
              'published_at_hijri_label' => $this->published_at_hijri,
          ];
      }
  }
  ```

### 2. Accept a Hijri Date in a Form

Validate the Hijri input, then store it as a Gregorian date so your queries keep working.

- ===Form Request

  ```php title="app/Http/Requests/StoreBookingRequest.php"
  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;
  use Pharaonic\Laravel\Hijri\Rules\HijriDateRule;

  class StoreBookingRequest extends FormRequest
  {
      public function rules()
      {
          return [
              'name' => ['required', 'string', 'max:255'],
              'date' => ['required', new HijriDateRule()],
          ];
      }
  }
  ```

- ===Controller

  ```php title="app/Http/Controllers/BookingController.php"
  namespace App\Http\Controllers;

  use App\Http\Requests\StoreBookingRequest;
  use App\Models\Booking;
  use Carbon\Carbon;

  class BookingController extends Controller
  {
      public function store(StoreBookingRequest $request)
      {
          Booking::create([
              'name' => $request->name,
              'date' => Carbon::parseHijri($request->date), // "1445-09-01" → 2024-03-11
          ]);

          return back()->with('status', 'Booking saved.');
      }
  }
  ```

- ===Blade Form

  ```blade title="resources/views/bookings/create.blade.php"
  <form method="POST" action="{{ route('bookings.store') }}">
      @csrf

      <input name="name" value="{{ old('name') }}">

      <input name="date" placeholder="1445-09-01" value="{{ old('date') }}">
      @error('date') <span>{{ $message }}</span> @enderror

      <button type="submit">Book</button>
  </form>
  ```

### 3. Zakat Due Date

Zakat is due one full Hijri year (hawl) after savings reach the nisab. A Hijri year is about 11 days shorter than a Gregorian one, so adding `->addYear()` gives the wrong date. Add the year in Hijri, then convert back.

```php title="app/Models/Account.php"
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $casts = ['nisab_reached_at' => 'datetime'];

    public function getZakatDueAtAttribute(): Carbon
    {
        $start = $this->nisab_reached_at->toHijri(); // 2024-03-11 → 1445-09-01

        // Hijri months have 29 or 30 days, so cap the day to stay valid.
        return Carbon::fromHijri($start->year + 1, $start->month, min($start->day, 29)); // → 2025-03-01
    }
}
```

```blade title="resources/views/accounts/show.blade.php"
<p>
    Zakat due on {{ $account->zakat_due_at->format('j F Y') }}
    (@hijri($account->zakat_due_at, 'D MMMM YYYY')),
    in {{ now()->diffInDays($account->zakat_due_at) }} days.
</p>
```

### 4. Find the Gregorian Date of an Occasion

Get the Gregorian start of a Hijri month, for example to schedule a campaign or a reminder.

```php title="app/Console/Commands/ScheduleEidReminder.php"
use Carbon\Carbon;

$hijriYear = now()->toHijri()->year;

$ramadan = Carbon::fromHijri($hijriYear, 9, 1);   // 1446 → 2025-03-01
$eidFitr = Carbon::fromHijri($hijriYear, 10, 1);  // 1446 → 2025-03-31
$eidAdha = Carbon::fromHijri($hijriYear, 12, 10);

if ($eidFitr->isPast()) {
    $eidFitr = Carbon::fromHijri($hijriYear + 1, 10, 1);
}

$daysLeft = now()->diffInDays($eidFitr);
```

### 5. Per-user Region Adjustment

Let users pick an adjustment that matches their country's moon sighting, and pass it per call so other requests aren't affected.

```php title="app/Models/User.php"
use Pharaonic\Laravel\Hijri\Support\HijriFormatter;

// Assumes `locale` and `hijri_adjustment` columns on your users table.
public function hijri($date): string
{
    return HijriFormatter::format($date, null, $this->locale, $this->hijri_adjustment);
}
```

```blade title="resources/views/dashboard.blade.php"
@hijri(now(), 'dddd D MMMM YYYY', auth()->user()->locale, auth()->user()->hijri_adjustment)
```
