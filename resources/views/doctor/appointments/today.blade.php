@extends('layouts.app')
@section('title', 'RDV Aujourd\'hui')
@section('header', 'Rendez-vous d\'aujourd\'hui')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Patient</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Heure</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Motif</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-500">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($appointments as $apt)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $apt->patient?->full_name }}</td>
                <td class="px-6 py-4 font-bold text-gray-800">{{ $apt->heure_rdv }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $apt->motif ?? '—' }}</td>
                <td class="px-6 py-4">@include('partials.status-badge', ['statut' => $apt->statut])</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Aucun rendez-vous aujourd'hui.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
