<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediBookAI — Planification Médicale Intelligente</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

<!-- Tailwind CSS via Vite -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
/* ═══ Font Definitions ═══ */
:root {
  --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
  --font-display: 'Plus Jakarta Sans', system-ui, sans-serif;
}

body {
  font-family: var(--font-sans);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

h1, h2, h3, h4, h5, h6, .heading {
  font-family: var(--font-display);
  font-weight: 700;
}

.font-display {
  font-family: var(--font-display);
}

.font-display-sm {
  font-family: var(--font-display);
  font-weight: 600;
}

.font-display-md {
  font-family: var(--font-display);
  font-weight: 700;
}

.font-display-lg {
  font-family: var(--font-display);
  font-weight: 800;
}

.font-display-xl {
  font-family: var(--font-display);
  font-weight: 900;
}

/* Custom animations & scroll reveals that aren't natively in Tailwind CSS utilities */
.reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity .7s cubic-bezier(.16, 1, 0.3, 1), transform .7s cubic-bezier(.16, 1, 0.3, 1);
}
.reveal.reveal-left { transform: translateX(-40px) translateY(0); }
.reveal.reveal-right { transform: translateX(40px) translateY(0); }
.reveal.reveal-scale { transform: scale(.9) translateY(0); }
.reveal.visible { opacity: 1; transform: translateY(0) translateX(0) scale(1); }

.delay-1 { transition-delay: .1s; }
.delay-2 { transition-delay: .2s; }
.delay-3 { transition-delay: .3s; }
.delay-4 { transition-delay: .4s; }
.delay-5 { transition-delay: .5s; }
.delay-6 { transition-delay: .6s; }

/* Floating keyframes for mockup badges */
@keyframes float-1 { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
@keyframes float-2 { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(8px); } }
@keyframes float-3 { 0%, 100% { transform: translateY(0) translateX(0); } 50% { transform: translateY(-6px) translateX(4px); } }
.float-badge-1 { animation: float-1 4s ease-in-out infinite; }
.float-badge-2 { animation: float-2 5s ease-in-out infinite; }

/* Glowing background blob animations */
@keyframes blob-pulse { 0%, 100% { transform: scale(1); opacity: .4; } 50% { transform: scale(1.1); opacity: .2; } }
.blob-pulse-1 { animation: blob-pulse 8s ease-in-out infinite; }
.blob-pulse-2 { animation: blob-pulse 10s ease-in-out infinite 2s; }
.blob-pulse-3 { animation: blob-pulse 7s ease-in-out infinite 4s; }

/* Button shimmers & hover offsets */
.btn-hover-effect {
  position: relative;
  overflow: hidden;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.btn-hover-effect::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 50%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
  transition: left .5s ease;
}
.btn-hover-effect:hover::after { left: 150%; }

@keyframes ripple-anim { to { transform: scale(4); opacity: 0; } }
.ripple-span {
  position: absolute;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.35);
  transform: scale(0);
  animation: ripple-anim .5s linear;
  pointer-events: none;
}

/* ═══ ACTIVE BOOKING WIZARD TRANSITIONS ═══ */
.ps {
  transition: opacity 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease !important;
  opacity: 0.45;
}
.ps.active {
  opacity: 1 !important;
  border-color: #4F7BFF !important;
  box-shadow: 0 8px 24px rgba(79, 123, 255, 0.14) !important;
}
.ps.active .psn {
  background: #4F7BFF !important;
  color: #fff !important;
}
.ps.active .pst {
  color: #4F7BFF !important;
}

.phone-mockup-body {
  position: relative;
  overflow: hidden;
  min-height: 460px;
}
.wizard-screen {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  visibility: hidden;
  transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease, visibility 0.6s ease;
}

/* Slide Forward (Right to Left) */
.wizard-screen.slide-left-out {
  transform: translateX(-100%);
  opacity: 0;
  visibility: hidden;
}
.wizard-screen.slide-left-in {
  transform: translateX(100%);
  opacity: 0;
  visibility: hidden;
}

/* Slide Backward (Left to Right) */
.wizard-screen.slide-right-out {
  transform: translateX(100%);
  opacity: 0;
  visibility: hidden;
}
.wizard-screen.slide-right-in {
  transform: translateX(-100%);
  opacity: 0;
  visibility: hidden;
}

.wizard-screen.active {
  transform: translateX(0) !important;
  opacity: 1 !important;
  visibility: visible !important;
  position: relative;
}

/* Floating custom cursor glow shape */
.glow-cursor-shape {
  pointer-events: none;
  position: fixed;
  z-index: 9999;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(0, 180, 216, 0.06) 0%, transparent 70%);
  transform: translate(-50%, -50%);
  transition: left .1s ease, top .1s ease;
  left: -999px;
  top: -999px;
}
</style>
</head>
<body class="bg-[#EBF6FB] text-sky-950 font-inter antialiased selection:bg-cyan-500 selection:text-white overflow-x-hidden" style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">

<a href="#main" class="absolute -top-40 left-4 bg-cyan-500 text-white px-4 py-2 rounded-lg font-bold z-[9999] transition-all focus:top-4 focus:outline-3 focus:outline-cyan-500 focus:outline-offset-3">
  Aller au contenu principal
</a>

<!-- ══════════════════════════════════════════════════════════════════
     NAVBAR
     ══════════════════════════════════════════════════════════════════ -->
<nav id="nav" class="fixed top-0 left-0 right-0 z-50 h-[76px] flex items-center bg-[#EBF6FB]/85 backdrop-blur-md border-b border-cyan-100/40 transition-all duration-300" role="navigation" aria-label="Navigation principale">
  <div class="w-full max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between">

      <!-- Logo always Left -->
      <a href="/" class="flex items-center gap-3 shrink-0 min-w-[200px]" aria-label="MediBook — Accueil">
        @include('partials.logo')
      </a>

      <!-- Menu links Center -->
      <div class="hidden md:flex items-center gap-10 lg:gap-14 font-display-md" role="list">
        <a href="#accueil" class="text-sm font-semibold text-sky-900/80 hover:text-cyan-500 transition-colors duration-200" role="listitem">Accueil</a>
        <a href="#services" class="text-sm font-semibold text-sky-900/80 hover:text-cyan-500 transition-colors duration-200" role="listitem">Services</a>
        <a href="#specialites" class="text-sm font-semibold text-sky-900/80 hover:text-cyan-500 transition-colors duration-200" role="listitem">Spécialités</a>
        <a href="#medecins" class="text-sm font-semibold text-sky-900/80 hover:text-cyan-500 transition-colors duration-200" role="listitem">Médecins</a>
        <a href="#contact" class="text-sm font-semibold text-sky-900/80 hover:text-cyan-500 transition-colors duration-200" role="listitem">Contact</a>
      </div>

      <!-- Actions Right -->
      <div class="flex items-center gap-4 shrink-0 min-w-[200px] justify-end">
        <a href="{{ route('login') }}" class="text-sm font-bold text-sky-900/80 hover:text-cyan-500 hover:bg-cyan-500/8 px-4 py-2 rounded-full transition-all duration-200">Connexion</a>
        <a href="{{ route('register') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-bold py-2.5 px-6 rounded-full shadow-lg shadow-cyan-500/20 flex items-center gap-1.5 transition-all">
          S'inscrire
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
      </div>

    </div>
  </div>
</nav>

