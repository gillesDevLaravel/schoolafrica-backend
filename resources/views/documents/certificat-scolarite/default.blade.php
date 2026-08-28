<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificat de Scolarité - {{$user->name}}</title>
    <style type="text/css">
        /*body {*/
        /*    padding: 10px 30px;*/
        /*}*/
        .td-table{
            width: 124pt;
            border-top-style: solid;
            border-top-width: 1pt;
            border-top-color: #808080;
            border-left-style: solid;
            border-left-width: 1pt;
            border-left-color: #808080;
            border-bottom-style: solid;
            border-bottom-width: 1pt;
            border-bottom-color: #808080;
            border-right-style: solid;
            border-right-width: 1pt;
            border-right-color: #808080;
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }


        .my-table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-header, .table-cell {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .table-header {
            background-color: #f2f2f2;
        }


        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }

        .image-block {
            text-align: right
        }

        .image-block img {
            width: 60%;
            height: auto;
            margin-right: 10px;
            /*margin-top: -20px;*/
        }
        p{
            font-size: 18px;
        }

        .background {
            position: relative;
            /*width: 100%;*/
            height: 100vh;
        }

        .background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60%;
            background-image: url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 80%;
            opacity: 0.1; /* Ajuste l'opacité ici */
            z-index: -1;
        } 

        .full-width {
            width: 100%;
            text-align: center;
            border-bottom: 1px dashed black;
            font-weight: bold;
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
               .footer {


            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 10px;
            line-height: 1.2em;

        }
    </style>
</head>
<body>
<br><br>
    <table style="width: 100%;">
        <tr style="">
            <td style="text-align: center; width: 35%; font-size: 11px;">
                REPUBLIQUE DU CAMEROUN <br>
                paix-travail-patrie <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES<br>
                DÉLÉGATION RÉGIONALE DU LITTORAL <br>
                DÉLÉGATION DÉPARTEMENTALE DU WOURI
            </td>

            <td style="width: 30%; height: 50px; text-align: center">
                <img style="width: 170px; height: 120px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
            </td>
            <td style="text-align: center; width: 35%; font-size: 11px;">
                REPUBLIC OF CAMEROON <br>
                peace-work-fatherland <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                MINISTRY OF SECONDARY EDUCATION<br>
                REGIONAL DELEGATION OF LITTORAL<br>
                DIVISIONAL DELEGATION OF WOURI
            </td>
        </tr>
    </table><br>

    <table style="text-align: center;  width: 100%; margin-bottom: 8px">
        <tr>
            <td style="text-align: center;
            @if(strlen($school->name) < 38) font-size:30px;
            @elseif(strlen($school->name) < 45) font-size:30px;
            @elseif(strlen($school->name) < 50) font-size:29px;
            @else font-size:24px @endif;
            color:#{{ $couleurs[0] }} ; ">
                <strong>{{ $school->name }}</strong>
            </td>
        </tr>
    </table>

    <table style="text-align: center;  width: 100%; margin-top: 25px">
        <tr>
            <td style="text-align: center; font-size:20px; color:#{{ $couleurs[0] }}; font-weight:bold;">
                <strong>*** CERTIFICAT DE SCOLARITE / SCHOOL CERTIFICATE ***</strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-size:17px; color:#{{ $couleurs[0] }} ; "><strong>{{ __('document_certificat_scolarite.school_year') }}: {{ $academic_year }}</strong></td>
        </tr>

    </table>

    <div class="background" style="padding:10px 30px;">
        <div style="float: right; width: 20%; text-align: right; height: 90px; margin-top: 15px;">
            @php
                $photoPath = public_path("/public/profil/".$user->photo);
                $photoData = file_exists($photoPath) ? image_data_uri($photoPath) : image_data_uri(public_path("/public/profil/user.jpg"));
            @endphp
            <img src="{{ $photoData }}" alt="" style="width:100%; height: 100%">
        </div>
       
        <div style="justify-content: start; width: 100%; margin-top: 15px;">
            <div style="width: 100%; height: 400px;">
                Je soussigné/the undersigned, <strong></strong> <br><br>
                <i>certifie que l'élève/certify that the student</i>: <strong>{{ $user->name }}</strong><br><br>

                <i>Né(e) le/Born on</i>:
                @if(!is_null($user->birthday))
                    <strong>{{ $user->birthday->format("d M Y") }}</strong>
                @else
                    <strong style="color: transparent">XX - YY - ZZZZ</strong>
                @endif
                <i>à/at :</i> <strong>{{ $user->placeofbirth }}</strong> <br><br>

            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:30%; float:left;"><i>Nom du père/Father's Name:</i></div>
                <div class="full-width" style="width:70%; margin-top:4px; margin-left:25%; ">{{ strtoupper($father) }}</div>
            </div>
            

            <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:30%; float:left;"><i>Nom de la mère/Mother's Name:</i></div>
                <div class="full-width" style="width:70%; margin-top:4px; margin-left:28%; ">{{ strtoupper($mother) }}</div>
            </div>
            <br>
                <i>Matricule/Registration N°</i>: <strong>{{ $user->matricule }}</strong> <br>
                est inscrit(e) dans mon établissement/is register in my school <br><br>
               
            <div style="width:100%; padding-top:5px;">
                <div style="display:inline-flex; width:10%;"> <i>Classe/Class:</i></div>
                <div class="full-width" style="display:inline-block; width:89%;">{{ $user->classeName }}</div>
            </div>
               <div style="width:100%; display:inline-flex; height:50px;">
                <div style="width:28%; float:left;"><br>  <i>Année Académique/Academic year:</i></div>
                <div class="full-width" style="width:76%; margin-top:20px; margin-left:24%;">{{ $academic_year }}</div>
            </div>

            
               
            <div style="width:100%; padding-top:5px;">
                <div style="width:10%;"><i></i></div>
                <div style="width:89%;"></div>
            </div>
               <div style="width:100%; height:50px;">
                <div style="width:28%; float:left;"> <br> <i></i></div>
                <div style="width:76%; margin-top:20px; margin-left:24%;"></div>
            </div>
            </div>
        </div>

        <div style="margin-top: 45px; width: 100%">
            Le présent certificat est délivré pour servir et valoir ce que de droit/this certificate is esthablished for him to serve and be worth what it is entited to.
        </div>
        

        <div style="width: 70%; margin-left: 100px; margin-top: 23px">
            <i>Fait à/Done at</i> : <strong>Yaoundé</strong> <i>le/on</i> <strong> {{ date("d M Y", time()) }}</strong>
        </div>

        <div style="width: 100%; text-align: right; margin-top: 100px;">
            <strong style="margin-right: 200px;">Le Directeur/The Director</strong>
        </div>

        <!-- Bloc signatures superposées à droite (même logique que abiscoms) -->
        <div class="signature-block">
            @if(file_exists(public_path('public/profil/seal-signature-director.png')))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
            @endif
        </div>
    </div>

    <div class="footer" style="margin-top: 81px; font-size: 12px; height: 64px; background-color:#{{ $couleurs[0] }} ; color: white; border: 1px solid #{{ $couleurs[0] }}">
        <div style="width: 500px; float: right; padding-right: 40px; padding-top: 7px;">
            <div style="float: left; padding-top: 10px;; margin-right: 50px; text-align: center">
                Siège social: {{ $school->adresse }} | Contacts: {{ $school->phone }} / {{ $school->phone }}<br>
                email: {{ $school->email }} | site web : {{ $school->website }}
            </div>

            <div style="width: 50px; float: right;">
                <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}" alt="" style=" width:50px; height: 50px; border-radius: 30px">
            </div>
        </div>
    </div>
</body>
</html>
