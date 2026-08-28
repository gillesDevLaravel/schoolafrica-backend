<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificat de Scolarité - {{$user->name}}</title>
    <style type="text/css">
        @page { size: A4; margin: 0; }

        body {
            padding: 10px 30px;
            margin: 0;
            min-height: 100vh;
            box-sizing: border-box;
            position: relative;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; text-indent: 0; }

        .full-width {
            width: 100%;
            text-align: center;
            border-bottom: 1px dashed black;
            font-weight: bold;
        }

        .header-table td {
            text-align: center;
            vertical-align: middle;
            width: 33%;
        }
        .header-table img {
            display: block;
            margin: 0 auto;
            max-height: 0;
        }

        .content-wrapper { padding-bottom: 100px; position: relative; }
        p { font-size: 18px; }

        .signature-block {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: 20px;
            position: absolute;
            bottom: 330px;
            right: 30px;
        }

        .signature-block img {
            height: 150px;
            object-fit: contain;
            display: inline-block;
            position: absolute;
            right: 0;
        }

        .signature-block img + img {
            margin-left: -60px;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 15px;
            line-height: 1.2em;
            color: white;
            background-color: coral;
        }
    </style>
</head>
<body>
<div class="content-wrapper">

    <!-- En-tête -->
    <table class="header-table" style="width:100%; border-collapse: collapse; margin-bottom: 20px; font-size:12px; line-height:1.2;">
        <tr>
            <td>
                <strong>MINISTÈRE DE L'ÉDUCATION DE BASE</strong><br>
                DÉLÉGATION RÉGIONALE DE L'ÉDUCATION<br>
                DE BASE DU CENTRE<br>
                INSPECTION D'ARRONDISSEMENT DE YAOUNDÉ IV
            </td>
            <td>
                @if(file_exists(public_path("/public/profil/{$school['logo']}")))
                    <img style="max-height: 80px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school['logo']}"))) }}">
                @endif
            </td>
            <td>
                RÉPUBLIQUE DU CAMEROUN<br>
                PAIX - TRAVAIL - PATRIE<br>
            </td>
        </tr>
    </table>

    <!-- Titre du certificat -->
    <div style="text-align:center; font-size:25px; margin-bottom:30px;">
        <strong>CERTIFICAT DE SCOLARITE <br> SCHOOL ATTENDANCE CERTIFICATE</strong>
    </div>

    <!-- Contenu du certificat -->
    <div style="padding:10px 30px; font-size:18px;">
        <div style="justify-content:start; width:100%; margin-top:15px;">
            Je soussigné <span style="color:white">......................................................................</span> DIRECTEUR DE <strong>GSB JUNIORS</strong>, <br>
            I, the undersigned, <span style="border-bottom:1px dashed #000; display:inline-block; width:42%; text-align:center;">
                <strong>{{ strtoupper($director->name ?? '') }}</strong>
            </span> DIRECTOR OF <strong>GSB JUNIORS</strong>,<br>

            <div style="width:100%; height:50px;">
                <div style="width:21%; float:left;">
                    certifie que, l'élève <br> certify that
                </div>
                <div class="full-width" style="width:87%; margin-top:20px; margin-left:13%; height:20px; text-align:center;">
                    <span style="margin-left:-13%;">{{ strtoupper($user->name) }}</span>
                </div>
            </div>

            Né(e) le : <div style="display:inline-block; width:47%"></div> à: <br>
            Born on <div class="full-width" style="display:inline-block; width:48%">
                @if(!is_null($user->birthday))
                    {{ $user->birthday->format("d M Y") }}
                @else
                    <span style="color:transparent">XX - YY - ZZZZ</span>
                @endif
            </div> at: <div class="full-width" style="display:inline-block; width:38%">{{ $user->placeofbirth ?? "" }}</div>

            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:17%; float:left;">Nom du père: <br> Father's Name:</div>
                <div class="full-width" style="width:83%; margin-top:20px; margin-left:17%; height:20px;">{{ strtoupper($father) }}</div>
            </div>

            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:18%; float:left;">Nom de la mère: <br> Mother's Name:</div>
                <div class="full-width" style="width:82%; margin-top:20px; margin-left:18%; height:20px;">{{ strtoupper($mother) }}</div>
            </div>

            est inscrit(e) dans cet établissement. Matricule :
            <div style="width:100%;">
                <div style="display:inline-flex; width:45%">is registered in this school with Reg. No:</div>
                <div class="full-width" style="display:inline-block; width:54%;">{{ $user->matricule }}</div>
            </div>

            Classe :
            <div style="width:100%;">
                <div style="display:inline-flex; width:10%;">in class :</div>
                <div class="full-width" style="display:inline-block; width:89%;">{{ $user->classeName }}</div>
            </div>

            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:28%; float:left;">pour l'année académique:  <br> for the academic year:</div>
                <div class="full-width" style="width:76%; margin-top:20px; margin-left:24%;">{{ $academic_year }}</div>
            </div>

            <br><br><br>
            Le présent certificat est délivré pour servir et valoir ce que de droit. <br>
            This certificate is issued to serve the bearer wherever need be.
            <br><br><br>

            Fait à : <div style="display:inline-block; width:48%"></div> le: <br>
            Done at<div class="full-width" style="display:inline-block; width:48%">YAOUNDE</div> the: <div class="full-width" style="display:inline-block; width:37%">
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </div>

            <br><br><br>

            <div style="text-align:center">Le Directeur / The Director</div>

            <!-- Bloc signatures superposées à droite -->
            <div class="signature-block">
                {{--                @if(file_exists(public_path('public/profil/seal-director.png')))--}}
                {{--                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-director.png'))) }}" alt="Cachet">--}}
                {{--                @endif--}}
                @if(file_exists(public_path('public/profil/seal-signature-director.png')))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
                @endif
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    ARRETE N°036/12/4996/A/MINEDUB/SG/DSEPB du 02 Mai 2013 et ARRETE N°067/11/7/A/MINEDUB/SG/DSEPB du 25 Juin 2015<br>
    Situé à Yaoundé - Quartier Odza, 200 m à partir de l'entrée bitumée face Immeuble Happi.<br>
    BP: 32051 - YAOUNDE Tel: (237) 222 30 00 34 / 695 95 37 95 / 672 84 47 02<br>
    Email: info@gsbjuniors.com - Site web: www.gsbjuniors.com
</div>

</body>
</html>
