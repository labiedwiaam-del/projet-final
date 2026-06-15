{{--
    Logo MediBook — main + heart in hand icon
    Usage: @include('partials.logo', ['size' => 38, 'dark' => false])
    dark=true  → white text (for dark sidebar)
    dark=false → colored text (for white navbar)
--}}
@php $size = $size ?? 38; $dark = $dark ?? false; @endphp
<div class="inline-flex items-center gap-2.5" style="display: inline-flex; align-items: center; gap: 0.625rem; vertical-align: middle;">
    {{-- Icon: hand holding heart --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        {{-- Outer heart (dark navy) --}}
        <path d="M50 62 C50 62 22 45 22 28 C22 19 29 13 38 16 C43 17.5 47 21 50 25 C53 21 57 17.5 62 16 C71 13 78 19 78 28 C78 45 50 62 50 62Z" fill="#0077B6"/>
        {{-- Inner heart (deeper navy, shadow effect) --}}
        <path d="M50 57 C50 57 27 43 27 29 C27 22 33 17 41 19.5 C45.5 21 49 24 50 27 C51 24 54.5 21 59 19.5 C67 17 73 22 73 29 C73 43 50 57 50 57Z" fill="#023E8A" opacity="0.8"/>
        {{-- Hand (cyan) --}}
        <path d="M16 66 C16 66 23 57 34 55 C39 54 44 55 50 55 C56 55 62 54 70 51 C76 49 81 51 83 55 C85 59 82 64 76 65 C68 68 54 71 50 73 C42 75 28 77 20 74 C15 72 13 68 16 66Z" fill="#00B4D8"/>
        {{-- Hand highlight line --}}
        <path d="M20 67 C27 62 38 60 48 60 C56 60 64 58 72 55" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.6"/>
    </svg>

    {{-- Text --}}
    <span style="font-family:'Figtree',sans-serif;font-weight:800;font-size:1.05rem;letter-spacing:-.01em;line-height:1;">
        @if($dark)
            <span style="color:#fff;">Medi</span><span style="color:#38BDF8;">Book</span>
        @else
            <span style="color:#0077B6;">Medi</span><span style="color:#00B4D8;">Book</span>
        @endif
    </span>
</div>
