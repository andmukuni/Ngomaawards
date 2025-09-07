@extends('layouts.app')
@section('title', 'Contact Us')

@push('styles')
<style>
  .contact-detail{
    position: relative; color:#fff; min-height: 60vh;
    background-image: url("{{ asset('image/category.jpeg') }}"); /* same bg approach as event page */
    background-position: center center; background-size: cover; background-repeat: no-repeat;
  }
  .contact-detail::before{
    content:""; position:absolute; inset:0; background: rgba(0,0,0,.55); backdrop-filter: blur(.5px);
  }
  .contact-detail .glass{
    position: relative; z-index:1;
    background: rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.15);
    border-radius:1rem; backdrop-filter: blur(4px);
  }
</style>
@endpush

@section('content')
<section class="contact-detail py-5">
  <div class="container position-relative">
    <div class="row">
      <div class="col-12 mb-3">
        <h1 class="fw-bold">Contact Us</h1>
        <p class="mb-0">National Arts Council of Zambia — we’d love to hear from you.</p>
      </div>
    </div>

    @if(session('status'))
      <div class="alert alert-success d-flex align-items-center glass">
        <i class="bi bi-check2-circle me-2"></i>
        <div>{{ session('status') }}</div>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger glass">
        <div class="fw-semibold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>There were issues with your submission</div>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="row g-4 align-items-stretch">
      {{-- Left: Org Details (glass card) --}}
      <div class="col-lg-5">
        <div class="glass p-4 h-100">
          <h5 class="fw-bold mb-3">National Arts Council of Zambia</h5>
          <ul class="list-unstyled m-0">
            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-person-badge fs-4"></i>
              <div>
                <div class="fw-semibold">Director</div>
                <div>{{ $org['director'] }}</div>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-geo-alt fs-4"></i>
              <div itemscope itemtype="https://schema.org/PostalAddress">
                <div class="fw-semibold">Address</div>
                <div itemprop="streetAddress">{{ $org['address_1'] }}</div>
                <div itemprop="postOfficeBoxNumber">{{ $org['po_box'] }}</div>
                <a class="link-warning fw-semibold" target="_blank" rel="noopener"
                   href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($org['address_1'].' '.$org['po_box']) }}">
                  Open in Google Maps
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-envelope fs-4"></i>
              <div>
                <div class="fw-semibold">Email</div>
                <a class="text-white text-decoration-underline" href="mailto:{{ $org['email'] }}">{{ $org['email'] }}</a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-telephone fs-4"></i>
              <div>
                <div class="fw-semibold">Phone</div>
                <div><a class="text-white text-decoration-underline" href="tel:+260979313121">{{ $org['mobile'] }}</a></div>
                <div><a class="text-white text-decoration-underline" href="tel:+260211220638">{{ $org['landline'] }}</a></div>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light border-opacity-10">
              <i class="bi bi-browser-chrome fs-4"></i>
              <div>
                <div class="fw-semibold">Website</div>
                <a class="text-white text-decoration-underline" href="http://{{ $org['website'] }}" target="_blank" rel="noopener">
                  {{ $org['website'] }}
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3 py-2">
              <i class="bi bi-facebook fs-4"></i>
              <div>
                <div class="fw-semibold">Facebook</div>
                <a class="text-white text-decoration-underline" href="{{ $org['facebook'] }}" target="_blank" rel="noopener">
                  {{ $org['facebook'] }}
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>

      {{-- Right: Contact Form (glass card) --}}
      <div class="col-lg-7">
        <div class="glass p-4 h-100">
          <h5 class="fw-bold mb-3">Send us a message</h5>
          <form method="POST" action="{{ route('contact.store') }}" class="needs-validation" novalidate>
            @csrf

            {{-- Honeypot --}}
            <input type="text" name="website_url" class="d-none" tabindex="-1" autocomplete="off">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                <div class="invalid-feedback">Please provide a valid email.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+260 ...">
              </div>

              <div class="col-md-6">
                <label class="form-label">Subject <span class="text-danger">*</span></label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                <div class="invalid-feedback">Please enter a subject.</div>
              </div>

              <div class="col-12">
                <label class="form-label">Message <span class="text-danger">*</span></label>
                <textarea name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
                <div class="invalid-feedback">Please type your message.</div>
              </div>

              <div class="col-12 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-warning fw-semibold btn-submit">
                  <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                  Send Message
                </button>
                <a href="mailto:{{ $org['email'] }}" class="btn btn-outline-light">
                  <i class="bi bi-envelope me-1"></i>Email Instead
                </a>
                {{-- Optional quick WhatsApp using mobile number --}}
                <a href="https://wa.me/260979313121" target="_blank" rel="noopener" class="btn btn-success">
                  <i class="bi bi-whatsapp me-1"></i>WhatsApp
                </a>
              </div>
            </div>
          </form>
        </div>

        <script>
          (function () {
            // Bootstrap client-side validation + spinner/disable on submit
            const form = document.querySelector('form.needs-validation');
            const btn  = form.querySelector('.btn-submit');
            const spn  = btn.querySelector('.spinner-border');
            form.addEventListener('submit', function (e) {
              if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
              } else {
                btn.disabled = true;
                spn.classList.remove('d-none');
              }
              form.classList.add('was-validated');
            }, false);
          })();
        </script>
      </div>
    </div>
  </div>
</section>
@endsection
