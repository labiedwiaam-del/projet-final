<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — MediBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-sky-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center justify-center">
            @include('partials.logo')
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 text-center mb-2">Mot de passe oublié ?</h1>
        <p class="text-sm text-gray-500 text-center mb-6">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        @if(session('status'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            ✅ {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none @error('email') border-red-400 @enderror"
                       placeholder="votre@email.com">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">← Retour à la connexion</a>
        </p>
    </div>
</div>

</body>
</html>
