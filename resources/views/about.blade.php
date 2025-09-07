@extends('layouts.app')
@section('title', 'About — Ngoma Awards')

@push('styles')
<style>
  .about-detail{
    position: relative; color:#fff; min-height: 60vh;
    background-image: url("{{ asset('image/category.jpeg') }}"); /* same approach as event page */
    background-position: center center; background-size: cover; background-repeat: no-repeat;
  }
  .about-detail::before{
    content:""; position:absolute; inset:0; background: rgba(0,0,0,.55); backdrop-filter: blur(.5px);
  }
  .about-detail .glass{
    position: relative; z-index:1;
    background: rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.15);
    border-radius:1rem; backdrop-filter: blur(4px);
  }
  .about-detail .section-title { font-weight: 800; letter-spacing:.02em; }
  .about-detail .icon { width: 2.25rem; height: 2.25rem; display:inline-flex; align-items:center; justify-content:center; }
  .about-detail .bullet li { margin-bottom:.4rem; }
</style>
@endpush

@section('content')
<section class="about-detail py-5">
  <div class="container position-relative">
    <div class="row">
      <div class="col-12 mb-3">
        <h1 class="fw-bold">About the Ngoma Awards</h1>
        <p class="mb-0">Zambia’s premier national platform for recognising, celebrating, and motivating artistic excellence.</p>
      </div>
    </div>

    <div class="row g-4 align-items-stretch">
      {{-- Vision & Purpose --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-stars"></i></span>
            <h3 class="section-title m-0">Vision & Purpose</h3>
          </div>
          <p class="mb-0">
            The core mission of the Ngoma Awards is to <strong>Recognise, Celebrate, and Motivate Artistic Excellence</strong>—honouring outstanding achievements, uplifting artists across all disciplines, and inspiring continued growth and innovation in Zambia’s creative industry.
          </p>
        </div>
      </div>

      {{-- Legacy & Cultural Value --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-trophy"></i></span>
            <h3 class="section-title m-0">Legacy & Cultural Value</h3>
          </div>
          <ul class="bullet mb-0 ps-3">
            <li>Promotes excellence and the highest standards of professionalism.</li>
            <li>Shapes Zambia’s creative identity and artistic landscape.</li>
            <li>Strengthens the arts ecosystem—connecting artists, partners, and audiences.</li>
            <li>Benchmarks quality by upholding rigorous artistic standards.</li>
            <li>Provides national recognition that elevates careers and validates merit.</li>
            <li>Draws prestige and public attention to the arts, encouraging policy support.</li>
          </ul>
        </div>
      </div>

      {{-- Long-Term Impact --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-graph-up-arrow"></i></span>
            <h3 class="section-title m-0">Long-Term Impact</h3>
          </div>
          <ul class="bullet mb-0 ps-3">
            <li>Higher quality and standards across art forms.</li>
            <li>Motivated creatives striving to produce their best work.</li>
            <li>Wider recognition and promotion of diverse disciplines.</li>
            <li>More investment, sponsorship, and public appreciation.</li>
            <li>A thriving sector that exemplifies artistic excellence.</li>
          </ul>
        </div>
      </div>

      {{-- Background & Legacy --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-clock-history"></i></span>
            <h3 class="section-title m-0">Background & Legacy</h3>
          </div>
          <p class="mb-2">
            Established in <strong>1997</strong> as the National Honours and Awards Show, Ngoma has long chronicled Zambia’s artistic achievements. In <strong>1998</strong>, a national call for a name led to “Ngoma” (“drum” across many Zambian languages)—a symbol of communication, identity, and community.
          </p>
          <p class="mb-2">
            Over time, the programme expanded from 21 categories to embrace more associations and disciplines, touring cities nationwide (e.g., Livingstone and Kitwe) to underscore its national character. Editions in 2019, 2022 and beyond have further diversified categories and prize structures, reflecting the sector’s growth.
          </p>
          <p class="mb-0">
            Each award honours a fallen hero of Zambian arts—making Ngoma not just an accolade, but a <em>national tribute</em> to creativity, resilience, and cultural heritage.
          </p>
        </div>
      </div>

      {{-- What Sets Ngoma Apart --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-award"></i></span>
            <h3 class="section-title m-0">What Sets Ngoma Apart</h3>
          </div>
          <ul class="bullet mb-0 ps-3">
            <li><strong>National</strong> in scope; <strong>all art forms</strong> represented.</li>
            <li>Excellence, prestige, and the <strong>iconic Ngoma trophy</strong>.</li>
            <li>Live performances and a show experience befitting Zambia’s flagship arts celebration.</li>
            <li>Longest-running arts awards in Zambia (since 1997).</li>
          </ul>
        </div>
      </div>

      {{-- Perception --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-megaphone"></i></span>
            <h3 class="section-title m-0">Perception & Reach</h3>
          </div>
          <p class="mb-2">
            Locally, Ngoma is a career milestone—an endorsement of achievement that often catalyses new opportunities. The public associates the brand with high standards and artistic excellence.
          </p>
          <p class="mb-0">
            Regionally and internationally, awareness is growing—Ngoma serves as a springboard to broader recognition for Zambian creatives.
          </p>
        </div>
      </div>

      {{-- Categories & Ceremony --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-list-ul"></i></span>
            <h3 class="section-title m-0">Categories</h3>
          </div>
          <p class="mb-2">Ngoma recognises excellence across:</p>
          <div class="row g-2">
            <div class="col-6">
              <ul class="bullet ps-3 mb-0">
                <li>Dance</li>
                <li>Music</li>
                <li>Creative Writing</li>
                <li>Fashion</li>
                <li>Comedy</li>
              </ul>
            </div>
            <div class="col-6">
              <ul class="bullet ps-3 mb-0">
                <li>Theatre</li>
                <li>Community Theatre</li>
                <li>Visual Arts</li>
                <li>Film & Media Arts</li>
              </ul>
            </div>
          </div>
          <hr class="border-light border-opacity-25 my-3">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-brilliance"></i></span>
            <h4 class="h5 m-0">Ceremony Format</h4>
          </div>
          <ul class="bullet ps-3 mb-0">
            <li>Red Carpet & Live Performances</li>
            <li>Exhibitions, Showcases & Speeches</li>
          </ul>
        </div>
      </div>

      {{-- Audience --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-people"></i></span>
            <h3 class="section-title m-0">Audience</h3>
          </div>
          <p class="mb-2">Artists, art lovers, the public, promoters, industry professionals, sponsors and corporates, families & friends of artists, and the Zambian diaspora.</p>
          <ul class="bullet ps-3">
            <li><strong>Demographics:</strong> 18–55+; students, new entrants, mid-career and professionals.</li>
            <li><strong>Engagement:</strong> Social media, program involvement, and rich on-night experiences across diverse art forms.</li>
          </ul>
          <p class="mb-0"></p>
        </div>
      </div>

      {{-- Value Proposition (Sponsors/Partners) --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-briefcase"></i></span>
            <h3 class="section-title m-0">Why Partner with Ngoma</h3>
          </div>
          <ul class="bullet ps-3 mb-0">
            <li>Brand exposure to national, regional, and diaspora audiences.</li>
            <li>Association with Zambia’s premier arts celebration and positive cultural impact.</li>
            <li>Customisable visibility across televised show and build-up moments.</li>
            <li>Contribution to the growth of Zambia’s creative economy.</li>
          </ul>
        </div>
      </div>

      {{-- Marketing Snapshot & Budget --}}
      <div class="col-lg-6">
        <div class="glass p-4 h-100">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="icon rounded-circle bg-warning text-dark"><i class="bi bi-broadcast"></i></span>
            <h3 class="section-title m-0">Marketing & Budget Snapshot</h3>
          </div>
          <ul class="bullet ps-3 mb-2">
            <li><strong>Channels:</strong> Social (IG, TikTok, Facebook, X), TV & Radio, Print, Outdoor, Diaspora campaigns.</li>
            <li><strong>Tactics:</strong> Media partnerships, nominee-led influence, briefings, countdowns, BTS content, community activations.</li>
          </ul>
          <p class="mb-0"><strong>Projected Ceremony Budget:</strong> K6,000,000.</p>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
