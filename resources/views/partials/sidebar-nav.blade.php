{{--
    Navigation latérale dynamique selon le rôle de l'utilisateur.
    Inclus dans layouts/app.blade.php
--}}

@php
    $route = request()->route()->getName();
@endphp

@if(auth()->user()->isAdmin())
    {{-- ── ADMIN ────────────────────────────────── --}}
    @include('partials.nav-item', [
        'href'  => route('admin.dashboard'),
        'label' => 'Tableau de bord',
        'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'active' => str_contains($route, 'admin.dashboard'),
    ])
    @include('partials.nav-item', [
        'href'  => route('admin.users.index'),
        'label' => 'Utilisateurs',
        'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        'active' => str_contains($route, 'admin.users'),
    ])
    @include('partials.nav-item', [
        'href'  => route('admin.doctors.index'),
        'label' => 'Médecins',
        'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'active' => str_contains($route, 'admin.doctors'),
    ])
    @include('partials.nav-item', [
        'href'  => route('admin.appointments.index'),
        'label' => 'Rendez-vous',
        'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'active' => str_contains($route, 'admin.appointments'),
    ])
    @include('partials.nav-item', [
        'href'  => route('admin.statistics'),
        'label' => 'Statistiques',
        'icon'  => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'active' => str_contains($route, 'admin.statistics'),
    ])

@elseif(auth()->user()->isDoctor())
    {{-- ── MÉDECIN ──────────────────────────────── --}}
    @include('partials.nav-item', [
        'href'  => route('doctor.dashboard'),
        'label' => 'Tableau de bord',
        'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'active' => $route === 'doctor.dashboard',
    ])
    @include('partials.nav-item', [
        'href'  => route('doctor.appointments'),
        'label' => 'Rendez-vous',
        'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'active' => str_contains($route, 'doctor.appointments'),
    ])
    @include('partials.nav-item', [
        'href'  => route('doctor.schedules'),
        'label' => 'Mon Planning',
        'icon'  => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'active' => str_contains($route, 'doctor.schedules'),
    ])

@else
    {{-- ── PATIENT ──────────────────────────────── --}}
    @include('partials.nav-item', [
        'href'  => route('patient.dashboard'),
        'label' => 'Tableau de bord',
        'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'active' => $route === 'patient.dashboard',
    ])
    @include('partials.nav-item', [
        'href'  => route('patient.doctors.index'),
        'label' => 'Médecins',
        'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'active' => str_contains($route, 'patient.doctors'),
    ])
    @include('partials.nav-item', [
        'href'  => route('patient.appointments.index'),
        'label' => 'Mes Rendez-vous',
        'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'active' => str_contains($route, 'patient.appointments'),
    ])
    @include('partials.nav-item', [
        'href'  => route('patient.appointments.create'),
        'label' => 'Prendre RDV',
        'icon'  => 'M12 4v16m8-8H4',
        'active' => $route === 'patient.appointments.create',
    ])
@endif
