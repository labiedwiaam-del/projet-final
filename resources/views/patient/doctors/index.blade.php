@extends('layouts.app')
@section('title', 'Nos Médecins')
@section('header', 'Trouver un Médecin')
@section('subheader', 'Consultez notre équipe de spécialistes et réservez votre créneau')

@section('content')

{{-- Barre de recherche --}}
<form method="GET" class="mb-6">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher par nom ou spécialité..."
               class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <button type="submit"
                class="bg-blue-700 text-white text-sm font-semibold px-5 py-3 rounded-xl hover:bg-blue-800 transition">
            Rechercher
        </button>
        @if(request('search'))
        <a href="{{ route('patient.doctors.index') }}"
           class="bg-gray-100 text-gray-700 text-sm px-4 py-3 rounded-xl hover:bg-gray-200 transition">
            Effacer
        </a>
        @endif
    </div>
</form>

{{-- Grille de médecins --}}
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($doctors as $doctor)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
        <div class="flex items-start gap-4 mb-4">
            {{-- Photo --}}
            @if($doctor->photo)
                <img src="{{ asset('storage/' . $doctor->photo) }}" alt=""
                     class="w-16 h-16 rounded-full object-cover flex-shrink-0">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-700 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($doctor->user->prenom ?? 'D', 0, 1)) }}
                </div>
            @endif

            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-900 truncate">Dr. {{ $doctor->user->full_name }}</h3>
                <p class="text-blue-700 text-sm font-medium">{{ $doctor->specialite }}</p>
                <div class="flex items-center gap-1 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    <span class="text-xs text-green-600">Disponible</span>
                </div>
            </div>
        </div>

        @if($doctor->bio)
        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $doctor->bio }}</p>
        @endif

        <div class="flex items-center justify-between text-xs text-gray-500 mb-4 py-3 border-y border-gray-50">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $doctor->duree_consultation ?? 30 }} min / consultation
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ number_format($doctor->tarif ?? 0, 0) }} MAD
            </div>
        </div>

        <a href="{{ route('patient.appointments.create', ['doctor_id' => $doctor->id]) }}"
           class="block text-center bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-blue-800 transition">
            Prendre rendez-vous
        </a>
    </div>
    @empty
    <div class="col-span-3 py-20 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <p class="text-gray-500">Aucun médecin trouvé pour "{{ request('search') }}"</p>
        <a href="{{ route('patient.doctors.index') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
            Voir tous les médecins
        </a>
    </div>
    @endforelse
</div>
@endsection
