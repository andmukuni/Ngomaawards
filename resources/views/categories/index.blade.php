{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Popular Voting Categories — Ngoma Awards')

@push('styles')
  {{-- Hover effects --}}
  <link href="https://unpkg.com/hover.css@2.3.2/css/hover-min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .overlay-dark {
      background: linear-gradient(to top, rgba(0,0,0,.7), transparent);
    }
    .category-card {
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    .category-card:hover { transform: translateY(-5px); }

    /* Force labels to show in the modal even if the theme hides them */
    #nominationModal .form-label{
      display:block !important;
      position:static !important;
      height:auto !important;
      width:auto !important;
      clip:auto !important;
      clip-path:none !important;
      overflow:visible !important;
      margin-bottom:.4rem;
      color:#111 !important;   /* dark on white modal */
      font-weight:600;
    }

    /* Optional: nicer placeholders/inputs in the modal */
    #nominationModal .form-control::placeholder { color:#9aa0a6; }
    #nominationModal .form-select { color:#111; }
  </style>
@endpush

@section('content')
<!-- Add CSRF token here if not in layout -->
@if(!View::hasSection('csrf-token'))
<meta name="csrf-token" content="{{ csrf_token() }}">
@endif

<section class="py-5 bg-dark text-white">
  <div class="container">
    <h2 class="mb-4 fw-bold">Popular Voting Categories</h2>

    <div class="d-flex flex-wrap gap-3 mb-4">
      <button class="btn btn-light btn-sm rounded-pill fw-semibold active"><i class="bi bi-stars me-1"></i> For You</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-camera-reels me-1"></i> TV &amp; Film</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-music-note-beamed me-1"></i> Music</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-emoji-laughing me-1"></i> Comedy</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-person-bounding-box me-1"></i> Models</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-geo-alt me-1"></i> Regional</button>
      <button class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-trophy me-1"></i> Overall</button>
    </div>

    <div class="row g-4">
      @php
        $categories = [
          'Best TV Series of the Year',
          'Best Actress of the Year (TV & Film)',
          'Best Actor of the Year (TV & Film)',
          'Best Song of the Year',
          'Best Song Collaboration of the Year',
          'Best Online/Social Media Comedian',
          'Best Male Model of the Year',
          'Best Female Model of the Year',
          'Best Regional Artist Male',
          'Best Regional Artist Female',
          'Overall Best Artist',
        ];
      @endphp

      @foreach($categories as $cat)
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 rounded-4 overflow-hidden text-white hvr-grow-shadow category-card"
               data-bs-toggle="modal" data-bs-target="#nominationModal"
               data-category="{{ $cat }}">
            <img src="{{ asset('image/hero.jpg') }}" class="card-img" alt="{{ $cat }}">
            <div class="card-img-overlay d-flex flex-column justify-content-end p-3 overlay-dark">
              <h5 class="fw-bold">{{ $cat }}</h5>
              <span class="btn btn-sm btn-warning fw-semibold mt-2 align-self-start">
                <i class="bi bi-award-fill me-1"></i> Nominate Now
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>

