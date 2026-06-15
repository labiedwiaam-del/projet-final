{{-- Ce fichier redirige vers le bon tableau de bord selon le rôle --}}
@php
    $role = auth()->user()?->role;
    if ($role === 'admin') {
        redirect('/admin/dashboard')->send();
    } elseif ($role === 'medecin') {
        redirect('/doctor/dashboard')->send();
    } else {
        redirect('/patient/dashboard')->send();
    }
@endphp
