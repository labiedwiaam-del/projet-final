<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediBookAI — Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800;900&family=Noto+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3Z4pXdGS8lnykrLN2eYc3UyRjA6QZjugMqfOiF+LJiX2rjS4divM0nl7ZtCsz47" crossorigin="anonymous">
    <style>
        :root {
            --bg: #f4f9ff;
            --surface: #ffffff;
            --surface-strong: #f0f6fe;
            --primary: #0b76d1;
            --primary-dark: #0959ab;
            --secondary: #4f7ebf;
            --text: #0d304e;
            --muted: #6d86a4;
            --border: rgba(11, 118, 209, 0.12);
            --shadow: 0 24px 60px rgba(11, 118, 209, 0.12);
            --radius: 28px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Noto Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.65;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Figtree', sans-serif;
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(11, 118, 209, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--primary);
        }

        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .hero {
            position: relative;
            padding: 110px 0 80px;
            overflow: hidden;
            background: radial-gradient(circle at top right, rgba(11, 118, 209, 0.18), transparent 35%), linear-gradient(180deg, #f8fbff 0%, #eef7ff 100%);
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 18% 20%, rgba(11, 118, 209, 0.12), transparent 28%), radial-gradient(circle at 88% 40%, rgba(47, 120, 253, 0.12), transparent 24%);
            pointer-events: none;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            border-radius: 999px;
            background: rgba(11, 118, 209, 0.09);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.84rem;
            letter-spacing: 0.08em;
        }

        .hero-title {
            font-size: clamp(2.8rem, 4.5vw, 4.2rem);
            line-height: 1.02;
            margin-bottom: 1.25rem;
        }

        .hero-title .accent {
            color: var(--primary);
        }

        .hero-text {
            max-width: 42rem;
            color: var(--muted);
            font-size: 1rem;
        }

        .hero-figure {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-illustration {
            position: relative;
            width: 100%;
            max-width: 420px;
            border-radius: 34px;
            padding: 1.5rem;
            background: linear-gradient(150deg, #eef7ff 0%, #ffffff 100%);
            box-shadow: 0 28px 80px rgba(11, 118, 209, 0.14);
        }

        .hero-stats .stat-box {
            background: var(--surface-strong);
            border: 1px solid rgba(11, 118, 209, 0.1);
            border-radius: 22px;
            padding: 1.25rem 1.3rem;
            transition: transform 0.25s ease, border-color 0.25s ease;
        }

        .hero-stats .stat-box:hover {
            transform: translateY(-3px);
            border-color: rgba(11, 118, 209, 0.2);
        }

        .stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--primary);
        }

        .stat-label {
            color: var(--muted);
            margin-top: 0.45rem;
            letter-spacing: 0.02em;
            font-size: 0.9rem;
        }

        .section-heading {
            max-width: 580px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--primary);
            font-size: 0.77rem;
        }

        .feature-card,
        .specialty-card,
        .doctor-card {
            border: 1px solid rgba(11, 118, 209, 0.12);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: 0 18px 45px rgba(11, 118, 209, 0.08);
            transition: transform 0.27s ease, box-shadow 0.27s ease;
        }

        .feature-card:hover,
        .specialty-card:hover,
        .doctor-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 28px 70px rgba(11, 118, 209, 0.11);
        }

        .feature-icon,
        .specialty-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), #0d8dcd);
            box-shadow: inset 0 0 0 4px rgba(255,255,255,.14);
        }

        .feature-title,
        .specialty-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.55rem;
        }

        .feature-text,
        .specialty-text,
        .doctor-role {
            color: var(--muted);
        }

        .process-step {
            border-radius: 24px;
            border: 1px solid rgba(11, 118, 209, 0.1);
            background: var(--surface);
            padding: 1.65rem;
            transition: transform 0.27s ease, border-color 0.27s ease;
        }

        .process-step:hover {
            transform: translateY(-4px);
            border-color: rgba(11, 118, 209, 0.18);
        }

        .process-number {
            width: 48px;
            height: 48px;
            border-radius: 18px;
            background: rgba(11, 118, 209, 0.12);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .assistant-section {
            background: linear-gradient(135deg, #0b5ed7 0%, #0a84d8 45%, #1070d4 100%);
            color: #fff;
            border-radius: 36px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .assistant-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255,255,255,0.28), transparent 28%);
            pointer-events: none;
        }

        .assistant-section .feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            font-weight: 700;
            font-size: 0.86rem;
        }

        .assistant-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 24px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .assistant-card .assistant-caption {
            color: rgba(255,255,255,0.8);
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 0.85rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            color: #fff;
            font-size: 0.84rem;
            font-weight: 600;
        }

        .doctor-card {
            overflow: hidden;
        }

        .doctor-card .avatar {
            width: 74px;
            height: 74px;
            border-radius: 22px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #0b76d1, #0c97e5);
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .doctor-card .doctor-meta {
            color: var(--muted);
        }

        .doctor-card .doctor-cta {
            margin-top: 1.1rem;
        }

        .footer {
            background: #082f5a;
            color: #cfdaf0;
        }

        .footer a {
            color: #d8e6ff;
        }

        .footer a:hover {
            color: #ffffff;
        }

        .footer .footer-title {
            color: #ffffff;
            font-weight: 700;
        }

        .section-separator {
            height: 1px;
            background: rgba(11, 118, 209, 0.12);
            border: none;
            margin: 0;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUp 0.8s ease forwards;
        }

        .fade-delay-1 { animation-delay: 0.14s; }
        .fade-delay-2 { animation-delay: 0.22s; }
        .fade-delay-3 { animation-delay: 0.30s; }
        .fade-delay-4 { animation-delay: 0.38s; }
        .fade-delay-5 { animation-delay: 0.46s; }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .hero { padding-top: 100px; }
            .hero-title { font-size: clamp(2.5rem, 6vw, 3.5rem); }
        }

        @media (max-width: 768px) {
            .hero { padding-top: 90px; }
            .hero-figure { min-height: 440px; }
            .assistant-section { padding: 2rem; }
        }
    </style>