<main id="main">

  <!-- ══════════════════════════════════════════════════════════════════
       HERO SECTION
       ══════════════════════════════════════════════════════════════════ -->
  <section class="relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden" id="accueil">

    <!-- Soft pulsing blobs behind content -->
    <div class="blob-pulse-1 absolute rounded-full pointer-events-none w-[520px] h-[520px] bg-radial-gradient -top-[120px] -right-[100px] bg-gradient-to-br from-cyan-400/10 to-transparent blur-3xl"></div>
    <div class="blob-pulse-2 absolute rounded-full pointer-events-none w-[380px] h-[380px] bg-radial-gradient -bottom-[80px] -left-[100px] bg-gradient-to-br from-sky-400/8 to-transparent blur-2xl"></div>
    <div class="blob-pulse-3 absolute rounded-full pointer-events-none w-[280px] h-[280px] bg-radial-gradient top-[40%] -right-[60px] bg-gradient-to-br from-cyan-300/8 to-transparent blur-2xl"></div>

    <div class="w-full max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

        <!-- Left Text Column -->
        <div class="lg:col-span-7 flex flex-col items-start reveal">

          <div class="inline-flex items-center gap-2 bg-cyan-500/10 border border-cyan-500/20 text-cyan-600 text-xs font-extrabold tracking-wide px-4 py-1.5 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
            Plateforme Médicale Certifiée
          </div>

          <h1 class="font-display-xl text-4xl sm:text-5xl lg:text-[54px] font-black text-sky-950 leading-[1.08] mb-6 tracking-tight">
            Planification<br>
            <span class="text-cyan-500">Intelligente</span>,<br>
            <span class="text-sky-700" id="tw-text">Zéro Absences</span>
          </h1>

          <p class="text-base sm:text-lg text-sky-900/70 leading-relaxed mb-8 max-w-xl">
            MediBookAI réunit patients, médecins et intelligence artificielle pour transformer la gestion des rendez-vous médicaux — rapide, fiable, automatisée.
          </p>

          <div class="flex flex-wrap gap-4 mb-12">
            <a href="{{ route('register') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-cyan-500/20 flex items-center gap-2 transition-all">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 010 1.972l-11.54 6.347a1.125 1.125 0 01-1.667-.986V5.653z"/></svg>
              S'inscrire gratuitement
            </a>
            <a href="{{ route('login') }}" class="btn-hover-effect border-2 border-cyan-500/80 text-cyan-600 hover:bg-cyan-500/5 font-bold py-3 px-8 rounded-full transition-all">
              Connexion
            </a>
          </div>

          <!-- Hero stats bar inside left column -->
          <div class="border-t border-cyan-100/80 w-full pt-8 grid grid-cols-2 sm:grid-cols-4 gap-6" role="list">
            @foreach([['150','+ Patients actifs','150','+'],['98','% RDV honorés','98','%'],['24','/ 7 Disponible','24','/7'],['3','min Inscription','3',' min']] as [$v,$l,$count,$suf])
            <div role="listitem" class="flex flex-col">
              <div class="font-display-xl text-[28px] font-black text-cyan-500 leading-none mb-1">
                <span class="inline-block" data-count="{{ $count }}" data-suffix="{{ $suf }}">{{ $v }}{{ $suf }}</span>
              </div>
              <div class="text-xs font-bold text-sky-900/50 uppercase tracking-wider">{{ $l }}</div>
            </div>
            @endforeach
          </div>

        </div>

        <!-- Right Visual Column with Doctor Photo and Badges -->
        <div class="lg:col-span-5 flex justify-center relative reveal delay-2">

          <!-- Mockup background card with premium gradient -->
          <div class="relative w-full max-w-[380px] rounded-[32px] overflow-hidden shadow-2xl shadow-sky-950/10 border border-cyan-100/50 bg-gradient-to-br from-sky-100 to-sky-200 aspect-[4/4.6] relative z-10 transition-all duration-300 hover:shadow-sky-950/20">

            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/90 via-sky-200/80 to-sky-300/60"></div>

            <!-- SVG Illustration of Doctor -->
            <div class="absolute bottom-0 left-50% translate-x-[-1%] w-[85%] h-[90%] flex items-end justify-center mx-auto left-0 right-0">
              <svg viewBox="0 0 200 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <rect x="50" y="140" width="100" height="140" rx="8" fill="white" fill-opacity="0.95"/>
                <path d="M80 140 L100 165 L120 140" stroke="#CBD5E1" stroke-width="2" fill="none"/>
                <path d="M75 150 Q60 170 65 195 Q70 215 90 210" stroke="#94A3B8" stroke-width="3" fill="none" stroke-linecap="round"/>
                <circle cx="90" cy="213" r="7" fill="#64748B"/>
                <circle cx="100" cy="108" r="32" fill="#FBBF8A"/>
                <path d="M68 100 Q70 72 100 70 Q130 72 132 100 Q128 80 100 78 Q72 80 68 100Z" fill="#4A3728"/>
                <path d="M82 128 Q100 138 118 128" stroke="#C8966A" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                <ellipse cx="89" cy="108" rx="4" ry="4.5" fill="#2D1B0E"/>
                <ellipse cx="111" cy="108" rx="4" ry="4.5" fill="#2D1B0E"/>
                <rect x="82" y="103" width="16" height="11" rx="5" stroke="#334155" stroke-width="2" fill="none"/>
                <rect x="102" y="103" width="16" height="11" rx="5" stroke="#334155" stroke-width="2" fill="none"/>
                <line x1="98" y1="108" x2="102" y2="108" stroke="#334155" stroke-width="2"/>
                <path d="M50 185 Q75 175 100 180 Q125 175 150 185 Q145 205 100 200 Q55 205 50 185Z" fill="#E2E8F0"/>
                <rect x="107" y="155" width="14" height="6" rx="3" fill="#3B82F6" fill-opacity="0.8"/>
              </svg>
            </div>

            <!-- Gradient overlay at the bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-[35%] bg-gradient-to-t from-sky-950/20 to-transparent rounded-b-[32px]"></div>

            <!-- Bottom Left Badge: Rating -->
            <div class="absolute bottom-5 left-5 bg-white/95 rounded-2xl p-3 flex items-center gap-2.5 shadow-xl border border-sky-100 z-20">
              <div class="w-9 h-9 rounded-full bg-cyan-100/60 flex items-center justify-center shrink-0">
                <svg class="w-[18px] h-[18px] text-cyan-500 fill-cyan-500" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
              </div>
              <div>
                <div class="font-display-lg text-[13px] text-sky-950 leading-tight">4.9 / 5 Rating</div>
                <div class="text-[10px] font-bold text-sky-900/40">2 400+ avis patients</div>
              </div>
            </div>

            <!-- Bottom Right Badge: IA Active -->
            <div class="absolute bottom-5 right-5 bg-white/95 rounded-full py-1.5 px-4 flex items-center gap-2 shadow-xl border border-sky-100 z-20">
              <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 animate-ping shrink-0"></span>
              <span class="font-display-md text-[11px] text-cyan-600 uppercase tracking-wide">IA Active</span>
            </div>

          </div>

          <!-- Floating Badge Top Right: Prochain RDV -->
          <div class="float-badge-1 absolute -top-4 -right-4 bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-sky-100 flex items-center gap-3.5 z-30 transition-all">
            <div class="w-[34px] h-[34px] rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-500 shrink-0">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5"/>
              </svg>
            </div>
            <div>
              <div class="font-display-lg text-[13px] text-sky-950 leading-tight">Prochain RDV</div>
              <div class="text-[11px] font-bold text-sky-900/40">Aujourd'hui, 14:30</div>
            </div>
          </div>

          <!-- Floating Badge Left Side: RDV Confirmé -->
          <div class="float-badge-2 absolute bottom-24 -left-6 bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-emerald-100/80 flex items-center gap-3.5 z-30 transition-all">
            <div class="w-[34px] h-[34px] rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
              <div class="font-display-lg text-[13px] text-sky-950 leading-tight">RDV confirmé</div>
              <div class="text-[11px] font-bold text-sky-900/40">À l'instant</div>
            </div>
          </div>

          <!-- Floating Badge Bottom: Rappel Envoyé -->
          <div class="float-badge-1 absolute -bottom-4 -right-4 bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-amber-100/80 flex items-center gap-3.5 z-30 transition-all">
            <div class="w-[34px] h-[34px] rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            </div>
            <div>
              <div class="font-display-lg text-[13px] text-sky-950 leading-tight">Rappel envoyé</div>
              <div class="text-[11px] font-bold text-sky-900/40">24h avant</div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       QUICK INFO BAR (Stats Bar)
       ══════════════════════════════════════════════════════════════════ -->
  <div class="bg-white border-y border-cyan-100/40 py-8 relative z-20 shadow-sm" role="region" aria-label="Informations rapides">
    <div class="w-full max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
          ['Horaires d'ouverture','Lun–Sam, 08:00–20:00','M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
          ['Réservation en ligne','24h/24, 7j/7','M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['Rappels automatiques','Email 24h avant le RDV','M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],
          ['3 Médecins qualifiés','Cardio, Généraliste, Pédiatrie','M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z'],
        ] as [$lbl,$val,$path])
        <div class="flex items-center gap-4 p-5 bg-[#EBF6FB]/40 hover:bg-[#EBF6FB]/80 border border-cyan-100/50 hover:border-cyan-200 rounded-2xl transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 reveal delay-{{ $loop->index + 1 }}">
          <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center shrink-0 text-cyan-600">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
          </div>
          <div>
            <div class="text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 mb-0.5">{{ $lbl }}</div>
            <div class="font-display-md text-[14px] text-sky-950">{{ $val }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════════════
       SERVICES SECTION
       ══════════════════════════════════════════════════════════════════ -->
  <section class="py-24 bg-[#EBF6FB]" id="services" aria-label="Services">
    <div class="w-full max-w-7xl mx-auto px-6">

      <!-- Service 1: text left / visual right -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-28">
        <div class="reveal reveal-left">
          <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 bg-cyan-500/10 py-1 px-3 rounded-full mb-4">Pour les médecins</div>
          <h2 class="font-display-lg text-3xl sm:text-4xl text-sky-950 mb-6 leading-tight">Automatisez Votre Planning de Consultations</h2>
          <p class="text-[15px] text-sky-900/70 leading-relaxed mb-8">
            Définissez vos disponibilités une seule fois. Les patients réservent directement en ligne — vous recevez une notification instantanée, sans aucun appel téléphonique.
          </p>
          <ul class="flex flex-col gap-4 mb-8" role="list">
            @foreach(['Zéro rendez-vous manqués','Confirmations par email automatiques','Gestion multi-créneaux quotidienne'] as $item)
            <li class="flex items-center gap-3 text-sm font-semibold text-sky-900/70" role="listitem">
              <div class="w-5 h-5 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0 text-cyan-600">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
              </div>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('login') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-cyan-500/20 inline-flex items-center gap-2 transition-all">
            Accès médecin
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </a>
        </div>

        <div class="bg-white rounded-[32px] shadow-xl shadow-sky-900/5 border border-cyan-100/50 p-8 relative overflow-hidden reveal reveal-right">
          <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-radial-gradient bg-gradient-to-br from-cyan-400/10 to-transparent pointer-events-none"></div>

          <div class="flex items-center gap-3.5 pb-5 border-b border-cyan-50/80 mb-6">
            <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center font-bold text-sm text-white shrink-0">A</div>
            <div>
              <div class="font-display-md text-sm text-sky-950">Dr. Ahmed Alaoui</div>
              <div class="text-[11px] font-bold text-sky-900/40">Médecine Générale</div>
            </div>
            <div class="ml-auto">
              <span class="bg-emerald-50 text-emerald-600 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">Actif</span>
            </div>
          </div>

          <div class="flex flex-col gap-3">
            @foreach([['10:00','Karim Mansouri','ok','Confirmé'],['11:30','Leila Idrissi','ok','Confirmé'],['14:00','Youssef Tazi','pend','En attente'],['15:30','Amina Rachidi','ok','Confirmé']] as [$t,$n,$s,$badge])
            <div class="flex items-center justify-between bg-sky-50/40 hover:bg-sky-50 border border-cyan-100/30 hover:border-cyan-200/60 p-4 rounded-2xl transition-all">
              <span class="font-display-md text-xs text-cyan-600 shrink-0">{{ $t }}</span>
              <span class="text-xs font-semibold text-sky-950/80">{{ $n }}</span>
              <span class="text-[10px] font-extrabold uppercase tracking-wide px-2.5 py-0.5 rounded-full {{ $s==='ok' ? 'bg-emerald-50 text-emerald-600' : 'bg-cyan-500/10 text-cyan-600' }}">{{ $badge }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Service 2: visual left / text right -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <div class="bg-white rounded-[32px] shadow-xl shadow-sky-900/5 border border-cyan-100/50 p-10 relative overflow-hidden reveal reveal-left lg:order-first order-last">
          <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-radial-gradient bg-gradient-to-br from-cyan-400/10 to-transparent pointer-events-none"></div>
          <div class="text-center py-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center mx-auto mb-6 shadow-xl shadow-cyan-500/20 text-white">
              <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3h3m-3 3h3"/></svg>
            </div>
            <div class="font-display-lg text-base text-sky-950 mb-1">Application Flutter</div>
            <div class="text-xs font-bold text-sky-900/40 mb-6">iOS & Android</div>
            <div class="flex flex-col gap-2.5 items-center">
              @foreach([['ok','API REST complète ✓'],['blue','Auth Sanctum ✓'],['purple','Voice IA ElevenLabs ✓']] as [$c,$t])
              <div class="text-xs font-bold py-1.5 px-5 rounded-full {{ $c==='ok' ? 'bg-emerald-50 text-emerald-600' : ($c==='blue' ? 'bg-cyan-500/10 text-cyan-600' : 'bg-purple-50 text-purple-600') }}">
                {{ $t }}
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="reveal reveal-right">
          <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 bg-cyan-500/10 py-1 px-3 rounded-full mb-4">Intégrations</div>
          <h2 class="font-display-lg text-3xl sm:text-4xl text-sky-950 mb-6 leading-tight">Connectez les Outils que Vous Utilisez Déjà</h2>
          <p class="text-[15px] text-sky-900/70 leading-relaxed mb-8">
            MediBookAI s'intègre avec votre infrastructure existante via une API REST complète. Application Flutter, ElevenLabs Voice AI, DPI — tout est connecté.
          </p>
          <ul class="flex flex-col gap-4 mb-8" role="list">
            @foreach(['API REST documentée (Sanctum)','Application mobile Flutter','Assistant vocal IA ElevenLabs','Intégration DPI médicaux'] as $item)
            <li class="flex items-center gap-3 text-sm font-semibold text-sky-900/70" role="listitem">
              <div class="w-5 h-5 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0 text-cyan-600">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
              </div>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('register') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-cyan-500/20 inline-flex items-center gap-2 transition-all">
            Voir les intégrations
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </a>
        </div>

      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       AGENDA INTELLIGENT SECTION
       ══════════════════════════════════════════════════════════════════ -->
  <section class="py-24 bg-gradient-to-br from-sky-950 via-sky-900 to-cyan-900 text-white relative overflow-hidden" aria-label="Agenda médical intelligent">

    <!-- Decorative background vector grids -->
    <div class="absolute rounded-full pointer-events-none bg-white/5 w-[400px] h-[400px] -top-[150px] -right-[100px] blur-2xl"></div>
    <div class="absolute rounded-full pointer-events-none bg-white/5 w-[280px] h-[280px] -bottom-[100px] -left-[80px] blur-xl"></div>

    <div class="w-full max-w-7xl mx-auto px-6 relative z-10">

      <div class="text-center mb-16 reveal">
        <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-white bg-white/10 border border-white/10 py-1.5 px-4 rounded-full mb-4">
          Gestion de cabinet médical
        </div>
        <h2 class="font-display-lg text-3xl sm:text-4xl lg:text-[42px] mb-5 leading-tight">
          Agenda médical intelligent<br>
          <span class="text-cyan-400">pour médecins</span>
        </h2>
        <p class="text-sky-200/80 text-[15px] max-w-lg mx-auto leading-relaxed">
          Plateforme complète avec prise de rendez-vous ultra-rapide et rappels automatiques. <strong>Optimisé pour tous les cabinets médicaux.</strong>
        </p>
      </div>

      <!-- Features Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card 1: Agenda -->
        <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-cyan-500/30 rounded-3xl p-8 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1.5 flex flex-col reveal delay-1">
          <div class="flex items-start justify-between mb-6">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-cyan-400 shrink-0">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            </div>
            <span class="font-display-xl text-2xl text-cyan-400">95%</span>
          </div>
          <div class="text-[10px] font-bold tracking-wider uppercase text-sky-200/60 mb-2">taux de remplissage</div>
          <h3 class="font-display-md text-lg text-white mb-1">Agenda Intelligent</h3>
          <div class="text-xs font-semibold text-cyan-400 mb-4">Rendez-vous en 40 secondes</div>
          <p class="text-sm text-sky-200/70 leading-relaxed mb-6">Optimisation automatique avec rappels email et gestion des créneaux libres.</p>
          <div class="flex flex-col gap-2.5 mt-auto">
            @foreach(['Réduction no-shows 90%','Rappels automatiques','Sync calendrier'] as $f)
            <div class="flex items-center gap-2.5 text-xs font-semibold text-sky-200/80">
              <svg class="w-4.5 h-4.5 text-cyan-400 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              {{ $f }}
            </div>
            @endforeach
          </div>
        </div>

        <!-- Card 2: Dossiers Sécurisés -->
        <div class="bg-gradient-to-br from-white/10 to-cyan-500/5 border-2 border-cyan-400/80 rounded-3xl p-8 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1.5 flex flex-col relative reveal delay-2 shadow-2xl shadow-cyan-950/40">
          <div class="flex items-start justify-between mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-cyan-500/20">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <span class="font-display-xl text-2xl text-cyan-400">0.3s</span>
          </div>
          <div class="text-[10px] font-bold tracking-wider uppercase text-sky-200/60 mb-2">temps d'accès</div>
          <h3 class="font-display-md text-lg text-white mb-1">Dossiers Sécurisés</h3>
          <div class="text-xs font-semibold text-cyan-400 mb-4">Accès instantané</div>
          <p class="text-sm text-sky-200/70 leading-relaxed mb-6">Stockage sécurisé avec recherche ultra-rapide et historique médical complet.</p>
          <div class="flex flex-col gap-2.5 mt-auto">
            @foreach(['Recherche instantanée','Sécurité maximale','Backup automatique'] as $f)
            <div class="flex items-center gap-2.5 text-xs font-semibold text-sky-200/80">
              <svg class="w-4.5 h-4.5 text-cyan-400 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              {{ $f }}
            </div>
            @endforeach
          </div>
          <!-- Arrow Indicator -->
          <div class="absolute bottom-6 right-6 w-9 h-9 rounded-full bg-cyan-500 flex items-center justify-center text-white shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </div>
        </div>

        <!-- Card 3: Analytics -->
        <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-cyan-500/30 rounded-3xl p-8 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1.5 flex flex-col reveal delay-3">
          <div class="flex items-start justify-between mb-6">
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-purple-400 shrink-0">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <span class="font-display-xl text-2xl text-purple-400">40+</span>
          </div>
          <div class="text-[10px] font-bold tracking-wider uppercase text-sky-200/60 mb-2">métriques détaillées</div>
          <h3 class="font-display-md text-lg text-white mb-1">Analytics Avancés</h3>
          <div class="text-xs font-semibold text-purple-400 mb-4">Insights temps réel</div>
          <p class="text-sm text-sky-200/70 leading-relaxed mb-6">Tableaux de bord intelligents pour optimiser la rentabilité de votre cabinet.</p>
          <div class="flex flex-col gap-2.5 mt-auto">
            @foreach(['ROI en temps réel','Prédictions IA','Rapports auto'] as $f)
            <div class="flex items-center gap-2.5 text-xs font-semibold text-sky-200/80">
              <svg class="w-4.5 h-4.5 text-purple-400 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              {{ $f }}
            </div>
            @endforeach
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       SECTION PROCESSUS PATIENT (Interactive Booking Wizard)
       ══════════════════════════════════════════════════════════════════ -->
  <section id="proc" class="py-24 bg-[#EBF6FB]">
    <div class="w-full max-w-7xl mx-auto px-6">

      <!-- Header -->
      <div class="text-center mb-16 reveal">
        <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 bg-cyan-500/10 py-1.5 px-4 rounded-full mb-4">
          Démo interactive
        </div>
        <h2 class="font-display-lg text-3xl sm:text-4xl lg:text-[40px] text-sky-950 leading-tight mb-5">
          Voyez comme c'est simple<br>pour <span class="text-cyan-500">vos patients</span>
        </h2>
        <p class="text-sky-900/70 text-[15px] max-w-lg mx-auto leading-relaxed">
          En 3 clics, vos patients prennent rendez-vous. Interface intuitive, rappels automatiques, zéro friction.
        </p>
      </div>

      <!-- Wizard Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16 items-start max-w-4xl mx-auto">

        <!-- Left Column: Steps -->
        <div class="flex flex-col gap-4 py-2">

          <!-- Step 1 Card -->
          <div class="ps flex items-start gap-4 bg-white border border-cyan-100/50 rounded-2xl p-5 cursor-pointer" data-s="1" onclick="goStep(1)">
            <div class="psn w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center font-display-lg text-sm text-cyan-500 shrink-0 transition-all">1</div>
            <div>
              <div class="pst font-display-md text-[15px] text-sky-950 mb-1 transition-all">Choix du médecin</div>
              <div class="text-xs text-sky-900/60 leading-relaxed">Le patient sélectionne le médecin et la spécialité</div>
            </div>
          </div>

          <!-- Step 2 Card -->
          <div class="ps flex items-start gap-4 bg-white border border-cyan-100/50 rounded-2xl p-5 cursor-pointer relative" data-s="2" onclick="goStep(2)">
            <div class="psn w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center font-display-lg text-sm text-cyan-500 shrink-0 transition-all">2</div>
            <div>
              <div class="pst font-display-md text-[15px] text-sky-950 mb-1 transition-all">Date et créneau</div>
              <div class="text-xs text-sky-900/60 leading-relaxed">Planning en temps réel avec disponibilités — pas de double réservation possible.</div>
            </div>
            <span class="psdot absolute top-5 right-5 w-2.5 h-2.5 rounded-full bg-cyan-500 hidden" style="animation: pdot 1.5s ease-in-out infinite;"></span>
          </div>

          <!-- Step 3 Card -->
          <div class="ps flex items-start gap-4 bg-white border border-cyan-100/50 rounded-2xl p-5 cursor-pointer" data-s="3" onclick="goStep(3)">
            <div class="psn w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center font-display-lg text-sm text-cyan-500 shrink-0 transition-all">3</div>
            <div>
              <div class="pst font-display-md text-[15px] text-sky-950 mb-1 transition-all">Confirmation</div>
              <div class="text-xs text-sky-900/60 leading-relaxed">Email instantané + rappel automatique 24h avant</div>
            </div>
          </div>

          <!-- Action buttons underneath steps -->
          <div class="flex gap-4 mt-4">
            <a href="{{ route('register') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2.5 px-6 rounded-full shadow-lg shadow-cyan-500/20 text-sm flex items-center gap-2 transition-all">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 010 1.972l-11.54 6.347a1.125 1.125 0 01-1.667-.986V5.653z"/></svg>
              Essayer maintenant
            </a>
            <a href="{{ route('login') }}" class="btn-hover-effect border-2 border-cyan-500/30 text-cyan-600 hover:bg-cyan-500/5 font-bold py-2.5 px-6 rounded-full text-sm transition-all">
              Se connecter
            </a>
          </div>

        </div>

        <!-- Right Column: Interactive Phone Screen Mockup -->
        <div class="flex justify-center relative">
          <div class="phone-mockup-body w-[280px] bg-white rounded-[28px] shadow-2xl shadow-sky-950/10 border border-cyan-100 overflow-hidden min-h-[460px]">

            <!-- Top mockup gradient bar -->
            <div class="h-1 bg-gradient-to-r from-cyan-500 to-sky-500 w-full"></div>

            <!-- 📱 SCREEN 1: Doctor Choice -->
            <div id="ps1" class="wizard-screen" style="padding: 1.5rem;">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-500 to-sky-500 flex items-center justify-center shrink-0">
                  <svg class="w-[18px] h-[18px] text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0"/></svg>
                </div>
                <div>
                  <div class="font-display-md text-xs text-sky-950">Choisir un médecin</div>
                  <div class="text-[9px] font-bold text-sky-900/40">3 disponibles</div>
                </div>
              </div>

              <!-- Progress Indicator -->
              <div class="flex justify-between mb-1">
                <span class="text-[9px] font-bold text-sky-900/40">Étape 1 sur 3</span>
                <span class="text-[9px] font-extrabold text-cyan-500">33%</span>
              </div>
              <div class="h-1 bg-sky-50 rounded-full mb-5">
                <div class="w-1/3 h-full bg-gradient-to-r from-cyan-500 to-sky-500 rounded-full"></div>
              </div>

              <!-- Doctor cards list -->
              @foreach([['A','Dr. Ahmed Alaoui','Médecine Générale','#4F7BFF',true],['S','Dr. Sarah Bennani','Cardiologie','#7B61FF',false],['M','Dr. Maria Lopez','Pédiatrie','#059669',false]] as [$i,$n,$s,$c,$sel])
              <div class="flex items-center gap-2.5 p-2.5 rounded-xl border {{ $sel ? 'border-cyan-500 bg-cyan-500/5' : 'border-sky-50 bg-sky-50/20' }} mb-2 cursor-pointer transition-all">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-display-lg text-xs text-white shrink-0" style="background: {{ $c }};">{{ $i }}</div>
                <div class="flex-1">
                  <div class="font-display-md text-[11px] text-sky-950 leading-tight">{{ $n }}</div>
                  <div class="text-[9px] font-bold text-sky-900/40 mt-0.5">{{ $s }}</div>
                </div>
                @if($sel)
                <div class="w-[18px] h-[18px] rounded-full bg-cyan-500 flex items-center justify-center shrink-0">
                  <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                </div>
                @endif
              </div>
              @endforeach
            </div>

            <!-- 📱 SCREEN 2: Date & Slots -->
            <div id="ps2" class="wizard-screen" style="padding: 1.5rem;">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-cyan-500 to-sky-500 flex items-center justify-center shrink-0">
                  <svg class="w-[18px] h-[18px] text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5"/></svg>
                </div>
                <div>
                  <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-xs text-sky-950">Dr. Ahmed Alaoui</div>
                  <div class="text-[9px] font-bold text-sky-900/40">Médecine Générale</div>
                </div>
              </div>

              <!-- Progress Indicator -->
              <div class="flex justify-between mb-1">
                <span class="text-[9px] font-bold text-sky-900/40">Étape 2 sur 3</span>
                <span class="text-[9px] font-extrabold text-cyan-500">67%</span>
              </div>
              <div class="h-1 bg-sky-50 rounded-full mb-5">
                <div id="pb2" class="h-full bg-gradient-to-r from-cyan-500 to-sky-500 rounded-full transition-all duration-1000" style="width: 0%;"></div>
              </div>

              <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-[11px] text-sky-950 mb-2">Choisissez une date</div>

              <!-- Mini calendar grid -->
              <div class="grid grid-cols-3 gap-1.5 mb-4">
                @foreach([['Lun','15'],['Mar','16'],['Mer','17'],['Jeu','18'],['Ven','19'],['Sam','20']] as $k => [$j,$d])
                <button class="pd flex flex-col items-center py-1.5 px-1 rounded-lg border text-center transition-all" data-k="{{ $k }}" onclick="selDay({{ $k }})" style="background: {{ $k===2 ? '#4F7BFF' : '#fafbff' }}; border-color: {{ $k===2 ? 'transparent' : 'rgba(0,0,0,0.07)' }};">
                  <span class="text-[8px] font-bold uppercase transition-all" style="color: {{ $k===2 ? '#fff' : '#5E7A99' }}">{{ $j }}</span>
                  <span class="font-['Plus_Jakarta_Sans',sans-serif] font-black text-xs transition-all" style="color: {{ $k===2 ? '#fff' : '#0B1F3A' }}">{{ $d }}</span>
                </button>
                @endforeach
              </div>

              <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-[11px] text-sky-950 mb-2">Créneaux disponibles</div>

              <!-- Slot list buttons -->
              <div class="flex flex-col gap-1.5">
                @foreach(['09:00','10:30','14:00','15:30'] as $t)
                <button class="w-full text-left py-2 px-3 rounded-lg border text-xs font-semibold font-['Plus_Jakarta_Sans',sans-serif] transition-all" onclick="selSlot(this)" style="background: {{ $t==='10:30' ? '#4F7BFF' : '#fafbff' }}; border-color: {{ $t==='10:30' ? 'transparent' : 'rgba(0,0,0,0.07)' }}; color: {{ $t==='10:30' ? '#fff' : '#0B1F3A' }}">{{ $t }}</button>
                @endforeach
              </div>
            </div>

            <!-- 📱 SCREEN 3: Confirmation -->
            <div id="ps3" class="wizard-screen" style="padding: 1.5rem;">
              <div class="text-center py-5">
                <div id="ccirc" class="w-16 h-16 rounded-full bg-gradient-to-br from-cyan-500 to-sky-500 flex items-center justify-center mx-auto shadow-lg shadow-cyan-500/30 scale-0 transition-transform duration-500">
                  <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path id="ck" d="M4.5 12.75l6 6 9-13.5" style="stroke-dasharray:32;stroke-dashoffset:32;transition:stroke-dashoffset 0.7s ease 0.3s;"/>
                  </svg>
                </div>
                <div class="font-['Plus_Jakarta_Sans',sans-serif] font-black text-sm text-sky-950 mt-4 mb-1">RDV Confirmé !</div>
                <div class="text-[10px] font-bold text-sky-900/40">Email envoyé • Rappel 24h avant</div>
              </div>

              <!-- Details summary card -->
              <div class="bg-sky-50/50 border border-cyan-100/30 rounded-xl p-3 mb-5">
                @foreach([['Médecin','Dr. Ahmed Alaoui'],['Spécialité','Médecine Générale'],['Date','Mercredi 17 Juin'],['Heure','10:30']] as [$l,$v])
                <div class="flex justify-between py-1.5 border-b border-cyan-50/50 last:border-b-0 text-[10px] font-bold">
                  <span class="text-sky-900/40">{{ $l }}</span>
                  <span class="font-['Plus_Jakarta_Sans',sans-serif] text-sky-950 {{ $l==='Heure' ? 'text-cyan-500':'' }}">{{ $v }}</span>
                </div>
                @endforeach
              </div>

              <a href="{{ route('register') }}" class="btn-hover-effect block text-center bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-['Plus_Jakarta_Sans',sans-serif] font-bold text-[11px] py-3 rounded-xl shadow-lg shadow-cyan-500/20 transition-all">
                Réserver maintenant
              </a>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       SPECIALITIES SECTION (Features Grid)
       ══════════════════════════════════════════════════════════════════ -->
  <section class="py-24 bg-gradient-to-br from-[#023E8A] via-[#0077B6] to-[#0096C7] text-white relative overflow-hidden" id="specialites" aria-label="Nos spécialités">

    <!-- Decorative Vector grids -->
    <div class="blob-pulse-1 absolute rounded-full bg-white/5 w-[420px] h-[420px] -top-[120px] -left-[120px] blur-3xl pointer-events-none"></div>
    <div class="blob-pulse-2 absolute rounded-full bg-white/5 w-[300px] h-[300px] -bottom-[100px] -right-[100px] blur-2xl pointer-events-none"></div>

    <div class="w-full max-w-7xl mx-auto px-6 relative z-10">

      <div class="text-center mb-16 reveal">
        <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-white bg-white/10 border border-white/10 py-1.5 px-4 rounded-full mb-4">
          Spécialités
        </div>
        <h2 class="font-['Plus_Jakarta_Sans',sans-serif] text-3xl sm:text-4xl font-extrabold text-white mb-5 leading-tight">
          Une plateforme complète<br>pour votre pratique médicale
        </h2>
        <p class="text-sky-100/70 text-[15px] max-w-lg mx-auto leading-relaxed">
          Gérez vos rendez-vous, vos patients et votre planning depuis un seul espace — accessible sur tous les appareils.
        </p>
      </div>

      <!-- Specialty Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
          ['Rappels Automatiques','Les patients reçoivent un email de rappel 24h avant chaque rendez-vous, réduisant les absences de 40%.','M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],
          ['Zéro Double-Réservation','Contrainte unique en base de données et vérification applicative garantissent qu'aucun créneau ne soit double-réservé.','M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
          ['Tableau de Bord IA','Statistiques en temps réel, prévisions de charge et recommandations pour optimiser votre planning de consultations.','M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
        ] as [$title,$desc,$path])
        <div class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-cyan-500/20 rounded-3xl p-8 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1.5 flex flex-col reveal delay-{{ $loop->index + 1 }} reveal-scale">
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-cyan-400 shrink-0 mb-6">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
          </div>
          <h3 class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-lg text-white mb-2">{{ $title }}</h3>
          <p class="text-sm text-sky-200/70 leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
      </div>

      <div class="text-center mt-12">
        <a href="{{ route('register') }}" class="btn-hover-effect bg-white hover:bg-sky-50 text-cyan-600 font-bold py-3 px-8 rounded-full shadow-lg inline-flex items-center gap-2 transition-all">
          Explorer toutes les fonctionnalités
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       SCHEDULING / CTA SECTION (Calendar Widget)
       ══════════════════════════════════════════════════════════════════ -->
  <section class="py-24 bg-white" aria-label="Réservation">
    <div class="w-full max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <!-- Text Column -->
        <div class="reveal reveal-left">
          <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 bg-cyan-500/10 py-1 px-3 rounded-full mb-4">Réservation</div>
          <h2 class="font-['Plus_Jakarta_Sans',sans-serif] text-3xl sm:text-4xl font-extrabold text-sky-950 mb-6 leading-tight">Prenez votre RDV<br>en moins de 60 secondes</h2>
          <p class="text-[15px] text-sky-900/70 leading-relaxed mb-8">
            Choisissez votre médecin, sélectionnez un créneau disponible en temps réel et confirmez. Un email de confirmation arrive instantanément — sans appel, sans attente.
          </p>
          <ul class="flex flex-col gap-4 mb-8" role="list">
            @foreach(['Compte gratuit en 3 minutes','Planning en temps réel','Confirmation email instantanée','Rappel automatique 24h avant'] as $item)
            <li class="flex items-center gap-3 text-sm font-semibold text-sky-900/70" role="listitem">
              <div class="w-5 h-5 rounded-full bg-cyan-500/10 flex items-center justify-center shrink-0 text-cyan-600">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
              </div>
              {{ $item }}
            </li>
            @endforeach
          </ul>
          <div class="flex flex-wrap gap-4">
            <a href="{{ route('register') }}" class="btn-hover-effect bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-cyan-500/20 text-sm transition-all">S'inscrire</a>
            <a href="{{ route('login') }}" class="btn-hover-effect border-2 border-cyan-500/30 text-cyan-600 hover:bg-cyan-500/5 font-bold py-3 px-8 rounded-full text-sm transition-all">Se connecter</a>
          </div>
        </div>

        <!-- Interactive Calendar Widget -->
        <div class="flex justify-center relative reveal reveal-right">
          <div class="bg-[#EBF6FB]/50 border border-cyan-100/50 rounded-[32px] shadow-xl p-8 w-full max-w-[380px] lg:ml-auto">

            <div class="flex items-center justify-between mb-6">
              <button class="w-8 h-8 rounded-lg bg-white border border-cyan-100/40 hover:border-cyan-500/40 flex items-center justify-center text-sky-900/60 hover:text-cyan-500 shadow-sm transition-all" aria-label="Mois précédent">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
              </button>
              <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-sm text-sky-950">Juin 2026</div>
              <button class="w-8 h-8 rounded-lg bg-white border border-cyan-100/40 hover:border-cyan-500/40 flex items-center justify-center text-sky-900/60 hover:text-cyan-500 shadow-sm transition-all" aria-label="Mois suivant">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
              </button>
            </div>

            <!-- Calendar Days Label Header -->
            <div class="grid grid-cols-7 gap-1 text-center mb-3">
              @foreach(['Lu','Ma','Me','Je','Ve','Sa','Di'] as $d)
              <div class="text-[10px] font-extrabold uppercase tracking-wider text-sky-900/40">{{ $d }}</div>
              @endforeach
            </div>

            <!-- Calendar Date Grid Cells -->
            <div class="flex flex-col gap-1.5">
              @foreach([
                [0,0,0,0,0,1,2],
                [3,4,5,6,7,8,9],
                [10,11,12,13,14,15,16],
                [17,18,19,20,21,22,23],
                [24,25,26,27,28,29,30]
              ] as $week)
              <div class="grid grid-cols-7 gap-1">
                @foreach($week as $day)
                <div class="flex justify-center items-center">
                  @if($day === 0)
                    <div class="w-8 h-8"></div>
                  @elseif($day === 15)
                    <button class="w-8 h-8 rounded-full bg-cyan-500 text-white font-['Plus_Jakarta_Sans',sans-serif] font-black text-xs shadow-md shadow-cyan-500/20 flex items-center justify-center focus:outline-none" aria-label="15 juin, sélectionné" aria-pressed="true">{{ $day }}</button>
                  @elseif(in_array($day, [16, 17, 19, 22]))
                    <button class="w-8 h-8 rounded-full bg-cyan-500/10 text-cyan-600 hover:bg-cyan-500/20 font-['Plus_Jakarta_Sans',sans-serif] font-extrabold text-xs flex items-center justify-center transition-all focus:outline-none" aria-label="{{ $day }} juin, disponible">{{ $day }}</button>
                  @else
                    <button class="w-8 h-8 rounded-full text-sky-950/70 hover:bg-sky-50 font-['Plus_Jakarta_Sans',sans-serif] font-medium text-xs flex items-center justify-center transition-all focus:outline-none" aria-label="{{ $day }} juin">{{ $day }}</button>
                  @endif
                </div>
                @endforeach
              </div>
              @endforeach
            </div>

            <!-- Mini List underneath calendar -->
            <div class="text-[9px] font-extrabold uppercase tracking-wider text-sky-900/40 mt-6 mb-3 pt-4 border-t border-cyan-100/50">Consultations prévues</div>
            <div class="flex flex-col gap-2">
              @foreach([['Dr. Ahmed Alaoui','10:30','#4F7BFF'],['Dr. Sarah Bennani','15:00','#7B61FF']] as [$name,$time,$color])
              <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/60 transition-all cursor-pointer">
                <div class="w-7 h-7 rounded-full flex items-center justify-center font-['Plus_Jakarta_Sans',sans-serif] font-black text-[10px] text-white shrink-0" style="background: {{ $color }}">{{ strtoupper(substr($name,0,1)) }}</div>
                <div class="text-[11px] font-bold text-sky-950 flex-1">{{ $name }}</div>
                <div class="text-[10px] font-bold text-sky-900/40">{{ $time }}</div>
                <div class="text-[10px] font-extrabold text-cyan-500 hover:text-cyan-600">Voir</div>
              </div>
              @endforeach
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════════
       TEAM SECTION (Doctors)
       ══════════════════════════════════════════════════════════════════ -->
  <section class="py-24 bg-[#EBF6FB]" id="medecins" aria-label="Notre équipe">
    <div class="w-full max-w-7xl mx-auto px-6">

      <div class="text-center mb-16 reveal">
        <div class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-cyan-500 bg-cyan-500/10 py-1.5 px-4 rounded-full mb-4">
          L'équipe médicale
        </div>
        <h2 class="font-['Plus_Jakarta_Sans',sans-serif] text-3xl sm:text-4xl font-extrabold text-sky-950 mb-5 leading-tight">
          Des experts de santé à votre écoute
        </h2>
        <p class="text-sky-900/70 text-[15px] max-w-lg mx-auto leading-relaxed">
          Médecins et ingénieurs réunis pour rendre la planification médicale plus intelligente, performante et humaine.
        </p>
      </div>

      <!-- Doctor cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
        @foreach([
          ['Dr. Sarah Nguyen','Directrice Médicale','Cardiologie','SN','linear-gradient(135deg,#00B4D8,#0077B6)'],
          ['Marcos Delgado','Ingénieur Principal','Backend / Laravel','MD','linear-gradient(135deg,#8b5cf6,#6d28d9)'],
          ['Julia Patel','Responsable Produit IA','Machine Learning','JP','linear-gradient(135deg,#059669,#065f46)'],
        ] as [$name,$role,$spec,$initials,$grad])
        <div class="bg-white border border-cyan-100/50 rounded-[32px] p-8 text-center hover:shadow-xl hover:border-cyan-200 hover:-translate-y-1.5 transition-all duration-300 reveal delay-{{ $loop->index + 1 }}">
          <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="w-24 h-24 rounded-full flex items-center justify-center font-['Plus_Jakarta_Sans',sans-serif] font-black text-2xl text-white shadow-md shadow-sky-950/10" style="background: {{ $grad }}">{{ $initials }}</div>
            <div class="absolute inset-[-4px] rounded-full border-2 border-transparent bg-gradient-to-tr from-cyan-400 to-sky-500 pointer-events-none" style="-webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0); -webkit-mask-composite: destination-out; mask-composite: exclude;"></div>
          </div>
          <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-base text-sky-950 mb-1">{{ $name }}</div>
          <div class="text-xs font-bold text-cyan-600 uppercase tracking-wide mb-1">{{ $role }}</div>
          <div class="text-[11px] font-bold text-sky-900/40 mb-6">{{ $spec }}</div>
          <div class="flex justify-center gap-3">
            <a href="#" class="w-9 h-9 rounded-full bg-sky-50 hover:bg-cyan-500/10 border border-cyan-100/30 hover:border-cyan-500/30 flex items-center justify-center text-sky-900/40 hover:text-cyan-600 transition-all" aria-label="LinkedIn de {{ $name }}">
              <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            <a href="#" class="w-9 h-9 rounded-full bg-sky-50 hover:bg-cyan-500/10 border border-cyan-100/30 hover:border-cyan-500/30 flex items-center justify-center text-sky-900/40 hover:text-cyan-600 transition-all" aria-label="Twitter de {{ $name }}">
              <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.26 5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </section>

</main>

<!-- ══════════════════════════════════════════════════════════════════
     FOOTER
     ══════════════════════════════════════════════════════════════════ -->
<footer class="bg-sky-950 text-sky-200/60 py-16 border-t border-sky-900" id="contact" role="contentinfo">
  <div class="w-full max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-16 mb-12">

      <!-- Brand Info -->
      <div class="lg:col-span-2">
        <div class="flex items-center gap-3.5 mb-5">
          <div class="w-[38px] h-[38px] bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-cyan-500/20 text-white">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12h6M9 16h4"/></svg>
          </div>
          <span class="font-['Plus_Jakarta_Sans',sans-serif] font-extrabold text-base text-white">MediBook<span class="text-cyan-400">AI</span></span>
        </div>
        <p class="text-sm text-sky-200/60 leading-relaxed mb-6 max-w-xs">Gestion intelligente des rendez-vous médicaux par IA. Zéro absence, planification optimisée, patients satisfaits.</p>
        <div class="flex gap-3">
          @foreach(['Facebook','Twitter','LinkedIn'] as $s)
          <a href="#" class="w-9 h-9 rounded-lg bg-white/5 border border-white/10 hover:bg-cyan-500 hover:border-cyan-500 hover:text-white flex items-center justify-center text-sky-200/60 transition-all" aria-label="{{ $s }}">
            @if($s==='Facebook')
            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            @elif($s==='Twitter')
            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.26 5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            @else
            <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            @endif
          </a>
          @endforeach
        </div>
      </div>

      <!-- Links Columns -->
      @foreach([
        ['Entreprise',['À propos','Blog','Équipe','Presse','Carrières']],
        ['Produit',['Fonctionnalités','Tarifs','API Docs','Nouveautés','Statut']],
        ['Assistance',["Centre d'aide",'Contact','Confidentialité','Conditions']],
      ] as [$col,$links])
      <div>
        <div class="font-['Plus_Jakarta_Sans',sans-serif] font-bold text-sm text-white mb-4">{{ $col }}</div>
        <ul class="flex flex-col gap-3">
          @foreach($links as $link)
          <li><a href="#" class="text-sm text-sky-200/60 hover:text-white transition-colors duration-150">{{ $link }}</a></li>
          @endforeach
        </ul>
      </div>
      @endforeach

    </div>

    <!-- Copyright Row -->
    <div class="border-t border-sky-900/60 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-semibold">
      <p>© {{ date('Y') }} MediBookAI. Tous droits réservés.</p>
      <div class="flex gap-6">
        <a href="#" class="hover:text-white transition-colors duration-150">Confidentialité</a>
        <a href="#" class="hover:text-white transition-colors duration-150">Conditions</a>
        <a href="#" class="hover:text-white transition-colors duration-150">Cookies</a>
      </div>
    </div>
  </div>
</footer>

<script>
/* ══════════════════════════════════════════════════════════════════
   1. NAVBAR SCROLL INTERACTION
   ══════════════════════════════════════════════════════════════════ */
window.addEventListener('scroll', () => {
  const scrolled = window.scrollY > 40;
  const nav = document.getElementById('nav');
  if (scrolled) {
    nav.classList.add('bg-white/95', 'shadow-md', 'shadow-sky-950/5');
    nav.classList.remove('bg-[#EBF6FB]/85');
  } else {
    nav.classList.remove('bg-white/95', 'shadow-md', 'shadow-sky-950/5');
    nav.classList.add('bg-[#EBF6FB]/85');
  }
}, { passive: true });

/* ══════════════════════════════════════════════════════════════════
   2. SCROLL REVEAL INTERSECTION OBSERVER
   ══════════════════════════════════════════════════════════════════ */
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      revealObserver.unobserve(e.target);
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

/* ══════════════════════════════════════════════════════════════════
   3. ANIMATED COUNTERS
   ══════════════════════════════════════════════════════════════════ */
function animateCounter(el, target, suffix, duration) {
  let startTime = null;
  const isDecimal = target % 1 !== 0;
  function step(ts) {
    if (!startTime) startTime = ts;
    const progress = Math.min((ts - startTime) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    const current = isDecimal ? (ease * target).toFixed(1) : Math.floor(ease * target);
    el.textContent = current + suffix;
    if (progress < 1) requestAnimationFrame(step);
    else el.textContent = target + suffix;
  }
  requestAnimationFrame(step);
}

const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      const el = e.target;
      const raw = el.dataset.count;
      const suffix = el.dataset.suffix || '';
      const target = parseFloat(raw);
      animateCounter(el, target, suffix, 1500);
      counterObserver.unobserve(el);
    }
  });
}, { threshold: 0.5 });

