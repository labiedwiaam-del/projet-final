@extends('layouts.app')
@section('title', 'Profil médecin — ' . $doctor->user->full_name)
@section('header', 'Dr. ' . $doctor->user->full_name)
@section('subheader', $doctor->specialite)

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.doctors.index') }}" class="text-blue-600 hover:underline text-sm flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Fiche médecin --}}
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            @if($doctor->photo)
                <img src="{{ asset('storage/' . $doctor->photo) }}"
                     class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-blue-100">
            @else
                <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4 text-blue-700 text-3xl font-bold">
                    {{ strtoupper(substr($doctor->user->prenom ?? 'D', 0, 1)) }}
                </div>
            @endif
            <h2 class="text-lg font-bold text-gray-900">Dr. {{ $doctor->user->full_name }}</h2>
            <p class="text-blue-600 text-sm font-medium">{{ $doctor->specialite }}</p>
            <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full {{ $doctor->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                {{ $doctor->is_active ? 'Actif' : 'Inactif' }}
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Email</span>
                <span class="font-medium text-gray-800">{{ $doctor->user->email }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Téléphone</span>
                <span class="font-medium text-gray-800">{{ $doctor->user->telephone ?? '—' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">N° Licence</span>
                <span class="font-medium text-gray-800">{{ $doctor->numero_licence }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Consultation</span>
                <span class="font-medium text-gray-800">{{ $doctor->duree_consultation }} min</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tarif</span>
                <span class="font-medium text-gray-800">{{ number_format($doctor->tarif, 2) }} MAD</span>
            </div>
        </div>

        @if($doctor->bio)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h4 class="font-semibold text-gray-700 mb-2 text-sm">Biographie</h4>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $doctor->bio }}</p>
        </div>
        @endif

        <div class="flex gap-3">
            <a href="{{ route('admin.doctors.edit', $doctor) }}"
               class="flex-1 text-center bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                Modifier
            </a>
            <form method="POST" action="{{ route('admin.doctors.destroy', $doctor) }}"
                  onsubmit="return confirm('Supprimer ce médecin définitivement ?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-100 transition">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Planning + Rendez-vous --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Planning --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4">Planning hebdomadaire</h3>
            @if($doctor->schedules->count())
            <div class="grid sm:grid-cols-2 gap-3">
                @foreach($doctor->schedules->where('actif', true) as $schedule)
                <div class="bg-blue-50 rounded-xl px-4 py-3 text-sm">
                    <span class="font-semibold text-blue-700 capitalize">{{ $schedule->jour_semaine }}</span>
                    <span class="text-gray-600 ml-2">{{ $schedule->heure_debut }} – {{ $schedule->heure_fin }}</span>
                    <span class="text-gray-400 ml-1">({{ $schedule->slot_duration }} min)</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-400 text-sm">Aucun planning configuré.</p>
            @endif
        </div>

        {{-- Derniers rendez-vous --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4">Derniers rendez-vous</h3>
            @if($doctor->appointments->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-3 text-left font-semibold text-gray-500">Patient</th>
                            <th class="pb-3 text-left font-semibold text-gray-500">Date</th>
                            <th class="pb-3 text-left font-semibold text-gray-500">Heure</th>
                            <th class="pb-3 text-left font-semibold text-gray-500">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($doctor->appointments->take(10) as $apt)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-900">{{ $apt->patient?->full_name ?? '—' }}</td>
                            <td class="py-3 text-gray-600">{{ $apt->date_rdv?->format('d/m/Y') }}</td>
                            <td class="py-3 text-gray-600">{{ $apt->heure_rdv }}</td>
                            <td class="py-3">@include('partials.status-badge', ['statut' => $apt->statut])</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-400 text-sm text-center py-6">Aucun rendez-vous enregistré.</p>
            @endif
        </div>
    </div>
</div>
@endsection
