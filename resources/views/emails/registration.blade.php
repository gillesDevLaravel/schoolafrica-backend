<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur notre plateforme !</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #0d6efd;
            text-align: center;
        }

        p {
            line-height: 1.5;
        }

        .btn {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Bienvenue sur notre plateforme !</h1>
    <p>Cher(e) utilisateur(trice),</p>
    <p><strong>{{ $school->name }}</strong> est ravie de vous accueillir sur sa plateforme. Vous trouverez ci-dessous vos identifiants de connexion :</p>
    <ul>
        <li><strong>Nom d'utilisateur</strong> : {{ $username }}</li>
        <li><strong>Mot de passe</strong> : {{ $password }}</li>
        <li><strong>Clé de connexion</strong> : {{ $key }}</li>
    </ul>

    <p><strong>Attention :</strong> Pour des raisons de sécurité, vous devez absolument changer votre mot de passe dès que possible.</p>

    <p>Pour vous connecter, allez à l'adresse <a href="{{ $loginUrl }}" target="_blank" rel="noopener">{{ $loginUrl }}</a> ; ou veuillez cliquer sur le lien suivant :</p>

    <a href="{{ $loginUrl }}" target="_blank" rel="noopener" class="btn" style="margin: 10px">Se connecter</a>
    <p>Si vous avez des questions ou des difficultés, n'hésitez pas à nous contacter.</p>
    <br><br>

    <table style="width: 100%">
        <tr>
            <td style="width: 60%">
                <table>
                    <tr>
                        <td style="width: 20%">
                            <img width="100px" src="{{ asset("public/profil/" . $school->logo) }}" alt="">
                        </td>
                        <td>
                            {{ $school->name }} <br>
                            {{ $school->phone }} <br>
                            {{ $school->email }} <br>
                            {{ $school->adresse }} <br>
                            <a href="https://{{ $school->website }}" target="_blank" rel="noopener">{{ $school->website }}</a> <br>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 40%">
                <table>
                    <tr>
                        <td style="width: 20%">
                            <img width="60px" src="https://app.ms-school.net/assets/images/log1.png" alt="Logo MS School">
                        </td>
                        <td style="width: 80%">
                            MS SCHOOL<br>
                            +33 7 48 16 81 88 / +237 6 91 77 36 80<br>
                            support@ms-school.net<br>
                            Rond poind Damas face maison Blue , Yaoundé <br>
                            <a href="https://ms-school.net" target="_blank" rel="noopener">ms-school.net</a> <br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
{{--    <p>Cordialement,</p>--}}
{{--    <p>L'équipe de {{ config('app.name') }}</p>--}}
</div>
</body>
</html>
