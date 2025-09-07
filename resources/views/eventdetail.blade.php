@extends('layouts.app')
@section('title', 'Ngoma Awards — Event Detail')

@section('content')
@php
  use Carbon\Carbon;

  $eventTitle = 'Ngoma Awards Night 2025';
  $eventVenue = 'CIELA RESORT AND SPA, Bonanza Estate, Lusaka, Zambia';

  // Event time (Africa/Lusaka): 11 Dec 2025, 18:00 → 24:00 (midnight)
  $eventLocal = Carbon::create(2025, 12, 11, 18, 0, 0, 'Africa/Lusaka');
  $eventEnd   = $eventLocal->copy()->addHours(6); // reaches 00:00 of 12 Dec 2025

  // UTC for Google Calendar / ICS
  $dtStartZ = $eventLocal->copy()->setTimezone('UTC')->format('Ymd\THis\Z');
  $dtEndZ   = $eventEnd->copy()->setTimezone('UTC')->format('Ymd\THis\Z');

  $aboutText = 'The 20th Edition of the prestigious national artistic honour and award ceremony. '
             . 'The Ngoma motivates, recognises and celebrates artistic excellence. '
             . 'A total of 44 awards will be given out to deserving artists who will receive the iconic Ngoma Trophy. '
             . 'The Ngoma Awards recognise artists in music, dance, theatre, community theatre, fashion, media arts, comedy, visual arts and creative writing.';

  $gcal = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
        . '&text=' . rawurlencode($eventTitle)
        . '&dates=' . $dtStartZ . '/' . $dtEndZ
        . '&details=' . rawurlencode($aboutText)
        . '&location=' . rawurlencode($eventVenue)
        . '&sf=true&output=xml';

  $ics = "BEGIN:VCALENDAR\r\n"
       . "VERSION:2.0\r\n"
       . "PRODID:-//Ngoma Awards//Event//EN\r\n"
       . "CALSCALE:GREGORIAN\r\n"
       . "METHOD:PUBLISH\r\n"
       . "X-WR-CALNAME:Ngoma Awards\r\n"
       . "BEGIN:VEVENT\r\n"
       . "UID:ngoma-".uniqid()."@ngoma-awards\r\n"
       . "DTSTAMP:".now('UTC')->format('Ymd\THis\Z')."\r\n"
       . "DTSTART:{$dtStartZ}\r\n"
       . "DTEND:{$dtEndZ}\r\n"
       . "SUMMARY:{$eventTitle}\r\n"
       . "LOCATION:{$eventVenue}\r\n"
       . "DESCRIPTION:".str_replace(["\n", "\r"], '', $aboutText)."\r\n"
       . "END:VEVENT\r\n"
       . "END:VCALENDAR\r\n";
  $icsHref = 'data:text/calendar;charset=utf-8,' . rawurlencode($ics);

  $waPhone = '260973790404';
  $waText  = rawurlencode("Hi Ngoma Awards team, I’d like to ask about the event.");
@endphp

<style>
  .event-detail{
    position: relative; color:#fff; min-height: 60vh;
    background-image: url("{{ asset('image/category.jpeg') }}");
    background-position: center center; background-size: cover; background-repeat: no-repeat;
  }
  .event-detail::before{
    content:""; position:absolute; inset:0; background: rgba(0,0,0,.55); backdrop-filter: blur(.5px);
  }
  .event-detail .glass{
    position: relative; z-index:1;
    background: rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.15);
    border-radius:1rem; backdrop-filter: blur(4px);
  }
  .countdown .num{font-weight:800;font-size:clamp(1.5rem,3.5vw,2.25rem);line-height:1;}
  .countdown .lbl{font-size:.8rem;opacity:.9;letter-spacing:.02em;}
</style>

