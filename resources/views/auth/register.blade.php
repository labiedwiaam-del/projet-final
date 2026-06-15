<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — MediBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-sky-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center justify-center">
            @include('partials.logo')
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer un compte</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('prenom') border-red-400 @enderror"
                           placeholder="Prénom">
                    @error('prenom')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('nom') border-red-400 @enderror"
                           placeholder="Nom">
                    @error('nom')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Adresse email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('email') border-red-400 @enderror"
                       placeholder="votre@email.com">
                <p class="text-xs text-gray-400 mt-1">Domaines acceptés : @gmail.com · @hotmail.fr · @yahoo.com</p>
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition"
                       placeholder="+212 6XX XXX XXX">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Mot de passe <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('password') border-red-400 @enderror"
                       placeholder="Minimum 8 caractères">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Confirmer le mot de passe <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition"
                       placeholder="Répétez le mot de passe">
            </div>

            <div class="bg-blue-50 rounded-xl p-3 text-xs text-blue-700">
                🔒 Votre compte sera créé avec le rôle <strong>Patient</strong>. Pour un compte médecin, contactez l'administrateur.
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition shadow-md shadow-blue-200">
                Créer mon compte
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Se connecter</a>
        </p>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        © {{ date('Y') }} MediBook — Système de Rendez-vous Médical
    </p>
</div>

</body>
</html>
