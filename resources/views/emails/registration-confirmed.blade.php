<!DOCTYPE html>
<html>
<body>
    <h2>Bonjour {{ $registration->contact_name }} !</h2>
    <p>Votre inscription a bien été prise en compte.</p>
    <a href="{{ $cancelUrl }}" style="
    display: inline-block;
    padding: 10px 20px;
    background-color: #dc2626;
    color: white;
    text-decoration: none;
    border-radius: 8px;
">
    Annuler ma réservation
</a>

<p style="font-size: 12px; color: #6b7280;">
    Ce lien est sécurisé et unique à votre inscription.
</p>
    <p>À bientôt !</p>
</body>
</html>