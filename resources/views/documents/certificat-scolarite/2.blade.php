<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Carte Scolaire {{ $nom }}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
        }
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

<table style="width: 100%; font-size: 11px">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIQUE DU CAMEROUN <br>
                paix-travail-patrie <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                Ministere de l'education de Base <br>
                Region du Centre <br>
                Departement du Mfoundi
            </strong>
        </td>

        <td style="width: 70%; text-align: center;">
            <img style="width: 50%; margin-right: 10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
        </td>
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIC OF CAMEROON <br>
                peace-work-fatherland <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                Ministry of basic <br> education <br>
                Center Region<br>
                Mfoundi Division
            </strong>
        </td>
    </tr>
</table><br>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="text-align: center; font-size:16px; color:green; "><strong>GROUPE SCOLAIRE BILINGUE JUNIORS</strong></td>
    </tr>

</table>
<table style="text-align: center;  width: 100%; margin-top: 25px">
    <tr>
        <td style="text-align: center; font-size:30px; color:green; FONT-WEIGHT:BOLD; "><strong>*** SCHOOL CERTIFICATE ***</strong></td>
    </tr>
    <tr>
        <td style="text-align: center; font-size:17px; color:green; "><strong>SCHOOL YEAR: 2023/2024</strong></td>
    </tr>

</table>
<hr>
<div>
    <br><br><br><br>
    <p>I, the undersigned__________________________</p><br>
    <p> Director of GOUPE SCOLAIRE BILINGUE JUNIORS,<br>
        certify that the student:
    </p><br>
    <div style="display:flex; justify-content:center; align-items:center;">
        <div style="float: left;margin-right:15px; ">
            @php
                $photoPath = public_path("/public/profil/$photo");
                $photoData = file_exists($photoPath) ? image_data_uri($photoPath) : image_data_uri(public_path("/public/profil/user.jpg"));
            @endphp
            <img src="{{ $photoData }}" alt="" style="width:150px; margin-top:10px;">
        </div>
        <div style="font-size:19px;">
            <span style="font-weight: bold">{{"BAKONE TAPTOUSIA FITZGERALD BLESSING"}}</span><br>
            <span>N Registration:<span style="font-weight: bold"> {{"874J020"}}</span></span><br>
            <span>Sex:<span style="font-weight: bold"> {{"M"}}</span></span><br>
            <span>Date of Birth : <span style="font-weight: bold">{{"05 AUGUST 2015"}},</span></span><br>
            <span>Place of Birth: <span style="font-weight: bold">{{"BAFOUSSAM"}}</span></span><br>
            <span>Country:<span style="font-weight: bold"> {{"Cameroun"}}</span></span><br>
            <span style="margin-left: 0px">Father: <span style="font-weight: bold">{{"TAPTOUSIA"}}</span></span><br>
            <span style="margin-left: 0px">Mother:<span style="font-weight: bold"> {{"TAPTOUSIA"}}</span></span><br><br>

        </div>
    </div>
</div>
<div>
    <p>Is Register in my School, for 2023-2024 School Year,</p><br>
    <ul style="display: flex; justify-content:center; margin-left:60px; font-size:22px;">
        <li>Class: {{"CE 2/CLASS 4-C,"}} </li>
        <li>Cycle: {{"Primary,"}} </li>
        <li> Section: {{"Bilingual,"}} </li>
        <li>Level: {{"II"}} </li>
    </ul><br>
    <p>In witness Where Whereof this certificate is esthablished for him to serve and be worth what it is entited to.</p>
    <div style="display: flex; align-items:center; margin-left:50%;">
        <p>Done at: {{"YAOUNDE - ODZA - HAPPY"}} </p>
        <P style="margin-left: 80px">Le: {{"12 January 2024 "}}</P><br>
        <p style="margin-left: 120px">DIRECTOR</p><br>
    </div>
</div>
<br><br>
<div>
    <hr>
    <div style="float:left; width:90%; font-size:13px;">
        <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}" alt="" style=" width:50px;";>
    </div>
    <div style="font-size:14px; font-weight:bold; text-align:center; float:right; margin-left:50px; ">
        <p> phone: {{ " (+237) 2223000034 / 695953795 / 661080707 | Email: Info@gsbjuniors.com | Site we: www.gbsjuniors.com "}}</p>
        <p> Siege Social : YAOUNDE - Odza - Happy </p>
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
