{{-- nav-item.blade.php — Élément de navigation latérale --}}
<a href="{{ $href }}"
   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ $active ? 'nav-active' : 'nav-inactive' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
    </svg>
    {{ $label }}
</a>
