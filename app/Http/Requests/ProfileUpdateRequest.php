<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\AllowedEmailDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        // La restriction de domaine ne s'applique qu'aux patients
        $emailRules = [
            'required', 'string', 'lowercase', 'email', 'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ];

        if ($this->user()->isPatient()) {
            $emailRules[] = new AllowedEmailDomain();
        }

        return [
            'prenom'    => ['required', 'string', 'max:100'],
            'nom'       => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email'     => $emailRules,
        ];
    }
}