</head>
<body>
    <a href="#main" class="visually-hidden-focusable">Aller au contenu principal</a>
    <header class="sticky-top shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light px-3 px-lg-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">MediBookAI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Ouvrir le menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link px-3" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#processus">Fonctionnement</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#specialites">Spécialités</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#assistant">Assistant vocal</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#medecins">Médecins</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary py-2 px-3">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm py-2 px-4">Prendre rendez-vous</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main id="main">
        <section class="hero">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6">
                        <div class="hero-label fade-up fade-delay-1">Plateforme médicale premium</div>
                        <h1 class="hero-title fade-up fade-delay-2">Organisez vos rendez-vous médicaux avec une expérience fluide et rassurante.</h1>
                        <p class="hero-text fade-up fade-delay-3">MediBookAI harmonise la prise de rendez-vous, la gestion des plannings et les notifications patients pour les cabinets médicaux, cliniques et centres de santé.</p>
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 mt-4 fade-up fade-delay-4">
                            <a href="#services" class="btn btn-primary btn-lg">Prendre rendez-vous</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Se connecter</a>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-2 g-3 mt-5 hero-stats">
                            <div class="col fade-up fade-delay-5">
                                <div class="stat-box p-4 h-100">
                                    <div class="stat-value">150+</div>
                                    <div class="stat-label">Patients accueillis</div>
                                </div>
                            </div>
                            <div class="col fade-up fade-delay-5">
                                <div class="stat-box p-4 h-100">
                                    <div class="stat-value">98%</div>
                                    <div class="stat-label">Taux de rendez-vous honorés</div>
                                </div>
                            </div>
                            <div class="col fade-up fade-delay-5">
                                <div class="stat-box p-4 h-100">
                                    <div class="stat-value">24/7</div>
                                    <div class="stat-label">Prise de rendez-vous en ligne</div>
                                </div>
                            </div>
                            <div class="col fade-up fade-delay-5">
                                <div class="stat-box p-4 h-100">
                                    <div class="stat-value">1 min</div>
                                    <div class="stat-label">Réservation instantanée</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 fade-up fade-delay-4">
                        <div class="hero-card hero-figure p-4">
                            <div class="hero-illustration">
                                <svg viewBox="0 0 480 560" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="g1" x1="52" y1="50" x2="428" y2="510" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#d6efff"/>
                                            <stop offset="1" stop-color="#eef7ff"/>
                                        </linearGradient>
                                        <linearGradient id="g2" x1="240" y1="160" x2="240" y2="470" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#ffffff"/>
                                            <stop offset="1" stop-color="#e7f3ff"/>
                                        </linearGradient>
                                    </defs>
                                    <rect x="20" y="20" width="440" height="520" rx="44" fill="url(#g1)"/>
                                    <path d="M120 400c0-80 45-140 110-140s110 60 110 140" fill="#ffffff" opacity="0.9"/>
                                    <ellipse cx="240" cy="175" rx="90" ry="96" fill="#f8d4b2"/>
                                    <path d="M190 252c0 36 25 48 50 48s50-12 50-48v-14H190v14Z" fill="#fff"/>
                                    <path d="M153 140c0-48 42-88 94-88s94 39 94 88v52H153v-52Z" fill="#fff"/>
                                    <path d="M153 140c0-48 42-88 94-88s94 39 94 88v52H153v-52Z" fill="url(#g2)" opacity="0.9"/>
                                    <path d="M168 134c0-28 24-52 52-52s52 24 52 52v24H168v-24Z" fill="#2f5f86" opacity="0.15"/>
                                    <path d="M155 190c0 24 48 24 85 24s85 0 85-24" stroke="#0b76d1" stroke-width="10" stroke-linecap="round"/>
                                    <path d="M168 332c16 50 53 95 90 95 37 0 74-45 90-95" fill="#c7dff5"/>
                                    <path d="M138 320c24 22 40 50 52 82 12 32 25 36 50 36 25 0 38-4 50-36 12-32 28-60 52-82" fill="#fff"/>
                                    <circle cx="125" cy="118" r="12" fill="#0b76d1" opacity="0.18"/>
                                    <circle cx="360" cy="110" r="16" fill="#0b76d1" opacity="0.16"/>
                                    <rect x="320" y="360" width="90" height="40" rx="20" fill="#0b76d1" opacity="0.12"/>
                                    <rect x="70" y="420" width="120" height="24" rx="12" fill="#0b76d1" opacity="0.12"/>
                                </svg>
                            </div>
                            <div class="mt-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="badge bg-primary bg-opacity-15 text-primary rounded-pill py-2 px-3">Docteur disponible</span>
                                    <span class="text-muted">Réservations en temps réel</span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-4 border border-1 border-primary border-opacity-10 shadow-sm">
                                            <div class="text-uppercase text-primary small mb-1">Patients</div>
                                            <div class="fw-bold">1 250+</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-white rounded-4 border border-1 border-primary border-opacity-10 shadow-sm">
                                            <div class="text-uppercase text-primary small mb-1">Satisfaction</div>
                                            <div class="fw-bold">97%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="py-5">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-6 section-heading fade-up fade-delay-1">
                        <span class="section-label">Services</span>
                        <h2 class="fw-bold">Tout ce dont votre cabinet médical a besoin.</h2>
                        <p class="text-muted">Quatre modules essentiels conçus pour simplifier la prise de rendez-vous, le planning des médecins et la communication avec les patients.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-2">
                        <article class="feature-card p-4 h-100">
                            <div class="feature-icon mb-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 7V3h8v4"/><path d="M5 7h14v14H5z"/><path d="M16 11h-4v4"/></svg>
                            </div>
                            <h3 class="feature-title">Réservation instantanée</h3>
                            <p class="feature-text">Interface patient claire pour choisir spécialité, médecin et créneau en quelques secondes.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-3">
                        <article class="feature-card p-4 h-100">
                            <div class="feature-icon mb-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10"/><path d="M7 11h10"/><path d="M7 15h6"/><path d="M4 5h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>
                            </div>
                            <h3 class="feature-title">Gestion des médecins</h3>
                            <p class="feature-text">Pilotez les profils, les spécialités et les plages de consultation depuis un tableau de bord unique.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-4">
                        <article class="feature-card p-4 h-100">
                            <div class="feature-icon mb-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8h18"/><path d="M8 8v13"/><path d="M16 8v13"/><path d="M3 5h18"/><path d="M7 5v3"/><path d="M17 5v3"/></svg>
                            </div>
                            <h3 class="feature-title">Planning intelligent</h3>
                            <p class="feature-text">Visualisez les disponibilités de chaque médecin, empêchez les doubles réservations et adaptez votre flux de patients.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-5">
                        <article class="feature-card p-4 h-100">
                            <div class="feature-icon mb-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v6a9 9 0 11-6-8.4"/><path d="M12 4v4"/><path d="M12 12l2 2"/></svg>
                            </div>
                            <h3 class="feature-title">Alertes et email</h3>
                            <p class="feature-text">Rappels automatiques, confirmations et relances par email réduisent les absences et renforcent la confiance.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="processus" class="py-5 bg-white">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-5 fade-up fade-delay-1">
                        <span class="section-label">Fonctionnement</span>
                        <h2 class="fw-bold">Un parcours patient simple et rassurant.</h2>
                        <p class="text-muted">Choix du médecin, sélection du créneau et confirmation : chaque étape est conçue pour être rapide, accessible et médicale.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-4">
                            <div class="col-md-4 fade-up fade-delay-2">
                                <article class="process-step h-100">
                                    <div class="process-number">1</div>
                                    <h3 class="h5">Choisir un médecin</h3>
                                    <p class="text-muted">Filtrez par spécialité, disponibilité et avis patients pour trouver le bon professionnel.</p>
                                </article>
                            </div>
                            <div class="col-md-4 fade-up fade-delay-3">
                                <article class="process-step h-100">
                                    <div class="process-number">2</div>
                                    <h3 class="h5">Sélectionner la date</h3>
                                    <p class="text-muted">Consultez les plages horaires en temps réel et réservez un créneau sécurisé.</p>
                                </article>
                            </div>
                            <div class="col-md-4 fade-up fade-delay-4">
                                <article class="process-step h-100">
                                    <div class="process-number">3</div>
                                    <h3 class="h5">Confirmer le rendez-vous</h3>
                                    <p class="text-muted">Recevez une confirmation instantanée ainsi qu’un email de rappel 24h avant.</p>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="specialites" class="py-5">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-6 section-heading fade-up fade-delay-1">
                        <span class="section-label">Spécialités médicales</span>
                        <h2 class="fw-bold">Des consultations adaptées à chaque besoin.</h2>
                        <p class="text-muted">Cardiologie, pédiatrie, gynécologie et médecine générale : connectez facilement vos patients au bon spécialiste.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-2">
                        <article class="specialty-card p-4 h-100 text-center text-md-start">
                            <div class="specialty-icon mb-4 bg-primary bg-gradient">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 5h12"/><path d="M6 10h12"/><path d="M11 15h2"/><path d="M12 16v5"/><path d="M8 3v2"/><path d="M16 3v2"/><path d="M3 12h2"/><path d="M19 12h2"/></svg>
                            </div>
                            <h3 class="specialty-title">Cardiologie</h3>
                            <p class="specialty-text">Surveillance cardiaque, bilan, suivi personnalisé et coordination avec le cardiologue.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-3">
                        <article class="specialty-card p-4 h-100 text-center text-md-start">
                            <div class="specialty-icon mb-4 bg-primary bg-gradient">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h14"/><path d="M4 20h16"/><path d="M6 7h12"/><path d="M12 11a4 4 0 100-8 4 4 0 000 8z"/></svg>
                            </div>
                            <h3 class="specialty-title">Pédiatrie</h3>
                            <p class="specialty-text">Prise en charge enfant, vaccinations et suivis familiaux dans un environnement sécurisé.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-4">
                        <article class="specialty-card p-4 h-100 text-center text-md-start">
                            <div class="specialty-icon mb-4 bg-primary bg-gradient">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a9 9 0 019 9v7a3 3 0 01-3 3H6a3 3 0 01-3-3v-7a9 9 0 019-9z"/><path d="M9 14h6"/><path d="M12 11v6"/></svg>
                            </div>
                            <h3 class="specialty-title">Gynécologie</h3>
                            <p class="specialty-text">Consultations confidentielles, suivi grossesse et examens de prévention.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3 fade-up fade-delay-5">
                        <article class="specialty-card p-4 h-100 text-center text-md-start">
                            <div class="specialty-icon mb-4 bg-primary bg-gradient">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/><path d="M4 20h16"/></svg>
                            </div>
                            <h3 class="specialty-title">Médecine générale</h3>
                            <p class="specialty-text">Suivi complet, renouvellement d’ordonnances et coordination des soins courants.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="assistant" class="py-5">
            <div class="container">
                <div class="assistant-section p-lg-5">
                    <div class="row align-items-center gy-5">
                        <div class="col-lg-6 fade-up fade-delay-1">
                            <span class="feature-pill">ElevenLabs Voice AI</span>
                            <h2 class="mt-4 mb-3 fw-bold">Assistant vocal médical intelligent</h2>
                            <p class="text-white-75 mb-4">Permettez à vos patients de réserver un rendez-vous par la voix, de recevoir une confirmation audio et d’obtenir un rappel personnalisé en français.</p>
                            <div class="row row-cols-1 row-cols-sm-2 g-3">
                                <div class="col"><div class="badge-soft">Réservation vocale</div></div>
                                <div class="col"><div class="badge-soft">Confirmation instantanée</div></div>
                                <div class="col"><div class="badge-soft">Notification proactive</div></div>
                                <div class="col"><div class="badge-soft">Support patient 24/7</div></div>
                            </div>
                        </div>
                        <div class="col-lg-6 fade-up fade-delay-2">
                            <div class="assistant-card">
                                <div class="assistant-caption text-white-75">Assistant vocal</div>
                                <h3 class="fs-5 fw-bold">« Bonjour Madame, je souhaite prendre un rendez-vous en cardiologie pour le lundi matin. »</h3>
                                <p class="mt-3 text-white-75">L’assistant reconnaît les besoins, propose des créneaux disponibles et confirme automatiquement le rendez-vous dans le planning.</p>
                                <div class="mt-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="fw-semibold">Réservation par voix</span>
                                        <span class="badge bg-white text-primary rounded-pill">Vocale</span>
                                    </div>
                                    <div class="progress" style="height: 10px; border-radius: 999px;">
                                        <div class="progress-bar bg-white" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex gap-3 flex-column flex-sm-row">
                                    <div class="flex-grow-1 p-3 bg-white bg-opacity-10 rounded-4">
                                        <div class="fw-semibold">Assistant</div>
                                        <div class="text-white-75 small">Réservation sans contact humain.</div>
                                    </div>
                                    <div class="flex-grow-1 p-3 bg-white bg-opacity-10 rounded-4">
                                        <div class="fw-semibold">Confirmation</div>
                                        <div class="text-white-75 small">Email et rappel audio 24h avant.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="medecins" class="py-5 bg-white">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-7 section-heading fade-up fade-delay-1">
                        <span class="section-label">Médecins</span>
                        <h2 class="fw-bold">Équipe médicale qualifiée et professionnelle.</h2>
                        <p class="text-muted">Découvrez quelques-uns des médecins disponibles sur la plateforme, chacun avec une spécialité dédiée.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-xl-4 fade-up fade-delay-2">
                        <article class="doctor-card p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar">AD</div>
                                <div>
                                    <h3 class="h5 mb-1">Dr. Amélie Dubois</h3>
                                    <p class="doctor-role mb-0">Cardiologue</p>
                                </div>
                            </div>
                            <p class="text-muted">Spécialiste en cardio-vasculaire, elle propose le suivi des patients chroniques et les bilans cardiaques.</p>
                            <div class="mt-auto doctor-cta">
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Voir le profil</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-4 fade-up fade-delay-3">
                        <article class="doctor-card p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar">SM</div>
                                <div>
                                    <h3 class="h5 mb-1">Dr. Samir Malek</h3>
                                    <p class="doctor-role mb-0">Pédiatre</p>
                                </div>
                            </div>
                            <p class="text-muted">Accompagnant les enfants et les familles avec une approche rassurante et des soins adaptés.</p>
                            <div class="mt-auto doctor-cta">
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Voir le profil</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-4 fade-up fade-delay-4">
                        <article class="doctor-card p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar">LC</div>
                                <div>
                                    <h3 class="h5 mb-1">Dr. Léa Charrier</h3>
                                    <p class="doctor-role mb-0">Gynécologue</p>
                                </div>
                            </div>
                            <p class="text-muted">Prévention, suivi grossesse et consultations de gynécologie générale.</p>
                            <div class="mt-auto doctor-cta">
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Voir le profil</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-6 col-lg-4">
                    <h3 class="footer-title">MediBookAI</h3>
                    <p class="mt-3">Plateforme de prise de rendez-vous médicaux premium, pensée pour réduire les no-shows et améliorer l’expérience patient.</p>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h4 class="footer-title">Liens</h4>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><a href="#services">Services</a></li>
                        <li class="mb-2"><a href="#processus">Fonctionnement</a></li>
                        <li class="mb-2"><a href="#specialites">Spécialités</a></li>
                        <li><a href="#assistant">Assistant vocal</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <h4 class="footer-title">Contact</h4>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2">support@medibookai.fr</li>
                        <li class="mb-2">+33 1 23 45 67 89</li>
                        <li>Paris, France</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h4 class="footer-title">Notre promesse</h4>
                    <p class="mt-3">Sécurité, disponibilité et assistance proactive pour chaque consultation médicale.</p>
                </div>
            </div>
            <hr class="section-separator my-5">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center text-muted small">
                <p class="mb-2 mb-sm-0">© 2026 MediBookAI. Tous droits réservés.</p>
                <div class="d-flex gap-3">
                    <a href="#">Mentions légales</a>
                    <a href="#">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-sr98rVt+k8gVZrQ1r5zXvsI9zRQXwibGPMFml4r5AOBhteGJT3cRD7pXkR0G+N1c" crossorigin="anonymous"></script>
</body>
</html>
