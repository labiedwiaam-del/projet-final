@extends('layouts.app')
@section('title', 'Prendre un Rendez-vous')
@section('header', 'Prendre un Rendez-vous')
@section('subheader', 'Remplissez le formulaire pour réserver votre consultation')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Erreurs --}}
    @if($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <p class="font-semibold mb-1">Veuillez corriger les erreurs suivantes :</p>
        @foreach($errors->all() as $error)
        <p class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ $error }}
        </p>
        @endforeach
    </div>
    @endif

    {{-- Formulaire principal --}}
    <form method="POST" action="{{ route('patient.appointments.store') }}"
          id="rdv-form"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        @csrf

        {{-- En-tête formulaire --}}
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-sky-50 rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Nouvelle réservation</p>
                    <p class="text-xs text-gray-500">Tous les champs marqués <span class="text-red-500">*</span> sont obligatoires</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- 1. Choisir le médecin --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <span class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-700 text-white text-xs font-bold flex items-center justify-center">1</span>
                        Choisir un médecin <span class="text-red-500">*</span>
                    </span>
                </label>

                <div class="space-y-3" id="doctor-list">
                    @foreach($doctors as $doc)
                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all duration-150
                                  hover:border-blue-300 hover:bg-blue-50
                                  {{ old('doctor_id') == $doc->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 bg-white' }}"
                           for="doctor_{{ $doc->id }}">
                        <input type="radio" name="doctor_id" id="doctor_{{ $doc->id }}"
                               value="{{ $doc->id }}"
                               {{ old('doctor_id') == $doc->id ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-700 border-gray-300 focus:ring-blue-500"
                               onchange="document.querySelectorAll('.doctor-label').forEach(el=>el.classList.remove('border-blue-500','bg-blue-50'));this.closest('label').classList.add('border-blue-500','bg-blue-50')">

                        {{-- Avatar --}}
                        @if($doc->photo)
                            <img src="{{ asset('storage/'.$doc->photo) }}"
                                 class="w-12 h-12 rounded-full object-cover flex-shrink-0"
                                 alt="Dr. {{ $doc->user->full_name }}">
                        @else
                            <div class="w-12 h-12 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                {{ strtoupper(substr($doc->user->prenom ?? 'D', 0, 1)) }}
                            </div>
                        @endif

                        {{-- Info médecin --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 text-sm">Dr. {{ $doc->user->full_name }}</p>
                            <p class="text-blue-700 text-xs font-medium mt-0.5">{{ $doc->specialite }}</p>
                            @if($doc->bio)
                            <p class="text-gray-400 text-xs mt-0.5 truncate">{{ $doc->bio }}</p>
                            @endif
                        </div>

                        {{-- Tarif & durée --}}
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-bold text-gray-800">{{ $doc->tarif }} MAD</p>
                            <p class="text-xs text-gray-400">{{ $doc->duree_consultation }} min</p>
                        </div>
                    </label>
                    @endforeach

                    @if($doctors->isEmpty())
                    <div class="text-center py-10 text-gray-400 border-2 border-dashed border-gray-200 rounded-xl">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm">Aucun médecin disponible pour le moment</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- 2. Date et Heure --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="date_rdv" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-700 text-white text-xs font-bold flex items-center justify-center">2</span>
                            Date du rendez-vous <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="date"
                           id="date_rdv"
                           name="date_rdv"
                           value="{{ old('date_rdv') }}"
                           min="{{ date('Y-m-d') }}"
                           required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                  transition @error('date_rdv') border-red-400 bg-red-50 @enderror">
                    @error('date_rdv')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="heure_rdv" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-700 text-white text-xs font-bold flex items-center justify-center">3</span>
                            Heure du rendez-vous <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <select id="heure_rdv"
                            name="heure_rdv"
                            required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                   transition bg-white @error('heure_rdv') border-red-400 bg-red-50 @enderror">
                        <option value="">-- Choisir une heure --</option>
                        @foreach(['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30'] as $h)
                        <option value="{{ $h }}" {{ old('heure_rdv') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                    @error('heure_rdv')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- 3. Motif de consultation --}}
            <div>
                <label for="motif" class="block text-sm font-semibold text-gray-700 mb-2">
                    <span class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-700 text-white text-xs font-bold flex items-center justify-center">4</span>
                        Motif de la consultation <span class="text-gray-400 font-normal text-xs">(optionnel)</span>
                    </span>
                </label>
                <textarea id="motif"
                          name="motif"
                          rows="3"
                          maxlength="500"
                          placeholder="Décrivez brièvement la raison de votre consultation (douleur, suivi, renouvellement d'ordonnance...)"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none
                                 transition resize-none">{{ old('motif') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Maximum 500 caractères</p>
            </div>

            {{-- Note info email --}}
            <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl p-4">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Confirmation par email</p>
                    <p class="text-xs text-blue-600 mt-0.5">
                        Un email de confirmation sera envoyé à <strong>{{ auth()->user()->email }}</strong>
                        dès que votre rendez-vous sera enregistré.
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer formulaire --}}
        <div class="px-6 pb-6 flex items-center gap-3">
            <a href="{{ route('patient.dashboard') }}"
               class="flex items-center gap-2 px-5 py-3 rounded-xl border border-gray-200 bg-gray-50
                      text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Annuler
            </a>
            <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2
                           bg-blue-700 hover:bg-blue-800 text-white font-bold
                           py-3 px-6 rounded-xl transition-colors duration-150
                           shadow-md shadow-blue-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Confirmer le rendez-vous
            </button>
        </div>
    </form>
</div>

<script>
// Mettre en évidence la carte médecin sélectionnée
document.querySelectorAll('input[name="doctor_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('label[for^="doctor_"]').forEach(l => {
            l.classList.remove('border-blue-500', 'bg-blue-50');
            l.classList.add('border-gray-200', 'bg-white');
        });
        this.closest('label').classList.remove('border-gray-200', 'bg-white');
        this.closest('label').classList.add('border-blue-500', 'bg-blue-50');
    });
});
</script>

@endsection
