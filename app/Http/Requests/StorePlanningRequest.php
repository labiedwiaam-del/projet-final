<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'medecin';
    }

    public function rules(): array
    {
        return [
            'jour_semaine' => ['required', 'string', 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin' => ['required', 'date_format:H:i', 'after:heure_debut'],
            'actif' => ['sometimes', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        if ($this->has('actif')) {
            $this->merge(['actif' => boolval($this->actif)]);
        }
    }
}
