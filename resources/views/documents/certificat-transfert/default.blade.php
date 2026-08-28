<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificat de Transfert - {{$user->name}}</title>
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
            margin-top: 10px;
            position: relative; /* important pour contenir les images absolues */
        }
        .signature-block img {
            height: 150px;
            object-fit: contain;
            position: absolute;
            right: 0;
            transform: translateY(-20px);
        }
        .signature-block img + img { /* si plusieurs images */
            margin-left: -60px;
            bottom: -10px;
        }
        .dashed-line {
            border: none;
            border-bottom: 2px dashed #000; /* Couleur et style de la ligne */
            height: 1px;
            margin-top: 200px;
        }

        .dashed-info {
            text-decoration: none;
            border-bottom: 1px dashed black;
            display: inline
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
    </style>
</head>
<body>

<div style="text-align: center; font-size: 25px; margin-top: 150px; margin-bottom: 30px;">
    <strong class="">
        CERTIFICAT DE TRANSFERT <br> TRANSFER CERTIFICATE
    </strong>
</div>

<div style="padding: 10px 30px;font-size: 18px">
    <div style="justify-content: start; width: 100%; margin-top: 15px;">
        Je soussigné <span class="dynamic_values" style="color: white">......................................................................</span> DIRECTEUR du <strong>GSB JUNIORS</strong>, <br>
        I, the undersigned, <div class="full-width" style="width: 42%; display: inline-block"></div> DIRECTOR of <strong>GSB JUNIORS</strong>, <br>

        <div style="width: 100%; height: 50px;">
            <div style="width: 21%; float: left;">
                certifie que, l'élève <br> certify that
            </div>
            <div class="full-width" style="width: 87%; margin-top:20px; margin-left: 13%; height: 20px; text-align: center;">
                <span class="dynamic_values" style="margin-left: -13%;">{{ strtoupper($user->name) }}</span>
            </div>
        </div>

        Né(e) le : <div class="" style="display:inline-block; width: 47%"><strong></strong></div> à: <br>
        Born on <div class="full-width dynamic_values" style="display:inline-block; width: 48%">
            @if(!is_null($user->birthday))
                {{ $user->birthday->format("d M Y") }}
            @else
                <span style="color: transparent">XX - YY - ZZZZ</span>
            @endif
        </div> at: <div class="full-width dynamic_values" style="display:inline-block; width: 38%">{{ $user->placeofbirth ?? "_" }}</div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 17%; float: left;">
                Nom du père: <br> Father's Name:
            </div>
            <div class="full-width dynamic_values" style="width: 83%; margin-top:20px; margin-left: 17%; height: 20px;">
                {{ strtoupper($father) }}
            </div>
        </div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 18%; float: left;">
                Nom de la mère: <br> Mother's Name:
            </div>
            <div class="full-width dynamic_values" style="width: 82%; margin-top:20px; margin-left: 18%; height: 20px;">
                {{ strtoupper($mother) }}
            </div>
        </div>

        est inscrit(e) dans cet établissement. Matricule :
        <div style="width: 100%;">
            <div style="display: inline-flex; width: 45%">is registered in this schoool with Reg. No:</div>
            <div class="full-width dynamic_values" style="display: inline-block; width: 54%;">{{ $user->matricule }}</div>
        </div>

        Classe :
        <div style="width: 100%;">
            <div style="display: inline-flex; width: 10%;">in class :</div>
            <div class="full-width dynamic_values" style="display: inline-block; width: 89%;">{{ $user->classeName }}</div>
        </div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 28%; float: left;">
                pour l'année académique:  <br> for the academic year:
            </div>
            <div class="full-width dynamic_values" style="width: 76%; margin-top:20px; margin-left: 24%;">{{ $academic_year }}</div>
        </div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 28%; float: left;">
                est transféré à, (en) :  <br> is transfered to
            </div>
            <div class="full-width dynamic_values" style="width: 83%; margin-top:20px; margin-left: 17%;">{{ $country }}</div>
        </div>

        <div style="width: 100%; display:inline-flex; height: 50px;">
            <div style="width: 100%; float: left;">
                à compter de la date de signature de ce certificat.  <br> With effect from the date of signature of this certificate.
            </div>
        </div>

        <br><br>

        Le présent certificat est délivré pour servir et valoir ce que de droit. <br>
        This certificate is issued to serve the bearer where ever need be.

        <br><br><br>

        Fait à : <div class="" style="display:inline-block; width: 48%"><strong></strong></div> le: <br>
        Done at<div class="full-width dynamic_values" style="display:inline-block; width: 48%">YAOUNDE</div> the: <div class="full-width" style="display:inline-block; width: 37%"></div>

        <br><br><br>

        <div style="text-align: center">
            Le Directeur / The Director
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
