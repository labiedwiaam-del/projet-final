<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — MediBook</title>
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
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Connexion</h1>

        {{-- Session status --}}
        @if(session('status'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('email') border-red-400 @enderror"
                       placeholder="votre@email.com">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-sm font-medium text-gray-700">Mot de passe</label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline">
                        Mot de passe oublié ?
                    </a>
                    @endif
                </div>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition @error('password') border-red-400 @enderror"
                       placeholder="••••••••">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember"
                       class="w-4 h-4 text-blue-600 rounded border-gray-300">
                <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition shadow-md shadow-blue-200">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Créer un compte</a>
        </p>

        {{-- Comptes de démo --}}
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">Comptes de démonstration</p>
            <div class="space-y-1 text-xs text-gray-600">
                <p>🔑 <strong>Admin</strong> — admin@medical.com / password</p>
                <p>👨‍⚕️ <strong>Médecin</strong> — sarah@medical.com / password</p>
                <p>🧑 <strong>Patient</strong> — Inscrivez-vous via /register</p>
            </div>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        © {{ date('Y') }} MediBook — Système de Rendez-vous Médical
    </p>
</div>

</body>
</html>
