{{-- Carte de statistique réutilisable --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
    <div class="w-12 h-12 rounded-xl {{ $iconBg ?? 'bg-blue-100' }} flex items-center justify-center flex-shrink-0">
        <svg class="w-6 h-6 {{ $iconColor ?? 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
    </div>
    <div>
        <p class="text-sm text-gray-500">{{ $label }}</p>
        <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
    </div>
</div>
