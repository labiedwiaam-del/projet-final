@extends('layouts.app')
@section('title', 'Nouvelle Disponibilité')
@section('header', 'Nouvelle Disponibilité')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form method="POST" action="{{ route('doctor.schedules.store') }}" class="space-y-5">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jour de la semaine</label>
                <select name="schedules[lundi][jour_semaine]"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach(['lundi'=>'Lundi','mardi'=>'Mardi','mercredi'=>'Mercredi','jeudi'=>'Jeudi','vendredi'=>'Vendredi','samedi'=>'Samedi','dimanche'=>'Dimanche'] as $val => $lbl)
                    <option value="{{ $val }}">{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <p class="text-sm text-blue-600 bg-blue-50 p-3 rounded-xl">
                💡 Pour gérer tous vos jours d'un coup, utilisez la page <a href="{{ route('doctor.schedules') }}" class="underline font-semibold">Mon Planning</a>.
            </p>

            <a href="{{ route('doctor.schedules') }}"
               class="inline-block bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm">
                ← Retour au planning
            </a>
        </form>
    </div>
</div>
@endsection
