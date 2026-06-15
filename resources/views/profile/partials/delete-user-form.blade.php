<div x-data="{ open: false }">
    <p class="text-sm text-gray-600 mb-4">
        Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
        Cette action est <strong>irréversible</strong>.
    </p>

    <button @click="open = true"
            class="bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-red-700 transition text-sm">
        Supprimer mon compte
    </button>

    {{-- Modal de confirmation --}}
    <div x-show="open" x-transition
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full" @click.away="open = false">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Confirmer la suppression</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Entrez votre mot de passe pour confirmer la suppression définitive de votre compte.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none @error('password', 'userDeletion') border-red-400 @enderror">
                    @error('password', 'userDeletion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" @click="open = false"
                            class="flex-1 bg-gray-100 text-gray-700 font-semibold py-2.5 rounded-xl hover:bg-gray-200 transition text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-xl hover:bg-red-700 transition text-sm">
                        Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
