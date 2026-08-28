<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur ms-school</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.6;
            padding: 20px;
        }

        .header {
            background-color: #0a92d6;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            border: 1px solid #0a92d6;
            border-top: none;
            border-radius: 0 0 10px 10px;
            padding: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        .credentials {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #0a92d6;
        }

        .credentials p {
            margin: 5px 0;
            font-weight: bold;
        }

        a {
            color: #0a92d6;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Bienvenue sur ms-school</h1>
    <p>Welcome to ms-school</p>
</div>

<div class="content">

    <div class="section">
        <p><strong>Bonjour M./Mme {{ $name }},</strong></p>
        <p>Nous sommes l’entreprise <strong>MS-School</strong>, partenaire de <strong>{{ $schoolname }}</strong> dans la numérisation avec le logiciel <strong>ms-school</strong>.</p>

        <p>Vous pouvez avoir accès aux informations de vos enfants :</p>
        <ul>
            <li>Sur un ordinateur : <a href="https://app.ms-school.net">app.ms-school.net</a></li>
            <li>Application Android : <a href="https://play.google.com/store/apps/details?id=com.mschool.school">Play Store</a></li>
            <li>Application iPhone : <a href="https://apps.apple.com/cm/app/ms-school/id6463662566">App Store</a></li>
        </ul>

        <p>Ensuite, connectez-vous à l’aide des identifiants suivants :</p>

        <div class="credentials">
            <p>🔑 Clé : {{ $cle }}</p>
            <p>👤 Username : {{ $username }}</p>
            <p>🔐 Mot de passe : {{ $password }}</p>
        </div>
    </div>

    <hr>

    <div class="section">
        <p><strong>Hello Mr./Mrs. {{ $name }},</strong></p>
        <p><strong>We are MS-School</strong>, a partner of <strong>{{ $schoolname }}</strong> in the digitization process using the <strong>ms-school</strong> software.</p>

        <p>You can access your children's information:</p>
        <ul>
            <li>On a computer: <a href="https://app.ms-school.net">app.ms-school.net</a></li>
            <li>Android App: <a href="https://play.google.com/store/apps/details?id=com.mschool.school">Play Store</a></li>
            <li>iPhone App: <a href="https://apps.apple.com/cm/app/ms-school/id6463662566">App Store</a></li>
        </ul>

        <p>Then, log in using the following credentials:</p>

        <div class="credentials">
            <p>🔑 Key: {{ $cle }}</p>
            <p>👤 Username: {{ $username }}</p>
            <p>🔐 Password: {{ $password }}</p>
        </div>
    </div>

</div>

<div class="footer">
    &copy; {{ date('Y') }} MS-School. Tous droits réservés.
</div>

</body>
</html>
