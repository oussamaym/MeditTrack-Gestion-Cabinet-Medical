{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}

<style>
  .nav-icon {
    width:1.5rem!important;
    height: 1.5rem!important;
    object-fit:contain !important;
  }
</style>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('medecin') }}">
    <img src="{{ asset('images/i11.png') }}" alt="Logo Médecin" class="nav-icon">
    Medecins
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('patient') }}">
    <img src="{{ asset('images/i12.png') }}" alt="Logo patient" class="nav-icon">
    Patients
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('secretaire') }}">
    <img src="{{ asset('images/i13.png') }}" alt="Logo secretaire" class="nav-icon la la-question">
    secretaire
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('rendez-vous') }}">
    <img src="{{ asset('images/i8.png') }}" alt="Logo rendez-vous" class="nav-icon la la-question">
    Rendez-vous
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('consultation') }}">
    <img src="{{ asset('images/i10.png') }}" alt="Logo consultation" class="nav-icon la la-question">
    Consultations
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('traitement') }}">
  <img src="{{ asset('images/i15.png') }}" alt="Logo traitement" class="nav-icon la la-question" >
    Traitements
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="{{ backpack_url('planning') }}">
    <img src="{{ asset('images/i14.png') }}" alt="Logo planning" class="nav-icon la la-question">
    Plannings
  </a>
</li>
