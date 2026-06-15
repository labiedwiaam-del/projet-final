@extends('layouts.app')
@section('title', 'Mes Rendez-vous')
@section('header', 'Mes Rendez-vous')

@section('content')
<div class="flex justify-between items-center mb-6">
    {{-- Filtres onglets --}}
    <div class="flex gap-1 bg-gray-100 p-1 rounded-xl">
        @foreach(['' => 'Tous', 'upcoming' => 'À venir', 'past' => 'Passés', 'cancelled' => 'Annulés'] as $val => $lbl)
        <a href="{{ route('patient.appointments.index', ['filter' => $val]) }}"
           class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                  {{ request('filter') === $val ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
            {{ $lbl }}
        </a>
        @endforeach
    </div>
    <a href="{{ route('patient.appointments.create') }}"
       class="bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-800 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouveau RDV
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Médecin</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Spécialité</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Date</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Heure</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Statut</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($appointments as $apt)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">Dr. {{ $apt->doctor?->user?->full_name }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $apt->doctor?->specialite }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $apt->date_rdv?->format('d/m/Y') }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $apt->heure_rdv }}</td>
                <td class="px-6 py-4">@include('partials.status-badge', ['statut' => $apt->statut])</td>
                <td class="px-6 py-4">
                    @if($apt->isPending() || $apt->isConfirmed())
                    <form method="POST" action="{{ route('patient.appointments.cancel', $apt->id) }}"
                          onsubmit="return confirm('Annuler ce rendez-vous ?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg transition font-medium">
                            Annuler
                        </button>
                    </form>
                    @else
                    <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400">Aucun rendez-vous trouvé.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                        Prendre votre premier rendez-vous →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">{{ $appointments->withQueryString()->links() }}</div>
</div>
@endsection
