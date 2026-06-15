<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'nom',
        'telephone',
        'email',
        'password',
        'role',
        'actif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'actif'             => 'boolean',
    ];

    /** Relation : profil médecin (si role=medecin) */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /** Relation : rendez-vous en tant que patient */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /** Nom complet (prénom + nom) */
    public function getFullNameAttribute(): string
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isDoctor(): bool  { return $this->role === 'medecin'; }
    public function isPatient(): bool { return $this->role === 'patient'; }

    /** Synchronise le champ `name` quand `nom` est modifié */
    public function setNomAttribute($value): void
    {
        $this->attributes['nom']  = $value;
        $this->attributes['name'] = trim(($this->attributes['prenom'] ?? $this->prenom ?? '') . ' ' . $value);
    }

    /** Synchronise le champ `name` quand `prenom` est modifié */
    public function setPrenomAttribute($value): void
    {
        $this->attributes['prenom'] = $value;
        $this->attributes['name']   = trim($value . ' ' . ($this->attributes['nom'] ?? $this->nom ?? ''));
    }
}
