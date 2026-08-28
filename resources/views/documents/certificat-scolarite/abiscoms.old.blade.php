<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificat de Scolarité - {{$user->name}}</title>
    <style type="text/css">
        body {
            padding: 15px 15px;
            /* La police est commentée, mais vous pouvez l'activer si nécessaire */
            /* font-family: Arial, sans-serif; */
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            font-size: 15px;
        }

        .full-width {
            width: 100%; /* Prend toute la largeur */
            text-align: center; /* Centre le texte */
            border-bottom: 1px dashed black; /* Soulignement en dashed */
            font-weight: bold
        }

        .dynamic_values{
            /*font-family: 'Lucida Console', serif;*/
            font-style: italic;
        }
        /* Ajout signatures comme abiscoms */
        .signature-block {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: -20px;
            position: relative; /* important pour contenir les images absolues */
        }
        .signature-block img {
            height: 150px;
            object-fit: contain;
            position: absolute;
            right: 0;
            transform: translateY(-80px);
        }
        .signature-block img + img { /* si plusieurs images */
            margin-left: -60px;
            bottom: -10px;
        }
    </style>
</head>
<body>

<!-- Filifranne -->
<div
    @if(file_exists(public_path("/public/profil/{$school->logo}")))
        style="background-image: url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}');
               background-repeat: no-repeat;
               background-position: center;
               background-size: 80%;
               opacity: 0.1;
               position: absolute;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               z-index: -1;"
    @endif
>
    <!-- Contenu de la page -->
</div>

@php $ecole = $school; // le fichier inclus plus bas en a besoin @endphp
<!-- Inlcusion des entetes de bulletin en fonction de l'établissement -->
@include('documents.create-documents.entetes.entete-bulletin-secondaire-abiscom')

<table style="text-align: center; width: 100%; margin: 10px 10px;">
    <tr>
        <td><strong style="text-align: center; font-size: 16pt; text-decoration: underline">SCHOOL ATTENDANCE / CERTIFICAT DE SCOLARITE  </strong></td>
    </tr>
</table>

<div style="padding: 10px 30px;font-size: 18px">
    <div style="justify-content: start; width: 100%; margin-top: 15px;">
        <div style="width: 100%; ">
            <div style="width: 35%; float: left;">
                <br>
                SCHOOL YEAR / ANNEE SCOLAIRE
            </div>
            <div class="full-width dynamic_values" style="width: 65%; margin-top:10px; margin-left: 35%; height: 20px;">
                {{ $academic_year }}
            </div>
        </div>
        <br>

        <div style="width: 100%; ">
            <div style="width: 28%; float: left;">
                <br>
                I the undersigned / Je soussigné
            </div>
            <div class="full-width dynamic_values" style="width: 71%; margin-top:10px; margin-left: 29%; height: 20px;">

            </div>
        </div>

{{--        <div style="width: 100%; height: 50px;">--}}
{{--            SCHOOL YEAR / ANNEE SCOLAIRE .........................................................................................................................--}}
{{--            <br> <br>--}}
{{--            I the undersigned / Je soussigné .......................................................................................................................................--}}
{{--        </div>--}}

        <br>

        <div style="width: 100%; margin-top: 10pt; margin-bottom: 10pt">
            <div style="width: 100%; text-align: center;">
                Principal of Akouma High School in Yaounde <br><br>
                Proviseur de Akouma High School à Yaoundé
            </div>
        </div>

        <div style="width: 100%; margin-top: 10pt; margin-bottom: 10pt">
            <div style="width: 100%;">
                Attest that the student: <br>
                Certifie que l'élève:
            </div>
            <div class="full-width dynamic_values" style="margin-top: 3pt">
                {{ $user->name }}
            </div>
        </div>

        <div style="width: 100%; margin-top: 10pt; margin-bottom: 10pt">
            <div style="width: 100%;">
                Born on: <br>
                Né (e) le:
            </div>
            <div class="full-width dynamic_values" style="margin-top: 3pt">
                @if(!is_null($user->birthday))
                    {{ $user->birthday->format("d M Y") }}
                @else
                    <span style="color: transparent">XX - YY - ZZZZ</span>
                @endif
            </div>
        </div>

        <div style="width: 100%; margin-top: 10pt; margin-bottom: 10pt">
            <div style="width: 100%;">
                Father's name: <br>
                Nom du père:
            </div>
            <div class="full-width dynamic_values" style="margin-top: 3pt">
                @if(!is_null($father))
                    {{ strtoupper($father) }}
                @else
                    <span style="color: transparent">NOM DU PERE ICI</span>
                @endif
            </div>
        </div>

        <div style="width: 100%; margin-top: 10pt; margin-bottom: 10pt">
            <div style="width: 100%;">
                Mother's name: <br>
                Nom de la mère:
            </div>
            <div class="full-width dynamic_values" style="margin-top: 3pt">
                @if(!is_null($mother))
                    {{ strtoupper($mother) }}
                @else
                    <span style="color: transparent">NOM DE LA MERE ICI</span>
                @endif
            </div>
        </div>

        <br>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 59%; float: left;">
                Was/is enreolled in my school A.H.S under registration number:
                <br>
                A été / ou est inscrit dans mon Etablissement A.H.S sous le numéro:
            </div>
            <div class="full-width dynamic_values" style="width: 41%; margin-top:10px; margin-left: 59%; height: 20px;">
                {{ $user->matricule }}
            </div>
        </div>

        <br>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 25%; float: left;">
                Attending/is attending class:
                <br>
                A suivi/suit la classe de:
            </div>
            <div class="full-width dynamic_values" style="width: 79%; margin-top:10px; margin-left: 21%; height: 20px;">
                {{ $user->classeName }}
            </div>
        </div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 100%; float: left;">
                This attestation is delivered to serve as testimony where necessary. <br>
                En foi de quoi le présent certificat est délivré pour servir et valoir ce que de droit.
            </div>
        </div>

        <div style="width: 60%; ">
            <div style="width: 10%; float: left;">
                <br>
                Date :
            </div>
            <div class="full-width dynamic_values" style="width: 65%; margin-top:10px; margin-left: 10%; height: 20px;">
                {{ date("d / m / Y", time()) }}
            </div>
        </div>

{{--        <div style="width: 100%; height: 50px;">--}}
{{--            Date : .....................................................................--}}
{{--        </div>--}}

        <div style="width: 100%; height: 50px; text-align: right; margin-right: -25pt">
            The Principal of A.H.S Yaounde <br><br>
            Le proviseur de A.H.S Yaoundé
        </div>
    </div>
</div>

<!-- Bloc signatures superposées à droite (même logique que abiscoms) -->
<div class="signature-block">
    @if(file_exists(public_path('public/profil/seal-signature-director.png')))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
    @endif
</div>

</body>
</html>
