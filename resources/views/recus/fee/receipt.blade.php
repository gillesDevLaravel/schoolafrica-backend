<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reçu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
        background-color: #2ca0f0;
        color: #fff;
        padding: 10px 20px;
    }

    .header h2 {
        margin: 0;
    }

    .container {
      display: flex;
      margin-top: 15px;
    }

    .info {
      flex: 1;
    }    

    .image-block {
      padding: 10px;
    text-align: center;
    width: 50%;
    height: auto;
    margin-left: 50%;
    margin-top: -190px;
    }

    .container div {
        /* border: 1px solid; */
        padding: 10px;
    }

    .image-block img {
        max-width: 100%;
        height: 200px;
    }

    .invoice {
        clear: both;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-top: 5px;
    }

    .invoice th,
    .invoice td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    .invoice th {
        background-color: #2ca0f0;
        color: #fff;
        text-align: left;
    }

    .totals {
        padding: 20px;
        color: #000000;
        text-align: right;
    }

    .header-right {
        text-align: right;
        margin: 0;
    }

  </style>
</head>
<body>
  <div class="header">
    <h2>{{ $school }}</h2>
    <h2 class="header-right">Reçu</h2>
  </div>
  <div class="container">
    <div class="info">
      <p><strong>Date:</strong> {{ $date }}</p>
      <p><strong>Élève:</strong> {{ $student }}</p>
      <p><strong>Matricule:</strong> {{ $matricule }}</p>
      <p><strong>Classe:</strong> {{ $classroom }}</p>
    </div>
    <div class="image-block">
      <img src="{{ asset($imagePath) }}" alt="Image">
    </div>
  </div>
  <table class="invoice">
    <thead>
      <tr>
        <th>Fee</th>
        <th>Date limit</th>
        <th>Mode de paiement</th>
        <th>Prix</th>
        <th>Montant</th>
        <th>Reste</th>
      </tr>
    </thead>
    <tbody>
      @foreach($feeDetails as $detail)
      <tr>
        <td>{{ $detail['fee'] }}</td>
        <td>{{ $detail['date_limit'] }}</td>
        <td>{{ $detail['payment_mode'] }}</td>
        <td>{{ $detail['price'] }}</td>
        <td>{{ $detail['amount'] }}</td>
        <td>{{ $detail['reste'] }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="totals">
    <p><strong>Prix Total:</strong> {{ $total_boarding }}</p>
    <p><strong>Montant Total Versé:</strong> {{ $total_paid }}</p>
    <p><strong>Reste:</strong> {{ $reste }}</p>
  </div>
</body>
</html>
