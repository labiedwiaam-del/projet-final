<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de rendez-vous</title>
</head>
<body>
    <p>Bonjour {{ $patient->full_name }},</p>
    <p>Votre rendez-vous médical a été confirmé :</p>
    <ul>
        <li>Docteur : Dr {{ $doctor->full_name }}</li>
        <li>Date : {{ $appointment->date_rdv->format('d/m/Y') }}</li>
        <li>Heure : {{ $appointment->heure_rdv }}</li>
        <li>Durée : {{ $appointment->duree }} minutes</li>
    </ul>
    <p>Si vous souhaitez annuler ce rendez-vous, connectez-vous à votre espace patient.</p>
    <p>Merci,</p>
    <p>L'équipe du cabinet médical</p>
</body>
</html>
