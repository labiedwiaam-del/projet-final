<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediBook') — Système de Rendez-vous Médical</title>

    {{-- Compiled assets — asset() works on any URL (localhost, 127.0.0.1, Laragon) --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-Dcs8qTKE.css') }}">
    <script src="{{ asset('build/assets/app-ajUnSpVR.js') }}" defer></script>

    {{-- Chart.js local via npm (already in node_modules via CDN fallback) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        :root { --sidebar-w: 256px; }

        /* ── Sidebar ── */
        aside.sidebar {
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
        }

        /* ── Active nav item ── */
        .nav-active {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-left: 3px solid #60a5fa;
        }
        .nav-inactive {
            color: #bfdbfe;
            border-left: 3px solid transparent;
        }
        .nav-inactive:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        /* ── Scrollbar sidebar ── */
        aside.sidebar::-webkit-scrollbar { width: 4px; }
        aside.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

{{-- ═══════════════════════════════
     TOP NAVBAR
═══════════════════════════════ --}}
<nav class="bg-white border-b border-gray-100 shadow-sm fixed w-full z-30 top-0 h-16 flex items-center px-4">
    <div class="flex items-center justify-between w-full">

        {{-- Logo — links directly to the correct dashboard for the user's role --}}
        @php
            $dashUrl = '/';
            if (auth()->check()) {
                $dashUrl = match(auth()->user()->role) {
                    'admin'   => route('admin.dashboard'),
                    'medecin' => route('doctor.dashboard'),
                    default   => route('patient.dashboard'),
                };
            }
        @endphp
        <a href="{{ $dashUrl }}" class="flex items-center gap-2.5" aria-label="MediBook — Accueil">
            @include('partials.logo')
        </a>

        {{-- Right side: user info + dropdown --}}
        @auth
        <div class="flex items-center gap-3">
            {{-- Role badge --}}
            <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                @if(auth()->user()->isAdmin()) bg-purple-100 text-purple-700
                @elseif(auth()->user()->isDoctor()) bg-blue-100 text-blue-700
                @else bg-green-100 text-green-700 @endif">
                @if(auth()->user()->isAdmin()) Administrateur
                @elseif(auth()->user()->isDoctor()) Médecin
                @else Patient @endif
            </span>

            {{-- User dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-lg text-sm transition-colors duration-150">
                    <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->prenom ?? 'U', 0, 1)) }}
                    </div>
                    <span class="hidden md:inline max-w-[120px] truncate">{{ auth()->user()->prenom }}</span>
                    <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-1">

                    <div class="px-4 py-2.5 border-b border-gray-50">
                        <p class="font-semibold text-sm text-gray-900 truncate">{{ auth()->user()->full_name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ $dashUrl }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Tableau de bord
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Mon profil
                    </a>

                    <div class="border-t border-gray-50 mt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </div>
</nav>

{{-- ═══════════════════════════════
     BODY LAYOUT
═══════════════════════════════ --}}
<div class="flex min-h-screen pt-16">

    {{-- ── SIDEBAR ── --}}
    @auth
    <aside class="sidebar w-64 fixed left-0 top-16 bottom-0 z-20 flex flex-col overflow-y-auto">

        {{-- Logo in sidebar header --}}
        <div class="px-5 py-4 border-b border-white/10">
            <a href="{{ $dashUrl }}" class="flex items-center gap-2.5 mb-4">
                @include('partials.logo', ['size' => 34, 'dark' => true])
            </a>
            {{-- User card --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->prenom ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-white text-sm truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-blue-300 text-xs">
                        @if(auth()->user()->isAdmin()) Administrateur
                        @elseif(auth()->user()->isDoctor()) Médecin
                        @else Patient @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Nav links --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            @include('partials.sidebar-nav')
        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm nav-inactive transition-all duration-150">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>
    @endauth

    {{-- ── MAIN CONTENT ── --}}
    <main class="flex-1 @auth ml-64 @endauth p-6 min-w-0">

        {{-- Page header --}}
        @hasSection('header')
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>
            @hasSection('subheader')
            <p class="text-gray-500 mt-1 text-sm">@yield('subheader')</p>
            @endif
        </div>
        @endif

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                <li class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                    {{ $error }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Page content --}}
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
