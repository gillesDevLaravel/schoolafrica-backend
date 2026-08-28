<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code confirmation demande retrait</title>
</head>
<body>
    <p>Bonjour,</p>

    <p>Une nouvelle demande de remboursement a été crée avec les détails ci-dessous:</p>

    <p>
        <strong>Montant du remboursement :</strong>{{ $montant }}<br>
        <strong>Mode de retrait souhaité :</strong>{{ $mode_retrait }}<br>
        <strong>RIB :</strong>{{ $rib }}<br>
        <strong>Numéro de retrait :</strong>{{ $numero }}<br>
        <strong>Date de la transaction :</strong>{{ $date }}<br>
        <strong>Nom du demandeur :</strong>{{ $nom }}<br>
        <strong>Nom de l'école / établissement :</strong>{{ $etablissement }}<br>
        
    </p>

    <p>
        La demande doit être confirmé avec le code : <b>{{ $code }}</b>.
    </p>

    <p>
        Cordialement,<br>
        L'équipe {{ config('app.name') }}
    </p>
</body>
</html>
