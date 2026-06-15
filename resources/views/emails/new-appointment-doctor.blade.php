<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau rendez-vous réservé</title>
</head>
<body style="font-family: 'Segoe UI', sans-serif; background: #f3f4f6; margin: 0; padding: 24px;">
<div style="max-width: 600px; margin: auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

    {{-- Header --}}
    <div style="background: linear-gradient(135deg, #023E8A, #0077B6); padding: 32px 40px;">
        <p style="color: #90e0ef; font-size: 12px; font-weight: 600; letter-spacing: 1px; margin: 0 0 8px;">MEDIBOOK</p>
        <h1 style="color: #fff; font-size: 24px; margin: 0; font-weight: 700;">📅 Nouveau rendez-vous réservé</h1>
    </div>

    {{-- Body --}}
    <div style="padding: 40px;">
        <p style="color: #374151; font-size: 16px; margin: 0 0 24px;">
            Bonjour Dr. <strong>{{ $appointment->doctor->user->full_name }}</strong>,
        </p>
        <p style="color: #6b7280; margin: 0 0 24px; line-height: 1.6;">
            Un patient a réservé un créneau de consultation avec vous. Voici les détails du rendez-vous :
        </p>

        {{-- Recap card --}}
        <div style="background: #eff6ff; border-left: 4px solid #0077B6; border-radius: 8px; padding: 24px; margin: 0 0 24px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px; width: 40%;">Patient</td>
                    <td style="padding: 8px 0; color: #111827; font-weight: 600; font-size: 14px;">
                        {{ $appointment->patient->full_name }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px;">Téléphone</td>
                    <td style="padding: 8px 0; color: #111827; font-size: 14px;">{{ $appointment->patient->telephone ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px;">Date</td>
                    <td style="padding: 8px 0; color: #111827; font-weight: 600; font-size: 14px;">
                        {{ $appointment->date_rdv->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px;">Heure</td>
                    <td style="padding: 8px 0; color: #111827; font-weight: 600; font-size: 14px;">
                        {{ $appointment->heure_rdv }}
                    </td>
                </tr>
                @if($appointment->motif)
                <tr>
                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px;">Motif de visite</td>
                    <td style="padding: 8px 0; color: #111827; font-size: 14px;">{{ $appointment->motif }}</td>
                </tr>
                @endif
            </table>
        </div>

        <p style="color: #6b7280; font-size: 13px; line-height: 1.6; margin: 0 0 24px;">
            Veuillez vous connecter à votre tableau de bord médecin pour accepter ou refuser ce rendez-vous.
        </p>

        <a href="{{ config('app.url') }}/doctor/dashboard"
           style="display: inline-block; background: #0077B6; color: #fff; font-weight: 700; padding: 14px 28px; border-radius: 10px; text-decoration: none; font-size: 14px;">
            Accéder à mon tableau de bord
        </a>
    </div>

    {{-- Footer --}}
    <div style="background: #f9fafb; padding: 20px 40px; border-top: 1px solid #e5e7eb;">
        <p style="color: #9ca3af; font-size: 12px; margin: 0; text-align: center;">
            {{ config('app.name') }} — Système de Rendez-vous Médical
        </p>
    </div>
</div>
</body>
</html>
