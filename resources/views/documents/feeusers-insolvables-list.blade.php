<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            font-family: 'Calibri', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }

        .image-block img {
            width: 60%;
            height: auto;
            margin-right: 10px;
        }

        p {
            font-size: 18px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        /* Retirer la bordure des autres tableaux */
        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
        }

        /* Ajout des styles de séparation uniquement pour le dernier tableau */
        #listStudents th, #listStudents td {
            border-right: 1px solid rgba(0, 0, 0, 0.1); /* Très opaque */
        }

        /* Assurez-vous que les titres "Apprenant" et autres soient alignés à gauche */
        th {
            text-align: left;
        }

        /* Aligner spécifiquement les titres "Versé" et "Reste" à droite */
        th.amount, td.amount {
            text-align: right;
        }

        td {
            text-align: left;
        }
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr>
        <td style="text-align: center; width: 40%;font-size: 13px">
            <strong>REPUBLIQUE DU CAMEROUN</strong> <br> <br>
            <span style="font-size: 12px">paix-travail-patrie</span> <br>
            <span style="font-size: 12px">*******</span> <br>

            <span style="font-size: 12px">Ministère de l'Education de Base</span> <br>
            <span style="font-size: 12px">Région du Centre</span> <br>
            <span style="font-size: 12px">Département du Mfoundi</span> <br>
        </td>

        <td style="width:70%; text-align:center;">
            <img style="width:40%; margin-right:10px;margin-top:-10px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school->logo"))) }}">
        </td>

        <td style="text-align: center; width: 40%;font-size: 13px">
            <strong>REPUBLIC OF CAMEROON</strong> <br> <br>
            <span style="font-size: 12px">peace-work-fatherland</span> <br>
            <span style="font-size: 12px">*******</span> <br>

            <span style="font-size: 12px">Ministry of basic education</span> <br>
            <span style="font-size: 12px">Center Region</span> <br>
            <span style="font-size: 12px">Mfoundi Division</span> <br>
        </td>
    </tr>
</table><br>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="text-align: center; font-size:16px; color: #0a92d6; ">
            <strong>{{ strtoupper($school->name) }}</strong> <br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; background-color: #0a92d6">
    <tr>
        <td style="text-align: center; font-size:20px; color: white">
            <strong>Liste des {{ $title ."-". $fee->name}}</strong>
        </td>
    </tr>
</table>

<!-- Dernier tableau avec séparation des colonnes -->
<table id="listStudents" style="margin-top: 20px; width: 100%" cellspacing="0">
    <tr style="width: 100%;background-color: #0a92d6; color: white">
        <td style="width: 10pt;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>Nº</strong></p>
        </td>
        <td style="width: 175pt; padding-left: 5px; text-align: left;">
            <p class="s2" style="padding-top: 4pt; padding-right: 2pt; text-indent: 0pt; font-size: 12px"><strong>Apprenant</strong></p>
        </td>
        <td style="width:50pt; padding-left:5px; text-align: right;" class="amount">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt;font-size: 12px"><strong>Versé</strong></p>
        </td>

        @if ($title == "insolvables")
            <td style="width:25pt; padding-left:5px; text-align: right;" class="amount">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt;font-size: 12px; padding-right: 2px;"><strong>Reste</strong></p>
            </td>
        @endif
    </tr>

    @php $cpt = 1; @endphp
    @foreach($students as $key => $student)
        <tr @if($key % 2 == 0) style="background-color: rgba(246,243,243,0.82);" @endif>
            <td style="width: 10pt;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 11px;">{{ $cpt }}</p>
            </td>
            <td style="width: 10pt;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 11px;">{{ $student['name'] }}</p>
            </td>
            <td style="width: 10pt;" class="amount">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 11px;">{{ number_format($student['totalDejaPaye']) }}</p>
            </td>

            @if($title == "insolvables")
                <td style="width: 10pt;" class="amount">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 11px;">{{ number_format($student['resteAPayer']) }}</p>
                </td>
            @endif
        </tr>
        @php $cpt++; @endphp
    @endforeach
</table>

</body>
</html>
