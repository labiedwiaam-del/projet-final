@extends('layouts.app')
@section('title', 'Mon Planning')
@section('header', 'Gestion du Planning')
@section('subheader', 'Définissez vos disponibilités hebdomadaires')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
    <form method="POST" action="{{ route('doctor.schedules.store') }}" class="space-y-4">
        @csrf

        {{-- Légende --}}
        <div class="flex items-center gap-6 text-sm text-gray-600 mb-6 p-4 bg-blue-50 rounded-xl">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span>Actif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                <span>Inactif</span>
            </div>
            <p class="ml-auto text-xs text-gray-500">Cochez "Actif" pour activer un jour de consultation</p>
        </div>

        @php
            $joursLabels = [
                'lundi'    => 'Lundi',
                'mardi'    => 'Mardi',
                'mercredi' => 'Mercredi',
                'jeudi'    => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi'   => 'Samedi',
                'dimanche' => 'Dimanche',
            ];
        @endphp

        @foreach($jours as $jour)
        @php $s = $schedules[$jour] ?? null; @endphp
        <div class="border border-gray-100 rounded-xl p-4 {{ $s?->actif ? 'bg-green-50 border-green-200' : 'bg-gray-50' }} transition">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Checkbox actif --}}
                <div class="flex items-center gap-2 w-32">
                    <input type="checkbox" name="schedules[{{ $jour }}][actif]" id="actif_{{ $jour }}"
                           {{ $s?->actif ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 rounded">
                    <label for="actif_{{ $jour }}" class="font-semibold text-sm text-gray-800">
                        {{ $joursLabels[$jour] }}
                    </label>
                </div>

                {{-- Heure début --}}
                <div class="flex items-center gap-2">
                    <label class="text-xs text-gray-500">De</label>
                    <input type="time" name="schedules[{{ $jour }}][heure_debut]"
                           value="{{ old("schedules.{$jour}.heure_debut", $s?->heure_debut ?? '09:00') }}"
                           class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Heure fin --}}
                <div class="flex items-center gap-2">
                    <label class="text-xs text-gray-500">À</label>
                    <input type="time" name="schedules[{{ $jour }}][heure_fin]"
                           value="{{ old("schedules.{$jour}.heure_fin", $s?->heure_fin ?? '17:00') }}"
                           class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Durée créneau --}}
                <div class="flex items-center gap-2">
                    <label class="text-xs text-gray-500">Créneau</label>
                    <select name="schedules[{{ $jour }}][slot_duration]"
                            class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @foreach([15, 20, 30, 45, 60] as $min)
                        <option value="{{ $min }}" {{ ($s?->slot_duration ?? 30) == $min ? 'selected' : '' }}>
                            {{ $min }} min
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endforeach

        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl hover:bg-blue-800 transition">
                Enregistrer le planning
            </button>
        </div>
    </form>
</div>
@endsection
