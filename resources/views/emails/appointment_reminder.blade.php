<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de rendez-vous</title>
</head>
<body>
    <p>Bonjour {{ $patient->full_name }},</p>
    <p>Ceci est un rappel pour votre rendez-vous médical prévu :</p>
    <ul>
        <li>Docteur : Dr {{ $doctor->full_name }}</li>
        <li>Date : {{ $appointment->date_rdv->format('d/m/Y') }}</li>
        <li>Heure : {{ $appointment->heure_rdv }}</li>
        <li>Durée : {{ $appointment->duree }} minutes</li>
    </ul>
    <p>Si vous souhaitez annuler ou modifier ce rendez-vous, connectez-vous à votre espace patient.</p>
    <p>Merci,</p>
    <p>L’équipe du cabinet médical</p>
</body>
</html>
