@extends('layouts.app')
@section('title', 'Mon Profil')
@section('header', 'Mon Profil')
@section('subheader', 'Mettez à jour vos informations personnelles')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Informations --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h3 class="font-bold text-gray-800 mb-6">Informations personnelles</h3>
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Mot de passe --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h3 class="font-bold text-gray-800 mb-6">Changer le mot de passe</h3>
        @include('profile.partials.update-password-form')
    </div>

    {{-- Supprimer le compte --}}
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-8">
        <h3 class="font-bold text-red-700 mb-6">Supprimer mon compte</h3>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
