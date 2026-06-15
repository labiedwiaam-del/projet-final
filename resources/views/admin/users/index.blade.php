@extends('layouts.app')
@section('title', 'Gestion des Utilisateurs')
@section('header', 'Utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
               class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none w-64">
        <select name="role" class="border border-gray-200 rounded-xl text-sm px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Tous les rôles</option>
            <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient</option>
            <option value="medecin" {{ request('role') === 'medecin' ? 'selected' : '' }}>Médecin</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-xl hover:bg-gray-200 transition">Filtrer</button>
    </form>
    <a href="{{ route('admin.users.create') }}"
       class="bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-blue-800 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvel utilisateur
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Nom</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Email</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Téléphone</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Rôle</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Créé le</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->full_name }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $user->telephone ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : ($user->isDoctor() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                        {{ $user->isAdmin() ? 'Admin' : ($user->isDoctor() ? 'Médecin' : 'Patient') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline text-xs">Modifier</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Supprimer cet utilisateur ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Aucun utilisateur trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection
