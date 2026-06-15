@extends('layouts.app')
@section('title', 'Statistiques')
@section('header', 'Statistiques')
@section('subheader', 'Analyse de l\'activité de la plateforme pour ' . now()->year)

@section('content')

<div class="grid lg:grid-cols-2 gap-6 mb-6">
    {{-- Graphique mensuel --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Rendez-vous par mois</h3>
        <canvas id="monthlyChart" height="140"></canvas>
    </div>

    {{-- Répartition par statut --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Répartition par statut</h3>
        <canvas id="statusChart" height="140"></canvas>
    </div>
</div>

{{-- Top médecins --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-bold text-gray-800 mb-4">Top médecins (par nombre de rendez-vous)</h3>
    <div class="space-y-3">
        @forelse($topDoctors as $i => $doc)
        <div class="flex items-center gap-4">
            <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                {{ $i + 1 }}
            </span>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold text-gray-800">Dr. {{ $doc->user->full_name }}</span>
                    <span class="text-sm font-bold text-blue-700">{{ $doc->appointments_count }} RDV</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-700 h-2 rounded-full" style="width: {{ $topDoctors->max('appointments_count') > 0 ? ($doc->appointments_count / $topDoctors->max('appointments_count')) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-0.5">{{ $doc->specialite }}</p>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-8">Aucune donnée disponible.</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
const monthNames = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];

// Graphique mensuel
const monthlyData = @json($monthly);
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: Object.keys(monthlyData).map(m => monthNames[parseInt(m) - 1]),
        datasets: [{
            label: 'Rendez-vous',
            data: Object.values(monthlyData),
            borderColor: '#1a56db',
            backgroundColor: 'rgba(26,86,219,0.08)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#1a56db',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
    }
});

// Graphique statuts
const statusLabels = { programme: 'Programmé', confirme: 'Confirmé', annule: 'Annulé', termine: 'Terminé' };
const statusColors = { programme: '#f59e0b', confirme: '#10b981', annule: '#ef4444', termine: '#3b82f6' };
const statusData = @json($byStatus);
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(s => statusLabels[s] || s),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: Object.keys(statusData).map(s => statusColors[s] || '#9ca3af'),
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } }
        },
        cutout: '65%',
    }
});
</script>
@endpush
@endsection
