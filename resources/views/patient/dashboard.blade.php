@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="wrap">
  <h1>Patient Dashboard</h1>

  <section class="card">
    <h2>Your Profile</h2>
    <p>Name: {{ $patient['first_name'] ?? '-' }} {{ $patient['last_name'] ?? '' }}</p>
    <p>DOB: {{ $patient['dob'] ?? '-' }}</p>
  </section>

  <section class="card mt-6">
    <h2>Encounters</h2>
    @if(!empty($encounters))
      <ul>
        @foreach($encounters as $e)
          <li>{{ $e['encounter_date'] }} — {{ $e['notes'] }}</li>
        @endforeach
      </ul>
    @else
      <p class="muted">No encounters found.</p>
    @endif
  </section>
</div>
@endsection
