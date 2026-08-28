<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement initié</title>
</head>
<body>
    <p>Un paiement a été initié avec les détails ci-dessous:</p>

    <p>
        <strong>Ecole: </strong>{!! $school !!}<br>
        <strong>Eleve: </strong>{!! $student !!}<br>
        <strong>Classe: </strong>{!! $classe !!}<br>
        <strong>Numéro: </strong>{{ $number }}<br>
        <strong>Montant: </strong>{{ number_format($amount) }}XAF<br>
        <strong>idTransaction: </strong>{{ $idTransaction }}<br>

    </p>

    <p>
        Cordialement,<br>
        L'équipe {{ config('app.name') }}
    </p>
</body>
</html>