<!-- Nomination Modal -->
<div class="modal fade" id="nominationModal" tabindex="-1" aria-labelledby="nominationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="nominationModalLabel">
          <i class="bi bi-envelope-paper-heart"></i>
          <span>Submit Nomination</span>
          <span id="modalCategoryTitle" class="badge bg-warning text-dark ms-2"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="nominationForm" method="POST" action="{{ route('nominations.store') }}">
        @csrf
        <div class="modal-body">
          {{-- Hidden category (sent with form) --}}
          <input type="hidden" id="selectedCategory" name="category">

          {{-- Dynamic fields injected here (3 per category) --}}
          <div id="dynamicFields"></div>

          {{-- Messages --}}
          <div id="successMessage" class="alert alert-success d-none mt-3" role="alert" aria-live="polite">
            <i class="bi bi-check-circle-fill me-1"></i> Nomination submitted successfully!
          </div>
          <div id="errorMessage" class="alert alert-danger d-none mt-3" role="alert" aria-live="polite">
            <i class="bi bi-exclamation-octagon-fill me-1"></i> <span id="errorText">Something went wrong. Please try again.</span>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-warning fw-semibold d-inline-flex align-items-center gap-2" id="submitBtn">
            <span class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status" aria-hidden="true"></span>
            <i class="bi bi-send-fill" id="submitIcon"></i>
            <span id="submitText">Submit Nomination</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const nominationModal    = document.getElementById('nominationModal');
  const selectedCategory   = document.getElementById('selectedCategory');
  const dynamicFieldsWrap  = document.getElementById('dynamicFields');
  const nominationForm     = document.getElementById('nominationForm');

  const submitBtn          = document.getElementById('submitBtn');
  const submitSpinner      = document.getElementById('submitSpinner');
  const submitIcon         = document.getElementById('submitIcon');
  const submitText         = document.getElementById('submitText');

  const successMessage     = document.getElementById('successMessage');
  const errorMessage       = document.getElementById('errorMessage');
  const errorText          = document.getElementById('errorText');

  const modalCategoryTitle = document.getElementById('modalCategoryTitle');

  // === Category Schemas (exactly 3 fields, each with placeholder + title) ===
  const SCHEMAS = {
    "Best TV Series of the Year": [
      { type:"text",   name:"series_name",  label:"TV Series Name",     placeholder:"e.g., Zed Nights", required:true },
      { type:"text",   name:"network",      label:"Network/Platform",    placeholder:"e.g., Netflix, ZNBC", required:true },
      { type:"number", name:"year",         label:"Release Year",        placeholder:"e.g., 2024", required:true }
    ],
    "Best Actress of the Year (TV & Film)": [
      { type:"text",   name:"actress_name", label:"Actress Name",        placeholder:"e.g., Jane Banda", required:true },
      { type:"text",   name:"movie",        label:"Movie/TV Show",       placeholder:"e.g., Zambezi Dreams", required:true },
      { type:"text",   name:"role",         label:"Role/Character",      placeholder:"e.g., Thandi", required:true }
    ],
    "Best Actor of the Year (TV & Film)": [
      { type:"text",   name:"actor_name",   label:"Actor Name",          placeholder:"e.g., John Mwila", required:true },
      { type:"text",   name:"movie",        label:"Movie/TV Show",       placeholder:"e.g., Lusaka Nights", required:true },
      { type:"text",   name:"role",         label:"Role/Character",      placeholder:"e.g., Kunda", required:true }
    ],
    "Best Song of the Year": [
      { type:"text",   name:"song_title",   label:"Song Title",          placeholder:"e.g., Golden Vibes", required:true },
      { type:"text",   name:"artist",       label:"Artist Name",         placeholder:"e.g., DJ Kantu", required:true },
      { type:"number", name:"release_year", label:"Release Year",        placeholder:"e.g., 2024", required:true }
    ],
    "Best Song Collaboration of the Year": [
      { type:"text",   name:"song_title",        label:"Song Title",     placeholder:"e.g., Unity Jam", required:true },
      { type:"text",   name:"main_artist",       label:"Main Artist",    placeholder:"e.g., King Jay", required:true },
      { type:"text",   name:"featured_artists",  label:"Featured Artists",placeholder:"e.g., Queen Zee, B-Mike", required:true }
    ],
    "Best Online/Social Media Comedian": [
      { type:"text",   name:"stage_name",  label:"Stage/Channel Name",   placeholder:"e.g., ZedLaughs", required:true },
      { type:"select", name:"platform",    label:"Primary Platform",     placeholder:"Select a platform", options:["Facebook","Instagram","TikTok","YouTube","X (Twitter)"], required:true },
      { type:"text",   name:"profile_url", label:"Profile URL (optional)",          placeholder:"https://...", required:true }
    ],
    "Best Male Model of the Year": [
      { type:"text",   name:"model_name",     label:"Model Name",        placeholder:"e.g., Peter Zulu", required:true },
      { type:"text",   name:"agency",         label:"Agency (optional)", placeholder:"e.g., Elite Lusaka" },
      { type:"text",   name:"portfolio_url",  label:"Portfolio/Instagram", placeholder:"https://instagram.com/..." }
    ],
    "Best Female Model of the Year": [
      { type:"text",   name:"model_name",     label:"Model Name",        placeholder:"e.g., Mary Phiri", required:true },
      { type:"text",   name:"agency",         label:"Agency (optional)", placeholder:"e.g., Top Models Zambia" },
      { type:"text",   name:"portfolio_url",  label:"Portfolio/Instagram", placeholder:"https://instagram.com/..." }
    ],
    "Best Regional Artist Male": [
      { type:"text",   name:"stage_name",   label:"Stage Name",          placeholder:"e.g., KBoy", required:true },
      { type:"text",   name:"region",       label:"Province/Region",     placeholder:"e.g., Lusaka", required:true },
      { type:"text",   name:"popular_song", label:"Popular Song",        placeholder:"e.g., Street Lights" }
    ],
    "Best Regional Artist Female": [
      { type:"text",   name:"stage_name",   label:"Stage Name",          placeholder:"e.g., Miss Leya", required:true },
      { type:"text",   name:"region",       label:"Province/Region",     placeholder:"e.g., Southern", required:true },
      { type:"text",   name:"popular_song", label:"Popular Song",        placeholder:"e.g., Heartbeat" }
    ],
    "Overall Best Artist": [
      { type:"text",   name:"stage_name",     label:"Stage/Group Name",  placeholder:"e.g., The Ngoma Crew", required:true },
      { type:"select", name:"domain",         label:"Primary Domain",    placeholder:"Select a domain", options:["Music","Dance","Comedy","Theatre","Film & Media","Fashion","Visual Arts"], required:true },
      { type:"text",   name:"signature_work", label:"Signature Work",    placeholder:"e.g., Album/Project" }
    ]
  };

  // Build a labeled input/select with placeholder + title
  function buildField(f) {
    const col = document.createElement('div');
    col.className = 'mb-3';
    const id = 'f_' + f.name;

    const label = document.createElement('label');
    label.className = 'form-label fw-semibold';
    label.setAttribute('for', id);
    label.textContent = f.label;

    let input;
    if (f.type === 'select') {
      input = document.createElement('select');
      input.className = 'form-select';
      input.id = id; input.name = f.name; input.title = f.label;

      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = f.placeholder || 'Select…';
      opt.disabled = true; opt.selected = true;
      input.appendChild(opt);

      (f.options || []).forEach(o => {
        const el = document.createElement('option');
        el.value = o; el.textContent = o;
        input.appendChild(el);
      });
    } else {
      input = document.createElement('input');
      input.type = f.type || 'text';
      input.className = 'form-control';
      input.id = id; input.name = f.name;
      input.placeholder = f.placeholder || '';
      input.title = f.label;
    }

    if (f.required) input.required = true;

    col.appendChild(label);
    col.appendChild(input);
    return col;
  }

  function renderSchemaFor(category) {
    dynamicFieldsWrap.innerHTML = '';
    const fields = SCHEMAS[category] || [
      { type:"text", name:"nominee_name", label:"Nominee Name", placeholder:"Enter nominee name", required:true }
    ];
    const row = document.createElement('div');
    row.className = 'row g-3';
    fields.forEach(f => {
      const col = document.createElement('div');
      col.className = 'col-md-6';
      col.appendChild(buildField(f));
      row.appendChild(col);
    });
    dynamicFieldsWrap.appendChild(row);
  }

  // Prep modal on show
  nominationModal.addEventListener('show.bs.modal', ev => {
    const trigger  = ev.relatedTarget;
    const category = trigger?.getAttribute('data-category') || '';
    selectedCategory.value = category;
    modalCategoryTitle.textContent = category || '';
    renderSchemaFor(category);

    // reset messages/button state
    successMessage.classList.add('d-none');
    errorMessage.classList.add('d-none');
    submitBtn.disabled = false;
    submitSpinner.classList.add('d-none');
    submitIcon.classList.remove('d-none');
    submitText.textContent = 'Submit Nomination';
  });

  // AJAX Form Submission Handler
  nominationForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Show loading state
    submitBtn.disabled = true;
    submitSpinner.classList.remove('d-none');
    submitIcon.classList.add('d-none');
    submitText.textContent = 'Submitting...';
    
    // Hide previous messages
    successMessage.classList.add('d-none');
    errorMessage.classList.add('d-none');
    
    try {
      const formData = new FormData(nominationForm);
      const response = await fetch(nominationForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      
      const data = await response.json();
      
      if (data.success) {
        // Show success message
        successMessage.classList.remove('d-none');
        
        // Reset form
        nominationForm.reset();
        
        // Close modal after 2 seconds
        setTimeout(() => {
          const modal = bootstrap.Modal.getInstance(nominationModal);
          modal.hide();
        }, 2000);
      } else {
        // Show error message
        errorText.textContent = data.message || 'Something went wrong. Please try again.';
        if (data.errors) {
          // Display validation errors
          console.error('Validation errors:', data.errors);
          errorText.textContent = 'Please check your inputs and try again.';
        }
        errorMessage.classList.remove('d-none');
        
        // Re-enable button
        submitBtn.disabled = false;
        submitSpinner.classList.add('d-none');
        submitIcon.classList.remove('d-none');
        submitText.textContent = 'Submit Nomination';
      }
    } catch (error) {
      // Show error message
      errorText.textContent = 'Network error. Please check your connection and try again.';
      errorMessage.classList.remove('d-none');
      
      // Re-enable button
      submitBtn.disabled = false;
      submitSpinner.classList.add('d-none');
      submitIcon.classList.remove('d-none');
      submitText.textContent = 'Submit Nomination';
    }
  });
});
</script>
@endpush