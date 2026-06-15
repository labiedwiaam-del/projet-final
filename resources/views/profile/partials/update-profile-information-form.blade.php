<form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>

<form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Prénom</label>
            <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('prenom') border-red-400 @enderror">
            @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nom') border-red-400 @enderror">
            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-400 @enderror">
        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

        {{-- Alerte email non vérifié (patients uniquement) --}}
        @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-800">
            ⚠️ Email non vérifié.
            <button form="send-verification"
                    class="underline font-semibold hover:text-yellow-900 ml-1">
                Renvoyer le lien de vérification
            </button>
            @if(session('status') === 'verification-link-sent')
            <p class="mt-1 text-green-600 font-medium">✅ Lien envoyé !</p>
            @endif
        </div>
        @endif

        @if($user->isPatient())
        <p class="text-xs text-gray-400 mt-1">Domaines acceptés : @gmail.com · @hotmail.fr · @yahoo.com</p>
        @endif
    </div>

    <div class="flex items-center gap-4">
        <button type="submit"
                class="bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm">
            Enregistrer
        </button>
        @if(session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition
           x-init="setTimeout(() => show = false, 2500)"
           class="text-sm text-green-600 font-medium">✅ Profil mis à jour !</p>
        @endif
    </div>
</form>
