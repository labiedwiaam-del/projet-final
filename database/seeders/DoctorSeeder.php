<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'prenom'    => 'Sarah',
                'nom'       => 'Bennani',
                'email'     => 'sarah@medical.com',
                'specialite'=> 'Cardiologie',
                'bio'       => 'Cardiologue expérimentée avec 15 ans de pratique.',
                'licence'   => 'MED-001',
            ],
            [
                'prenom'    => 'Ahmed',
                'nom'       => 'Alaoui',
                'email'     => 'ahmed@medical.com',
                'specialite'=> 'Médecine Générale',
                'bio'       => 'Médecin généraliste disponible 5 jours sur 7.',
                'licence'   => 'MED-002',
            ],
            [
                'prenom'    => 'Maria',
                'nom'       => 'Lopez',
                'email'     => 'maria@medical.com',
                'specialite'=> 'Pédiatrie',
                'bio'       => 'Pédiatre spécialisée dans le suivi de l\'enfant.',
                'licence'   => 'MED-003',
            ],
        ];

        foreach ($doctors as $d) {
            $user = User::firstOrCreate(
                ['email' => $d['email']],
                [
                    'prenom'   => $d['prenom'],
                    'nom'      => $d['nom'],
                    'password' => Hash::make('password'),
                    'role'     => 'medecin',
                    'actif'    => true,
                ]
            );

            $doctor = Doctor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialite'         => $d['specialite'],
                    'bio'                => $d['bio'],
                    'numero_licence'     => $d['licence'],
                    'duree_consultation' => 30,
                    'tarif'              => 300.00,
                    'is_active'          => true,
                ]
            );

            // Plannings : lundi au vendredi, 9h–17h, créneaux de 30 min
            foreach (['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'] as $jour) {
                Schedule::firstOrCreate(
                    ['medecin_id' => $doctor->id, 'jour_semaine' => $jour],
                    [
                        'heure_debut'   => '09:00',
                        'heure_fin'     => '17:00',
                        'slot_duration' => 30,
                        'actif'         => true,
                    ]
                );
            }
        }
    }
}
