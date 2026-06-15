<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — MediBook</title>
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
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Nouveau mot de passe</h1>
        <p class="text-sm text-gray-500 mb-6">Choisissez un mot de passe sécurisé (minimum 8 caractères).</p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nouveau mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-400 @enderror"
                       placeholder="Minimum 8 caractères">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Répétez le mot de passe">
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>

</body>
</html>
