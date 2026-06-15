<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifiez votre email — MediBook</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-sky-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center justify-center">
            @include('partials.logo')
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
        {{-- Icon enveloppe --}}
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-3">Vérifiez votre email</h1>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            Un lien de vérification a été envoyé à l'adresse :
        </p>
        <p class="font-bold text-blue-700 mb-5">{{ auth()->user()->email }}</p>

        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
            Cliquez sur le lien dans l'email pour activer votre compte.
            Vérifiez aussi votre dossier <strong>spam</strong> si vous ne le trouvez pas.
        </p>

        {{-- Statut de renvoi --}}
        @if(session('status') === 'verification-link-sent')
        <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            ✅ Un nouvel email de vérification a été envoyé !
        </div>
        @endif

        {{-- Bouton renvoyer --}}
        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition">
                Renvoyer l'email de vérification
            </button>
        </form>

        {{-- Déconnexion --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 transition underline">
                Se déconnecter
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">
        Domaines autorisés : @gmail.com · @hotmail.fr · @yahoo.com
    </p>
</div>

</body>
</html>
