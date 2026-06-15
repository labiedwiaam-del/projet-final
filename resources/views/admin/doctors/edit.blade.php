@extends('layouts.app')
@section('title', 'Modifier Médecin')
@section('header', 'Modifier : Dr. ' . $doctor->user->full_name)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité <span class="text-red-500">*</span></label>
                    <input type="text" name="specialite" value="{{ old('specialite', $doctor->specialite) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">N° Licence <span class="text-red-500">*</span></label>
                    <input type="text" name="numero_licence" value="{{ old('numero_licence', $doctor->numero_licence) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Biographie</label>
                <textarea name="bio" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('bio', $doctor->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée (min)</label>
                    <input type="number" name="duree_consultation" value="{{ old('duree_consultation', $doctor->duree_consultation) }}" min="10" max="120"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarif (MAD)</label>
                    <input type="number" name="tarif" value="{{ old('tarif', $doctor->tarif) }}" step="0.01" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                @if($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" class="w-16 h-16 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="photo" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" {{ $doctor->is_active ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 rounded">
                <label for="is_active" class="text-sm text-gray-700">Médecin actif (visible aux patients)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm">
                    Mettre à jour
                </button>
                <a href="{{ route('admin.doctors.index') }}" class="bg-gray-100 text-gray-700 font-semibold px-6 py-2.5 rounded-xl hover:bg-gray-200 transition text-sm">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
