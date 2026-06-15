@extends('layouts.app')
@section('title', 'Détail Patient')
@section('header', 'Patient : ' . $patient->full_name)

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-2xl font-bold">
                {{ strtoupper(substr($patient->prenom ?? 'P', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h2>
                <p class="text-gray-500 text-sm">{{ $patient->email }}</p>
                <p class="text-gray-500 text-sm">{{ $patient->telephone ?? 'Pas de téléphone' }}</p>
            </div>
        </div>

        <h3 class="font-semibold text-gray-700 mb-3">Historique des rendez-vous avec vous</h3>
        @php
            $doctorId = auth()->user()->doctor?->id;
            $appointments = $patient->appointments()
                ->where('medecin_id', $doctorId)
                ->with('doctor.user')
                ->orderByDesc('date_rdv')
                ->get();
        @endphp

        @forelse($appointments as $apt)
        <div class="flex items-center justify-between py-3 border-b border-gray-50">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ $apt->date_rdv?->format('d/m/Y') }} à {{ $apt->heure_rdv }}</p>
                <p class="text-xs text-gray-500">{{ $apt->motif ?? 'Consultation' }}</p>
            </div>
            @include('partials.status-badge', ['statut' => $apt->statut])
        </div>
        @empty
        <p class="text-gray-400 text-sm py-4">Aucun rendez-vous trouvé.</p>
        @endforelse

        <div class="mt-6">
            <a href="{{ route('doctor.appointments') }}"
               class="bg-gray-100 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-gray-200 transition">
                ← Retour aux rendez-vous
            </a>
        </div>
    </div>
</div>
@endsection