document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));

/* ══════════════════════════════════════════════════════════════════
   4. SPAWN FLOATING DECORATIVE PARTICLES
   ══════════════════════════════════════════════════════════════════ */
(function spawnParticles() {
  const hero = document.querySelector('#accueil');
  if (!hero) return;
  const colors = ['rgba(0,180,216,0.14)', 'rgba(0,119,182,0.1)', 'rgba(0,180,216,0.2)'];
  for (let i = 0; i < 15; i++) {
    const p = document.createElement('div');
    p.style.position = 'absolute';
    p.style.borderRadius = '50%';
    p.style.pointerEvents = 'none';
    p.style.animation = 'particle-float linear infinite';

    const size = Math.random() * 8 + 3;
    p.style.width = size + 'px';
    p.style.height = size + 'px';
    p.style.background = colors[Math.floor(Math.random() * colors.length)];
    p.style.left = (Math.random() * 100) + '%';
    p.style.bottom = (Math.random() * 30) + '%';
    p.style.animationDuration = (Math.random() * 8 + 6) + 's';
    p.style.animationDelay = (Math.random() * 5) + 's';

    hero.appendChild(p);
  }
})();

/* ══════════════════════════════════════════════════════════════════
   5. BUTTON HOVER MAGNETIC / SPRING EFFECT
   ══════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.btn-hover-effect').forEach(btn => {
  btn.addEventListener('mousemove', e => {
    const r = btn.getBoundingClientRect();
    const x = ((e.clientX - r.left) / r.width - 0.5) * 8;
    const y = ((e.clientY - r.top) / r.height - 0.5) * 5;
    btn.style.transform = `translateY(-1px) translate(${x}px, ${y}px)`;
  });
  btn.addEventListener('mouseleave', () => {
    btn.style.transform = '';
  });
});

/* ══════════════════════════════════════════════════════════════════
   6. CURSEUR GLOW cursor trailing (Glow Effect)
   ══════════════════════════════════════════════════════════════════ */
