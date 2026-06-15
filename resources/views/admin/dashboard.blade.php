@extends('layouts.app')

@section('title', 'Tableau de bord Admin')
@section('header', 'Tableau de bord')
@section('subheader', 'Vue d\'ensemble de la plateforme médicale')

@section('content')
{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @include('partials.stat-card', [
        'label'     => 'Total Patients',
        'value'     => $stats['totalPatients'],
        'icon'      => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        'iconBg'    => 'bg-blue-100',
        'iconColor' => 'text-blue-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'Médecins Actifs',
        'value'     => $stats['totalDoctors'],
        'icon'      => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'iconBg'    => 'bg-green-100',
        'iconColor' => 'text-green-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'RDV ce mois',
        'value'     => $stats['appointmentsMonth'],
        'icon'      => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'iconBg'    => 'bg-purple-100',
        'iconColor' => 'text-purple-600',
    ])
    @include('partials.stat-card', [
        'label'     => 'En attente',
        'value'     => $stats['pendingAppointments'],
        'icon'      => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'iconBg'    => 'bg-orange-100',
        'iconColor' => 'text-orange-600',
    ])
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Graphique mensuel --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Rendez-vous par mois ({{ now()->year }})</h3>
        <canvas id="monthlyChart" height="100"></canvas>
    </div>

    {{-- Actions rapides --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Actions rapides</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.doctors.create') }}"
               class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-sm font-medium text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un médecin
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition text-sm font-medium text-green-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Ajouter un utilisateur
            </a>
            <a href="{{ route('admin.appointments.index') }}"
               class="flex items-center gap-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition text-sm font-medium text-purple-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Voir tous les RDV
            </a>
            <a href="{{ route('admin.statistics') }}"
               class="flex items-center gap-3 p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition text-sm font-medium text-orange-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Statistiques détaillées
            </a>
        </div>
    </div>
</div>

{{-- Derniers rendez-vous --}}
<div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">Derniers rendez-vous</h3>
        <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 text-sm hover:underline">Voir tout →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="pb-3 text-left font-semibold text-gray-500">Patient</th>
                    <th class="pb-3 text-left font-semibold text-gray-500">Médecin</th>
                    <th class="pb-3 text-left font-semibold text-gray-500">Date</th>
                    <th class="pb-3 text-left font-semibold text-gray-500">Heure</th>
                    <th class="pb-3 text-left font-semibold text-gray-500">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentAppointments as $apt)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 font-medium text-gray-900">{{ $apt->patient?->full_name ?? '—' }}</td>
                    <td class="py-3 text-gray-600">Dr. {{ $apt->doctor?->user?->full_name ?? '—' }}</td>
                    <td class="py-3 text-gray-600">{{ $apt->date_rdv?->format('d/m/Y') }}</td>
                    <td class="py-3 text-gray-600">{{ $apt->heure_rdv }}</td>
                    <td class="py-3">@include('partials.status-badge', ['statut' => $apt->statut])</td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">Aucun rendez-vous enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const monthNames = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
const monthlyData = @json($monthly);
const labels = Object.keys(monthlyData).map(m => monthNames[parseInt(m) - 1]);
const values = Object.values(monthlyData);

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Rendez-vous',
            data: values,
            backgroundColor: '#1a56db',
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
    }
});
</script>
@endpush
