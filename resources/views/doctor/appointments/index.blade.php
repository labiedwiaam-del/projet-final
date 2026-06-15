@extends('layouts.app')
@section('title', 'Mes Rendez-vous')
@section('header', 'Mes Rendez-vous')

@section('content')
<form method="GET" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Statut</label>
        <select name="statut" class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Tous</option>
            @foreach(['programme' => 'Programmé', 'confirme' => 'Confirmé', 'annule' => 'Annulé', 'termine' => 'Terminé'] as $val => $lbl)
            <option value="{{ $val }}" {{ request('statut') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Date</label>
        <input type="date" name="date" value="{{ request('date') }}"
               class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <button type="submit" class="bg-blue-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">Filtrer</button>
    <a href="{{ route('doctor.appointments') }}" class="text-sm text-gray-500 py-2">Réinitialiser</a>
</form>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Patient</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Téléphone</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Date</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Heure</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Motif</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Statut</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($appointments as $apt)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $apt->patient?->full_name }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $apt->patient?->telephone ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $apt->date_rdv?->format('d/m/Y') }}</td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $apt->heure_rdv }}</td>
                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $apt->motif ?? '—' }}</td>
                <td class="px-6 py-4">@include('partials.status-badge', ['statut' => $apt->statut])</td>
                <td class="px-6 py-4">
                    @if(!in_array($apt->statut, ['annule', 'termine']))
                    <form method="POST" action="{{ route('doctor.appointments.status', $apt->id) }}" class="flex gap-1">
                        @csrf @method('PATCH')
                        <select name="statut" onchange="this.form.submit()"
                            class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="confirme" {{ $apt->statut === 'confirme' ? 'selected' : '' }}>Confirmer</option>
                            <option value="termine" {{ $apt->statut === 'termine' ? 'selected' : '' }}>Terminer</option>
                            <option value="annule">Annuler</option>
                        </select>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Aucun rendez-vous trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">{{ $appointments->withQueryString()->links() }}</div>
</div>
@endsection