<section class="event-detail py-5" data-event-start="{{ $eventLocal->toIso8601String() }}">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-8">
        <div class="glass p-4 h-100">
          <h2 class="fw-bold mb-3">Event Details</h2>
          <ul class="list-unstyled m-0">
            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-calendar2-event fs-4"></i>
              <div>
                <div class="fw-semibold">Date & Time</div>
                <div>
                  <time datetime="{{ $eventLocal->toDateString() }}">
                    {{ $eventLocal->format('l jS F Y') }}
                  </time>
                  &middot; {{ $eventLocal->format('g:i A') }} – {{ $eventEnd->format('g:i A') }} CAT
                </div>
                <div class="small opacity-75">24-hour: {{ $eventLocal->format('H:i') }}hrs to {{ $eventEnd->format('H:i') }}hrs</div>
              </div>
            </li>
            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-geo-alt fs-4"></i>
              <div>
                <div class="fw-semibold">Venue</div>
                <div>{{ $eventVenue }}</div>
                <a class="link-warning fw-semibold" target="_blank" rel="noopener"
                   href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($eventVenue) }}">
                  Get directions
                </a>
              </div>
            </li>
            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-person-badge fs-4"></i>
              <div>
                <div class="fw-semibold">Dress Code</div>
                <div>Black-tie with a touch of creativity</div>
              </div>
            </li>
            <li class="d-flex align-items-start gap-3 py-2">
              <i class="bi bi-info-circle fs-4"></i>
              <div>
                <div class="fw-semibold">About</div>
                <div>{{ $aboutText }}</div>
              </div>
            </li>
          </ul>

          <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="{{ $gcal }}" target="_blank" rel="noopener" class="btn btn-warning fw-semibold">
              <i class="bi bi-calendar-plus me-1"></i> Add to Google Calendar
            </a>
            <a href="{{ $icsHref }}" download="NgomaAwards2025.ics" class="btn btn-outline-light">
              <i class="bi bi-download me-1"></i> Get Ticket Now
            </a>
            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank" rel="noopener" class="btn btn-success">
              <i class="bi bi-whatsapp me-1"></i> Chat with us
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="glass p-4 h-100 d-flex flex-column justify-content-between">
          <div>
            <h3 class="fw-bold mb-3"><i class="bi bi-hourglass-split me-2"></i>Countdown</h3>
            <div class="countdown row text-center g-2" id="countdown">
              <div class="col-3"><div class="num" id="cd-days">--</div><div class="lbl">Days</div></div>
              <div class="col-3"><div class="num" id="cd-hours">--</div><div class="lbl">Hours</div></div>
              <div class="col-3"><div class="num" id="cd-mins">--</div><div class="lbl">Mins</div></div>
              <div class="col-3"><div class="num" id="cd-secs">--</div><div class="lbl">Secs</div></div>
            </div>
          </div>
          <div class="mt-4">
            <small class="opacity-75">Event local time:
              <strong>{{ $eventLocal->format('D, j M Y - g:i A') }} CAT</strong>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
(function(){
  const root = document.querySelector('.event-detail');
  if (!root) return;
  const target = Date.parse(root.dataset.eventStart);
  const dEl = document.getElementById('cd-days');
  const hEl = document.getElementById('cd-hours');
  const mEl = document.getElementById('cd-mins');
  const sEl = document.getElementById('cd-secs');

  function tick(){
    const now = Date.now();
    let diff = Math.max(0, target - now);
    const days  = Math.floor(diff / 86400000); diff -= days*86400000;
    const hours = Math.floor(diff / 3600000);  diff -= hours*3600000;
    const mins  = Math.floor(diff / 60000);    diff -= mins*60000;
    const secs  = Math.floor(diff / 1000);
    dEl.textContent = String(days);
    hEl.textContent = String(hours).padStart(2,'0');
    mEl.textContent = String(mins).padStart(2,'0');
    sEl.textContent = String(secs).padStart(2,'0');
  }
  tick(); setInterval(tick, 1000);
})();
</script>
@endsection
