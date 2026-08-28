{{--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">--}}
{{--<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">--}}
{{--<head>--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>--}}
{{--    <title>Certificat de Scolarité - {{$user->name}}</title>--}}
{{--    <style type="text/css">--}}
{{--        body {--}}
{{--            padding: 10px 30px;--}}
{{--        }--}}
{{--        .td-table{--}}
{{--            width: 124pt;--}}
{{--            border-top-style: solid;--}}
{{--            border-top-width: 1pt;--}}
{{--            border-top-color: #808080;--}}
{{--            border-left-style: solid;--}}
{{--            border-left-width: 1pt;--}}
{{--            border-left-color: #808080;--}}
{{--            border-bottom-style: solid;--}}
{{--            border-bottom-width: 1pt;--}}
{{--            border-bottom-color: #808080;--}}
{{--            border-right-style: solid;--}}
{{--            border-right-width: 1pt;--}}
{{--            border-right-color: #808080;--}}
{{--        }--}}

{{--        * {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            text-indent: 0;--}}
{{--        }--}}


{{--        .my-table {--}}
{{--            border-collapse: collapse;--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .table-header, .table-cell {--}}
{{--            border: 1px solid black;--}}
{{--            padding: 8px;--}}
{{--            text-align: left;--}}
{{--        }--}}

{{--        .table-header {--}}
{{--            background-color: #f2f2f2;--}}
{{--        }--}}


{{--        table,--}}
{{--        tbody {--}}
{{--            vertical-align: top;--}}
{{--            overflow: visible;--}}
{{--        }--}}

{{--        .image-block {--}}
{{--            text-align: right--}}
{{--        }--}}

{{--        .image-block img {--}}
{{--            width: 60%;--}}
{{--            height: auto;--}}
{{--            margin-right: 10px;--}}
{{--            /*margin-top: -20px;*/--}}
{{--        }--}}
{{--        p{--}}
{{--            font-size: 18px;--}}
{{--        }--}}
{{--        .dashed-line {--}}
{{--            border: none;--}}
{{--            border-bottom: 2px dashed #000; /* Couleur et style de la ligne */--}}
{{--            height: 1px;--}}
{{--            margin-top: 200px;--}}
{{--        }--}}

{{--        .dashed-info {--}}
{{--            text-decoration: none;--}}
{{--            border-bottom: 1px dashed black;--}}
{{--            display: inline--}}
{{--        }--}}

{{--        .full-width {--}}
{{--            width: 100%; /* Prend toute la largeur */--}}
{{--            text-align: center; /* Centre le texte */--}}
{{--            border-bottom: 1px dashed black; /* Soulignement en dashed */--}}
{{--            font-weight: bold--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div style="text-align: center; font-size: 25px; margin-top: 150px; margin-bottom: 30px;">--}}
{{--    <strong>--}}
{{--        SCHOOL ATTENDANCE CERTIFICATE <br> CERTIFICAT DE SCOLARITE--}}
{{--    </strong>--}}
{{--</div>--}}

{{--<div style="padding: 10px 30px;font-size: 18px">--}}
{{--   

{{--       <div style="width: 100%; height: 50px;">--}}
{{--            <div style="width: 21%; float: left;">--}}
{{--                The pupil  <br> L’élève--}}
{{--            </div>--}}
{{--            <div class="full-width" style="width: 87%; margin-top:20px; margin-left: 13%; height: 20px; text-align: center;">--}}
{{--                <span style="margin-left: -13%;">{{ strtoupper($user->name) }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--       Born on : <div class="" style="display:inline-block; width: 47%"><strong></strong></div> at: <br>--}}
{{--        Né (e) le  <div class="full-width" style="display:inline-block; width: 48%">--}}
{{--            @if(!is_null($user->birthday))--}}
{{--                {{ $user->birthday->format("d M Y") }}--}}
{{--            @else--}}
{{--                <span style="color: transparent">XX - YY - ZZZZ</span>--}}
{{--            @endif--}}
{{--        </div> à: <div class="full-width" style="display:inline-block; width: 38%">{{ $user->placeofbirth ?? "" }}</div>--}}

{{--        <div style="width: 100%; display:inline-flex; height: 50px;">--}}
{{--            <div style="width: 17%; float: left;">--}}
{{--                Nom du père: <br> Father's Name:--}}
{{--            </div>--}}
{{--            <div class="full-width" style="width: 83%; margin-top:20px; margin-left: 17%; height: 20px;">--}}
{{--                {{ strtoupper($father) }}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div style="width: 100%; display:inline-flex; height: 50px;">--}}
{{--            <div style="width: 18%; float: left;">--}}
{{--                Nom de la mère: <br> Mother's Name:--}}
{{--            </div>--}}
{{--            <div class="full-width" style="width: 82%; margin-top:20px; margin-left: 18%; height: 20px;">--}}
{{--                {{ strtoupper($mother) }}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        is currently attending school in the above establishment for 
            est élève dans notre établissement pour. Matricule :--}}
{{--        <div style="width: 100%;">--}}
{{--            <div style="display: inline-flex; width: 45%">is registered in this schoool with Reg. No:</div>--}}
{{--            <div class="full-width" style="display: inline-block; width: 54%;">{{ $user->matricule }}</div>--}}
{{--        </div>--}}

{{--        Classe :--}}
{{--        <div style="width: 100%;">--}}
{{--            <div style="display: inline-flex; width: 10%;">in class :</div>--}}
{{--            <div class="full-width" style="display: inline-block; width: 89%;">{{ $user->classeName }}</div>--}}
{{--        </div>--}}

{{--        <div style="width: 100%; display:inline-flex; height: 50px;">--}}
{{--            <div style="width: 28%; float: left;">--}}
{{--                pour l'année académique:  <br> for the academic year:--}}
{{--            </div>--}}
{{--            <div class="full-width" style="width: 76%; margin-top:20px; margin-left: 24%;">{{ $academic_year }}</div>--}}
{{--        </div>--}}

{{--        <br><br><br>--}}
{{--        <br><br><br>--}}

{{--        Fait à : <div class="" style="display:inline-block; width: 48%"><strong></strong></div> le: <br>--}}
{{--        Done at<div class="full-width" style="display:inline-block; width: 48%">YAOUNDE</div> the: <div class="full-width" style="display:inline-block; width: 37%"></div>--}}

{{--        <br><br><br>--}}

{{--        <div style="text-align: center">--}}
{{--            Le Directeur / The Director--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}


{{--</body>--}}
{{--</html>--}}





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
    margin-top: 10px;
    position: relative; /* important pour contenir les images absolues */
}
.school-name {

            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-top: 5px;
            text-decoration: underline
          }

.signature-block img {
    height: 150px;
    object-fit: contain;
    position: absolute;
    right: 0;
    transform: translateY(10px); /* ← décale vers le bas */
}


.signature-block img + img {
    margin-left: -60px;
    bottom: -10px; /* si plusieurs images à chevaucher et décaler différemment */
}


        .contact-line {
            text-align: center;
            font-size: 17px;
            margin-bottom: 8px;
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
                <strong>REPUBLIQUE DU CAMEROUN</strong><br>
                Paix – Travail – Patrie<br>
                ……………………<br>
               MINISTÈRE DE L’EDUCATION DE BASE<br>
                ……………………<br>
                Délégation Régionale du Centre<br>
                ……………………<br>
                Délégation Départementale du Mfoundi<br>
                ……………………<br>
                Arrondissement de YDE 6
            </td>
            <td>
                @if(file_exists(public_path("/public/profil/{$school['logo']}")))
                    <img style="max-height: 140px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school['logo']}"))) }}">
                @endif
            </td>
            <td>
                 <strong>REPUBLIC OF CAMEROON</strong><br>
                Peace – Work – Fatherland<br>
                ………………………<br>
                <strong>MINISTRY OF BASIC EDUCATION</strong><br>
                ……………………<br>
                Regional Delegation of the Center<br>
                ……………………<br>
                Divisional Delegation of Mfoundi<br>
                ……………………<br>
                District of YDE 6
            </td>
        </tr>
    </table>
     <!-- NOM ÉCOLE -->
     <br>
    <div class="school-name">AKOUMA BILINGUAL SCHOOL COMPLEX “ABISCOM”</div>
    <br>
    <div class="contact-line"><strong>SIMBOCK – Yaoundé: 676 59 02 71</strong></div>
    <br>
    <!-- Titre du certificat -->
    <div style="text-align:center; font-size:25px; margin-bottom:30px;">
        <strong> SCHOOL ATTENDANCE CERTIFICATE <br>CERTIFICAT DE SCOLARITE</strong>
    </div>
        <p style="text-align:center; font-size:14px;">
            The head mistress of “<strong>ABISCOM</strong>” certify that<br>
            La directrice de “<strong>ABISCOM</strong>” certifie que :
        </p>
<br>
    <!-- Contenu du certificat -->
    <div style="padding:10px 30px; font-size:18px;">
        

            <div style="width:100%; height:50px;">
                <div style="width:21%; float:left;">
                    The pupil <br> L’élève
                </div>
                <div class="full-width" style="width:87%; margin-top:20px; margin-left:13%; height:20px; text-align:center;">
                    <span style="margin-left:-13%;">{{ strtoupper($user->name) }}</span>
                </div>
            </div>
            <div style="width:100%; height:50px;">
                <div style="width:21%; float:left;">
                    Reg N° <br> Mat.
                </div>
                <div class="full-width" style="width:87%; margin-top:20px; margin-left:13%; height:20px; text-align:center;">
                    <span style="margin-left:-13%;">{{ $user->matricule }}</span>
                </div>
            </div>


            Born on: <div style="display:inline-block; width:47%"></div> à: <br>
            Né(e) le <div class="full-width" style="display:inline-block; width:48%">
                @if(!is_null($user->birthday))
                    {{ $user->birthday->format("d M Y") }}
                @else
                    <span style="color:transparent">XX - YY - ZZZZ</span>
                @endif
            </div> at: <div class="full-width" style="display:inline-block; width:38%">{{ $user->placeofbirth ?? "" }}</div>


            <div style="width:100%; display:inline-block; height:50px; padding-top:10px;">
                <div style="width:17%; float:left;"> Father's Name:<br> Nom du père:</div>
                <div class="full-width" style="width:82%; margin-top:20px; margin-left:18%; height:20px;">{{ strtoupper($father) }}</div>
            </div>



            <div style="width:100%; display:inline-block; height:50px; padding-top:3px;">
                <div style="width:18%; float:left;">Mother's Name: <br> Nom de la mère:</div>
                <div class="full-width" style="width:82%; margin-top:20px; margin-left:18%; height:20px;">{{ strtoupper($mother) }}</div>
            </div>

            is currently attending school in the above establishment for <br> 
            est élève dans notre établissement pour<br>

            in class :
            <div style="width:100%; padding-top:5px;">
                <div style="display:inline-flex; width:10%;">Classe :</div>
                <div class="full-width" style="display:inline-block; width:89%;">{{ $user->classeName }}</div>
            </div>
            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:28%; float:left;"><br> The academic year: <br>L’année Scolaire</div>
                <div class="full-width" style="width:76%; margin-top:20px; margin-left:24%;">{{ $academic_year }}</div>
            </div>
          <br>
            <div style="margin-top: 30px; text-align: right; margin-right: 10px;">
        Yaounde, the / Yaoundé, le :
        <span style="display:inline-block; width: 120px; border-bottom:1px dotted #000; text-align:center; font-weight: bold; font-style: italic;">
            {{ \Carbon\Carbon::parse($date_issue ?? now())->format('d / m / Y') }}
        </span>
        <br/><br/>
        <strong>The Head Teacher</strong>
      </div>

            <!-- Bloc signatures superposées à droite -->
            <div class="signature-block">
                @if(file_exists(public_path('public/profil/seal-signature-director.png')))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
                @endif
            </div> 
            <!-- mettre le filigrane ici -->
           @if (file_exists(public_path("public/profil/{$school['logo']}")))
    <div style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70%;
        height: 70%;
        background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path("public/profil/{$school['logo']}"))) }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.08;
        z-index: -1;
        pointer-events: none;
    "></div>
@endif


        </div>
    </div>
</div>

</body>
</html>

