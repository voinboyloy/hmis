@extends('layouts.app')

@section('title', 'MediCare Hospital — Landing')

@section('content')
<section class="hero hero-landing">
  <div class="wrap hero-inner">
    <div class="hero-text">
      <h1>Compassionate Care. <span class="accent">Advanced Medicine.</span></h1>
      <p class="lead">Trusted by the community, MediCare Hospital combines clinical excellence with secure digital tools to put your health first.</p>
      <div class="hero-ctas">
        <a href="{{ route('portal.login') }}" class="btn-primary btn-lg">Book Appointment / Patient Portal</a>
        <a href="#services" class="btn-ghost">Meet Our Specialists</a>
      </div>
    </div>
    <div class="hero-visual" aria-hidden="true">
      <!-- Simple illustration placeholder -->
      <div class="visual-box">Team of Doctors</div>
    </div>
  </div>
</section>

<section id="services" class="wrap services">
  <h2>Our Specialized Services</h2>
  <p class="subtitle">Comprehensive care across key medical disciplines with advanced diagnostics and compassionate teams.</p>

  <div class="grid-3">
    <article class="card">
      <h3>Cardiology & Heart Care</h3>
      <p>Preventive cardiology and diagnostic services with experienced specialists.</p>
    </article>
    <article class="card">
      <h3>Pediatrics & Child Health</h3>
      <p>Comprehensive pediatric care, from newborns to adolescents.</p>
    </article>
    <article class="card">
      <h3>24/7 Emergency Care</h3>
      <p>Immediate attention for critical situations anytime.</p>
    </article>
  </div>
</section>

<section class="wrap callout">
  <div class="card">
    <h3>Need Immediate Care?</h3>
    <p>Call our emergency line: <strong>(123) 456-7890</strong></p>
    <a href="tel:+1234567890" class="btn-primary">Call Now</a>
  </div>
</section>
@endsection
