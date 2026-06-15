{{-- Affiche un badge coloré selon le statut du rendez-vous --}}
@php
    $colors = [
        'programme' => 'bg-yellow-100 text-yellow-800',
        'confirme'  => 'bg-green-100 text-green-800',
        'annule'    => 'bg-red-100 text-red-800',
        'termine'   => 'bg-blue-100 text-blue-800',
    ];
    $labels = [
        'programme' => 'Programmé',
        'confirme'  => 'Confirmé',
        'annule'    => 'Annulé',
        'termine'   => 'Terminé',
    ];
    $colorClass = $colors[$statut] ?? 'bg-gray-100 text-gray-800';
    $label      = $labels[$statut] ?? ucfirst($statut);
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
    {{ $label }}
</span>