(function glowCursor() {
  const glow = document.createElement('div');
  glow.className = 'glow-cursor-shape';
  document.body.appendChild(glow);
  document.addEventListener('mousemove', e => {
    glow.style.left = e.clientX + 'px';
    glow.style.top = e.clientY + 'px';
  }, { passive: true });
})();

/* ══════════════════════════════════════════════════════════════════
   7. BUTTON RIPPLE CLICK ANIMATION
   ══════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.btn-hover-effect').forEach(btn => {
  btn.addEventListener('click', function(e) {
    const r = this.getBoundingClientRect();
    const circle = document.createElement('span');
    const size = Math.max(r.width, r.height);
    circle.className = 'ripple-span';
    circle.style.width = size + 'px';
    circle.style.height = size + 'px';
    circle.style.left = (e.clientX - r.left - size / 2) + 'px';
    circle.style.top = (e.clientY - r.top - size / 2) + 'px';

    this.appendChild(circle);
    setTimeout(() => circle.remove(), 500);
  });
});

/* ══════════════════════════════════════════════════════════════════
   8. TYPEWRITER SUBTITLE (Zéro Absences, Friction, Attente)
   ══════════════════════════════════════════════════════════════════ */
(function typewriter() {
  const phrases = [
    'Zéro Absences',
    'Zéro Attente',
    'Zéro Friction',
  ];
  const el = document.getElementById('tw-text');
  if (!el) return;
  let pi = 0, ci = 0, deleting = false;
  function tick() {
    const phrase = phrases[pi];
    if (!deleting) {
      el.textContent = phrase.slice(0, ++ci);
      if (ci === phrase.length) { deleting = true; setTimeout(tick, 2000); return; }
    } else {
      el.textContent = phrase.slice(0, --ci);
      if (ci === 0) { deleting = false; pi = (pi + 1) % phrases.length; setTimeout(tick, 450); return; }
    }
    setTimeout(tick, deleting ? 40 : 80);
  }
  tick();
})();

