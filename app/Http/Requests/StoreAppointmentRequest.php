<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'patient';
    }

    public function rules(): array
    {
        return [
            'medecin_id' => ['required', 'integer', 'exists:medecins,id'],
            'date_rdv' => ['required', 'date', 'after_or_equal:today'],
            'heure_rdv' => ['required', 'date_format:H:i'],
            'motif' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_rdv.after_or_equal' => 'La date du rendez-vous doit être aujourd’hui ou dans le futur.',
            'heure_rdv.date_format' => 'L’heure doit être au format HH:MM.',
        ];
    }
}
