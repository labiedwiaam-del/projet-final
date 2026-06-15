@extends('layouts.app')
@section('title', 'Tableau de bord Patient')
@section('header', 'Bienvenue, ' . auth()->user()->prenom . ' 👋')
@section('subheader', 'Gérez vos rendez-vous médicaux facilement')

@section('content')

{{-- ── Stat cards ── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

    {{-- RDV à venir --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">RDV à venir</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['a_venir'] }}</p>
        </div>
    </div>

    {{-- Total --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total rendez-vous</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
    </div>

    {{-- Annulés --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Annulés</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['annule'] }}</p>
        </div>
    </div>
</div>

{{-- ── Main grid ── --}}
<div class="grid lg:grid-cols-3 gap-6">

    {{-- ── Prochain RDV + CTA ── --}}
    <div class="lg:col-span-1 space-y-4">

        @if($nextAppointment)
        {{-- Card prochain RDV --}}
        <div class="rounded-2xl p-6 text-white" style="background: linear-gradient(135deg, #1d4ed8, #0369a1);">
            <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-4">Prochain rendez-vous</p>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                    @if($nextAppointment->doctor?->photo)
                        <img src="{{ asset('storage/' . $nextAppointment->doctor->photo) }}"
                             class="w-12 h-12 rounded-full object-cover" alt="Photo médecin">
                    @else
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="font-bold text-sm">Dr. {{ $nextAppointment->doctor?->user?->full_name }}</p>
                    <p class="text-blue-200 text-xs">{{ $nextAppointment->doctor?->specialite }}</p>
                </div>
            </div>
            <div class="bg-white/15 rounded-xl p-3 space-y-2 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-blue-200 text-xs">Date</span>
                    <span class="font-medium">{{ $nextAppointment->date_rdv?->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-blue-200 text-xs">Heure</span>
                    <span class="font-medium">{{ $nextAppointment->heure_rdv }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-blue-200 text-xs">Statut</span>
                    <span class="text-xs font-semibold bg-white/20 px-2 py-0.5 rounded-full">
                        {{ ucfirst($nextAppointment->statut) }}
                    </span>
                </div>
            </div>
        </div>
        @else
        {{-- Aucun RDV --}}
        <div class="bg-white border border-dashed border-gray-200 rounded-2xl p-8 text-center">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-4">Aucun rendez-vous à venir</p>
            <a href="{{ route('patient.appointments.create') }}"
               class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Prendre un RDV
            </a>
        </div>
        @endif

        {{-- CTA principal --}}
        <a href="{{ route('patient.appointments.create') }}"
           class="flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl transition-colors duration-150 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Prendre un nouveau rendez-vous
        </a>

        {{-- Accès rapides --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 space-y-2">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Accès rapides</p>
            <a href="{{ route('patient.appointments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition-colors duration-150 text-sm">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
                Mes rendez-vous
            </a>
            <a href="{{ route('patient.doctors.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition-colors duration-150 text-sm">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Trouver un médecin
            </a>
        </div>
    </div>

    {{-- ── Historique récent ── --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-800">Derniers rendez-vous</h3>
            <a href="{{ route('patient.appointments.index') }}"
               class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
                Voir tout →
            </a>
        </div>

        @forelse($recentAppointments as $apt)
        <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
            {{-- Avatar médecin --}}
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 text-blue-700 font-bold text-sm">
                {{ strtoupper(substr($apt->doctor?->user?->prenom ?? 'M', 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm text-gray-900 truncate">
                    Dr. {{ $apt->doctor?->user?->full_name }}
                </p>
                <p class="text-xs text-gray-500 truncate">{{ $apt->doctor?->specialite }}</p>
            </div>

            {{-- Date/heure --}}
            <div class="text-right flex-shrink-0 hidden sm:block">
                <p class="text-sm font-medium text-gray-700">{{ $apt->date_rdv?->format('d/m/Y') }}</p>
                <p class="text-xs text-gray-400">{{ $apt->heure_rdv }}</p>
            </div>

            {{-- Badge statut --}}
            <div class="flex-shrink-0">
                @include('partials.status-badge', ['statut' => $apt->statut])
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
            </svg>
            <p class="text-gray-400 text-sm">Aucun rendez-vous pour le moment.</p>
            <a href="{{ route('patient.appointments.create') }}"
               class="inline-flex mt-3 items-center gap-1.5 text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Prendre votre premier rendez-vous
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