/* ══════════════════════════════════════════════════════════════════
   9. PATIENT PROCESS WIZARD ACTIVE CONTROL STATE
   ══════════════════════════════════════════════════════════════════ */
(function() {
  let activeStep = 1;
  let timerId = null;
  let isIntersecting = false;
  const ROTATION_TIME = 8000;

  const screens = {
    1: document.getElementById('ps1'),
    2: document.getElementById('ps2'),
    3: document.getElementById('ps3')
  };

  const cards = document.querySelectorAll('.ps');

  function activateStep(n, directionOverride) {
    if (n === activeStep && directionOverride !== 'init') return;

    let direction = 'forward';
    if (directionOverride === 'init') {
      direction = 'none';
    } else if (n < activeStep || (activeStep === 3 && n === 1 && directionOverride === 'auto')) {
      direction = directionOverride === 'auto' ? 'forward' : 'backward';
    } else {
      direction = 'forward';
    }

    cards.forEach(card => {
      const stepNum = parseInt(card.dataset.s);
      if (stepNum === n) {
        card.classList.add('active');
        const dot = card.querySelector('.psdot');
        if (dot) dot.style.display = 'block';
      } else {
        card.classList.remove('active');
        const dot = card.querySelector('.psdot');
        if (dot) dot.style.display = 'none';
      }
    });

    Object.keys(screens).forEach(key => {
      const stepKey = parseInt(key);
      const screen = screens[stepKey];
      if (!screen) return;

      if (stepKey === n) {
        screen.className = 'wizard-screen';
        if (direction === 'forward') {
          screen.classList.add('slide-left-in');
        } else if (direction === 'backward') {
          screen.classList.add('slide-right-in');
        }
        void screen.offsetWidth;
        screen.classList.remove('slide-left-in', 'slide-right-in');
        screen.classList.add('active');
      } else if (stepKey === activeStep && directionOverride !== 'init') {
        screen.className = 'wizard-screen';
        if (direction === 'forward') {
          screen.classList.add('slide-left-out');
        } else if (direction === 'backward') {
          screen.classList.add('slide-right-out');
        }
      } else {
        screen.className = 'wizard-screen';
      }
    });

    if (n === 2) {
      setTimeout(() => {
        const bar = document.getElementById('pb2');
        if (bar) bar.style.width = '67%';
      }, 100);
    } else {
      const bar = document.getElementById('pb2');
      if (bar) bar.style.width = '0%';
    }

    if (n === 3) {
      setTimeout(() => {
        const c = document.getElementById('ccirc');
        const k = document.getElementById('ck');
        if (c) c.style.transform = 'scale(1)';
        if (k) k.style.strokeDashoffset = '0';
      }, 150);
    } else {
      const c = document.getElementById('ccirc');
      const k = document.getElementById('ck');
      if (c) c.style.transform = 'scale(0)';
      if (k) k.style.strokeDashoffset = '32';
    }

    activeStep = n;
  }

  function startRotation() {
    stopRotation();
    if (!isIntersecting) return;
    timerId = setInterval(() => {
      const nextStep = (activeStep % 3) + 1;
      activateStep(nextStep, 'auto');
    }, ROTATION_TIME);
  }

  function stopRotation() {
    if (timerId) {
      clearInterval(timerId);
      timerId = null;
    }
  }

  window.goStep = function(n) {
    activateStep(n, 'manual');
    startRotation();
  };

  window.selDay = function(k) {
    document.querySelectorAll('.pd').forEach(function(b, i) {
      b.style.background  = i === k ? '#4F7BFF' : '#fafbff';
      b.style.borderColor = i === k ? 'transparent' : 'rgba(0,0,0,.07)';
      b.querySelectorAll('span').forEach(function(s) {
        s.style.color = i === k ? '#fff' : (s === b.firstElementChild ? '#5E7A99' : '#0B1F3A');
      });
    });
  };

  window.selSlot = function(btn) {
    btn.closest('#ps2').querySelectorAll('button:not(.pd)').forEach(function(b) {
      b.style.background  = '#fafbff';
      b.style.borderColor = 'rgba(0,0,0,.07)';
      b.style.color       = '#0B1F3A';
    });
    btn.style.background  = '#4F7BFF';
    btn.style.borderColor = 'transparent';
    btn.style.color       = '#fff';
  };

  const sec = document.getElementById('proc');
  if (sec && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      isIntersecting = entries[0].isIntersecting;
      if (isIntersecting) {
        startRotation();
      } else {
        stopRotation();
      }
    }, { threshold: 0.15 });
    observer.observe(sec);
  } else {
    isIntersecting = true;
    startRotation();
  }

  activateStep(1, 'init');
})();
</script>

<style>
@keyframes pdot { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.6); opacity: .5; } }
@keyframes particle-float { 0% { transform: translateY(0) rotate(0deg); opacity: .6; } 100% { transform: translateY(-150px) rotate(360deg); opacity: 0; } }
</style>
</body>
</html>
