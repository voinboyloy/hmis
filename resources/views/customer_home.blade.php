@extends('layouts.app')

@section('title', 'Patient Home')

@section('content')
<div class="wrap">
  <section class="card welcome">
    <div class="welcome-left">
      <h1>Welcome back, @if(session('patient_name')){{ session('patient_name') }}@else Patient @endif</h1>
      <p>Access your records, appointments and test results securely through the portal.</p>
    </div>
    <div class="welcome-actions">
      <a href="{{ route('portal.book') }}" class="btn-primary">Book Appointment</a>
      <a href="{{ route('portal.dashboard') }}" class="btn-ghost">Open Portal</a>
    </div>
  </section>

  <section class="grid-3 mt-16">
    <div class="card">
      <h3>Latest Visit</h3>
      <p class="muted">@if(isset($latestVisit)){{ $latestVisit['summary'] }}<br>{{ $latestVisit['date'] }}@else No visits yet. @endif</p>
      <a href="{{ route('portal.dashboard') }}" class="link">View full visit</a>
    </div>
    <div class="card">
      <h3>Upcoming Appointments</h3>
      <ul>
        @if(!empty($appointments))
          @foreach($appointments as $a)
            <li>{{ $a['time'] }} — {{ $a['doctor'] }}</li>
          @endforeach
        @else
          <li class="muted">No upcoming appointments</li>
        @endif
      </ul>
      <a href="{{ route('portal.book') }}" class="link">Manage appointments</a>
    </div>
    <div class="card">
      <h3>Prescriptions</h3>
      @if(!empty($prescriptions))
        @foreach($prescriptions as $p)
          <p>{{ $p['medication'] }} — {{ $p['instructions'] }}</p>
        @endforeach
      @else
        <p class="muted">No current prescriptions</p>
      @endif
      <a href="{{ route('portal.dashboard') }}" class="link">View prescriptions</a>
    </div>
  </section>

  <section class="card mt-12">
    <h3>Recent Medical Records</h3>
    <div class="grid-3">
      @foreach($records ?? [] as $r)
        <div class="record">
          <h4>{{ $r['title'] }}</h4>
          <p class="muted">{{ $r['date'] }}</p>
          <p>{{ $r['summary'] }}</p>
        </div>
      @endforeach
      @if(empty($records))
        <p class="muted">No records to display.</p>
      @endif
    </div>
    <div class="mt-4">
      <a href="{{ route('portal.dashboard') }}" class="link">View full records</a>
    </div>
  </section>
</div>
@endsection
