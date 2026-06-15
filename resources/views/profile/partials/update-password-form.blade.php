<form method="POST" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe actuel</label>
        <input type="password" name="current_password" autocomplete="current-password"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('current_password', 'updatePassword') border-red-400 @enderror"
               placeholder="••••••••">
        @error('current_password', 'updatePassword')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nouveau mot de passe</label>
        <input type="password" name="password" autocomplete="new-password"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password', 'updatePassword') border-red-400 @enderror"
               placeholder="Minimum 8 caractères">
        @error('password', 'updatePassword')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le nouveau mot de passe</label>
        <input type="password" name="password_confirmation" autocomplete="new-password"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
               placeholder="Répétez le nouveau mot de passe">
    </div>

    <div class="flex items-center gap-4">
        <button type="submit"
                class="bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm">
            Changer le mot de passe
        </button>
        @if(session('status') === 'password-updated')
        <p x-data="{ show: true }" x-show="show" x-transition
           x-init="setTimeout(() => show = false, 2500)"
           class="text-sm text-green-600 font-medium">✅ Mot de passe mis à jour !</p>
        @endif
    </div>
</form>
