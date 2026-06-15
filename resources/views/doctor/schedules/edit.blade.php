@extends('layouts.app')
@section('title', 'Modifier Disponibilité')
@section('header', 'Modifier Disponibilité')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <p class="text-sm text-blue-600 bg-blue-50 p-3 rounded-xl mb-4">
            💡 Gérez toutes vos disponibilités depuis la page
            <a href="{{ route('doctor.schedules') }}" class="underline font-semibold">Mon Planning</a>.
        </p>
        <a href="{{ route('doctor.schedules') }}"
           class="inline-block bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm">
            ← Retour au planning
        </a>
    </div>
</div>
@endsection
