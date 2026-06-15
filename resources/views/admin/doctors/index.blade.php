@extends('layouts.app')
@section('title', 'Médecins')
@section('header', 'Gestion des Médecins')

@section('content')
<div class="flex justify-between items-center mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher médecin ou spécialité..."
               class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none w-72">
        <button type="submit" class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-xl hover:bg-gray-200 transition">Filtrer</button>
    </form>
    <a href="{{ route('admin.doctors.create') }}"
       class="bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-800 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouveau médecin
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($doctors as $doctor)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center gap-4 mb-4">
            @if($doctor->photo)
                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="" class="w-14 h-14 rounded-full object-cover">
            @else
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xl font-bold">
                    {{ strtoupper(substr($doctor->user->prenom ?? 'D', 0, 1)) }}
                </div>
            @endif
            <div>
                <h4 class="font-bold text-gray-900 text-sm">Dr. {{ $doctor->user->full_name }}</h4>
                <p class="text-blue-700 text-xs">{{ $doctor->specialite }}</p>
                <span class="inline-flex mt-1 items-center gap-1 text-xs {{ $doctor->is_active ? 'text-green-600' : 'text-red-500' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $doctor->is_active ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    {{ $doctor->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>
        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
            <span>{{ $doctor->appointments_count }} rendez-vous</span>
            <span>{{ $doctor->tarif }} MAD / consultation</span>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.doctors.edit', $doctor) }}"
               class="flex-1 text-center bg-blue-50 text-blue-700 text-xs font-semibold py-2 rounded-lg hover:bg-blue-100 transition">
                Modifier
            </a>
            <form method="POST" action="{{ route('admin.doctors.destroy', $doctor) }}"
                  onsubmit="return confirm('Supprimer ce médecin ?')" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-50 text-red-600 text-xs font-semibold py-2 rounded-lg hover:bg-red-100 transition">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 py-16 text-center text-gray-400">
        <p class="text-lg">Aucun médecin enregistré.</p>
        <a href="{{ route('admin.doctors.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Ajouter le premier médecin →</a>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $doctors->withQueryString()->links() }}</div>
@endsection
