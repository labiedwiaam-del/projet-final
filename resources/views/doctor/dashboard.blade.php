@extends('layouts.app')
@section('title', 'Tableau de bord Médecin')
@section('header', 'Bonjour, Dr. ' . auth()->user()->full_name)
@section('subheader', 'Voici votre journée du ' . \Carbon\Carbon::today()->locale('fr_FR')->isoFormat('dddd D MMMM YYYY'))

@section('content')

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @include('partials.stat-card', [
        'label'     => 'RDV aujourd\'hui',
        'value'     => $todayAppointments->count(),
        'icon'      => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'iconBg'    => 'bg-blue-100',
        'iconColor' => 'text-blue-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'RDV à venir',
        'value'     => $upcomingCount,
        'icon'      => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'iconBg'    => 'bg-green-100',
        'iconColor' => 'text-green-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'Confirmés',
        'value'     => $todayAppointments->where('statut', 'confirme')->count(),
        'icon'      => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'iconBg'    => 'bg-emerald-100',
        'iconColor' => 'text-emerald-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'Terminés',
        'value'     => $todayAppointments->where('statut', 'termine')->count(),
        'icon'      => 'M5 13l4 4L19 7',
        'iconBg'    => 'bg-purple-100',
        'iconColor' => 'text-purple-600',
    ])
</div>

<div class="grid lg:grid-cols-5 gap-6">
    {{-- Liste des RDV aujourd'hui --}}
    <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-800">Rendez-vous d'aujourd'hui</h3>
            <a href="{{ route('doctor.appointments') }}" class="text-blue-600 text-sm hover:underline">Voir tout</a>
        </div>

        @forelse($todayAppointments as $apt)
        <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
            {{-- Avatar patient --}}
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($apt->patient?->prenom ?? 'P', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm text-gray-900 truncate">{{ $apt->patient?->full_name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $apt->motif ?? 'Consultation générale' }}</p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="font-bold text-gray-800">{{ $apt->heure_rdv }}</p>
                @include('partials.status-badge', ['statut' => $apt->statut])
            </div>
            {{-- Actions rapides --}}
            <form method="POST" action="{{ route('doctor.appointments.status', $apt->id) }}" class="flex gap-1">
                @csrf @method('PATCH')
                @if($apt->statut === 'programme')
                    <button name="statut" value="confirme" class="w-7 h-7 rounded-full bg-green-100 text-green-600 hover:bg-green-200 flex items-center justify-center" title="Confirmer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </button>
                    <button name="statut" value="annule" class="w-7 h-7 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Annuler">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                @elseif($apt->statut === 'confirme')
                    <button name="statut" value="termine" class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 flex items-center justify-center text-xs font-bold" title="Terminer">
                        ✓✓
                    </button>
                @endif
            </form>
        </div>
        @empty
        <div class="text-center py-12">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-400 text-sm">Aucun rendez-vous aujourd'hui</p>
        </div>
        @endforelse
    </div>

    {{-- Prochain patient --}}
    <div class="lg:col-span-2 space-y-4">
        @if($nextPatient)
        <div class="bg-blue-700 text-white rounded-2xl p-6">
            <p class="text-blue-200 text-xs font-semibold uppercase tracking-wider mb-4">Prochain patient</p>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($nextPatient->patient?->prenom ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-lg">{{ $nextPatient->patient?->full_name }}</p>
                    <p class="text-blue-200 text-sm">{{ $nextPatient->patient?->telephone ?? 'Pas de téléphone' }}</p>
                </div>
            </div>
            <div class="bg-white/20 rounded-xl p-3 text-sm space-y-1">
                <div class="flex justify-between">
                    <span class="text-blue-200">Motif</span>
                    <span>{{ $nextPatient->motif ?? 'Consultation' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-200">Heure</span>
                    <span>{{ $nextPatient->heure_rdv }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-blue-200">Durée</span>
                    <span>{{ $nextPatient->duree ?? 30 }} min</span>
                </div>
            </div>
        </div>
        @else
        <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-100">
            <p class="text-gray-400 text-sm">Pas de prochain patient</p>
        </div>
        @endif

        {{-- Lien planning --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h4 class="font-bold text-gray-800 mb-3 text-sm">Mon Planning</h4>
            <p class="text-gray-500 text-xs mb-4">Gérez vos disponibilités hebdomadaires et vos créneaux de consultation.</p>
            <a href="{{ route('doctor.schedules') }}"
               class="w-full flex items-center justify-center gap-2 bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl hover:bg-blue-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Gérer mon planning
            </a>
        </div>
    </div>
</div>
@endsection
