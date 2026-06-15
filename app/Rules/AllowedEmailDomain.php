<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valide que l'email appartient à un domaine autorisé pour les patients.
 * Domaines acceptés : @gmail.com | @hotmail.fr | @yahoo.com
 */
class AllowedEmailDomain implements ValidationRule
{
    /** Domaines autorisés */
    private const ALLOWED = [
        'gmail.com',
        'hotmail.fr',
        'yahoo.com',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $domain = strtolower(substr(strrchr((string) $value, '@'), 1));

        if (!in_array($domain, self::ALLOWED, true)) {
            $fail(
                'L\'adresse email doit appartenir à un domaine autorisé : ' .
                implode(', ', array_map(fn($d) => '@' . $d, self::ALLOWED)) . '.'
            );
        }
    }
}
