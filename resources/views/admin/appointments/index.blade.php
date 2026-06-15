@extends('layouts.app')

@section('title', 'Tous les Rendez-vous')
@section('header', 'Gestion des Rendez-vous')

@section('content')
{{-- Filtres --}}
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
        <label class="block text-xs font-medium text-gray-600 mb-1">Médecin</label>
        <select name="doctor_id" class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Tous les médecins</option>
            @foreach($doctors as $doc)
            <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                Dr. {{ $doc->user->full_name }}
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Du</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Au</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <button type="submit" class="bg-blue-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
        Filtrer
    </button>
    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">
        Réinitialiser
    </a>
</form>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Patient</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Médecin</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Date</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Heure</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Statut</th>
                    <th class="px-6 py-4 text-left font-semibold text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $apt)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $apt->patient?->full_name }}</td>
                    <td class="px-6 py-4 text-gray-600">Dr. {{ $apt->doctor?->user?->full_name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $apt->date_rdv?->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $apt->heure_rdv }}</td>
                    <td class="px-6 py-4">@include('partials.status-badge', ['statut' => $apt->statut])</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            {{-- Changer le statut --}}
                            <form method="POST" action="{{ route('admin.appointments.status', $apt->id) }}" class="flex items-center gap-1">
                                @csrf @method('PATCH')
                                <select name="statut" onchange="this.form.submit()"
                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    @foreach(['programme' => 'Programmé', 'confirme' => 'Confirmé', 'annule' => 'Annulé', 'termine' => 'Terminé'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ $apt->statut === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </form>
                            {{-- Supprimer --}}
                            <form method="POST" action="{{ route('admin.appointments.destroy', $apt->id) }}"
                                  onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Aucun rendez-vous trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $appointments->withQueryString()->links() }}
    </div>
</div>
@endsection
