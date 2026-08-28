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
            padding: 4px;
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
            font-size: 9px;
        }

        .dashed-line {
            border: none;
            border-top: 2px dashed #000; /* Couleur et style de la ligne */
            height: 1px;
            margin: 5px 0; /* Espacement au-dessus et en dessous de la ligne */
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
            height: 135px;
            object-fit: contain;
            position: absolute;
            right: 0;
            transform: translateY(-175px);
        }
        .signature-block img + img { /* si plusieurs images */
            margin-left: -60px;
            bottom: -10px;
        }
    </style>
</head>
<body>
    <div id="part1">
        <table style="width: 100%; margin-bottom: 10px; ">
            <tr style="">
                <td style="text-align: center; width: 35%; font-size: 15px">
                    REPUBLIQUE DU CAMEROUN <br>
                    paix-travail-patrie <br>
                    <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                    Ministere de l'education de Base <br>
                    Region du Littoral <br>
                    Departement du Wouri
                </td>

                <td style="width: 30%; height: 12px; text-align: center;">
                    <img style="width: 100px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/prestige.jpeg"))) }}">
                    {{--                <img style="width: 100px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">--}}
                </td>

                <td style="text-align: center; width: 35%;">
                    REPUBLIC OF CAMEROON <br>
                    peace-work-fatherland <br>
                    <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                    Ministry of basic education <br>
                    Littoral Region<br>
                    Wouri Division
                </td>
            </tr>
        </table>

        <table style="text-align: center;  width: 100%; margin-bottom: 10px">
            <tr>
                <td style="text-align: center; font-size:12px; color:green; "><strong>ÉCOLE MATERNELLE ET PRIMAIRE BILINGUE MODERNE</strong></td>
            </tr>
        </table>

        <table style="text-align: center;  width: 100%; margin-bottom: 25px">
            <tr>
                <td style="text-align: center; font-size:10px; color:#007a32; FONT-WEIGHT:BOLD; "><strong>*** CERTIFICAT DE SCOLARITÉ / SCHOOL CERTIFICATE ***</strong></td>
            </tr>
            <tr>
                <td style="text-align: center; font-size:8px; color:#007a32; "><strong>{{ __('document_certificat_scolarite.school_year') }}: {{ $academic_year }}</strong></td>
            </tr>

        </table>

        <div style="padding: 10px 30px; margin-bottom: 46px">
            <div style="justify-content: start; width: 100%;">
                Je soussigné <span>.........................................................................................................................</span> DIRECTRICE de l'école
                <br> maternelle et primaire bilingue moderne, atteste que l'élève <br>
                <span>.........................................................................................................................................................................</span> <br>
                Né(e) le <span>...................................................................</span> à <span>..................................................................</span> <br>
                fils/fille de <span>.....................................................................</span> profession <span>...........................................</span> et de <br>
                <span>.....................................................................</span> profession <span>......................................................................</span> <br><br>
                Est inscrit(e) dans mon école sous le matricule <span>...............................</span> En classe de <span>.....................................</span> <br>
                Pour l'année scolaire 202.. / 202.. <br><br>

                En foi de quoi ce certificat lui est délivré pour valoir de ce que de droit. LA DIRECTRICE
            </div>
        </div>


        {{--        //Footer--}}
        <div style="font-size: 12px; height: 65px; background-color:#007a32; color: white; border: 1px solid #007a32; margin-bottom: 0px !important;">

            <div style="width: 100%; text-align: center; padding-top: 15px;">
                <div style="display: inline-block; text-align: center; font-size: 11px;">
                    Siège social: Rail - Bonaberi - Douala | Contacts: 6 99 80 26 88 / 6 74 18 41 35 <br>
                    email: info@ecole-bilingue-moderne-prestige.com | site web : ecole-bilingue-moderne-prestige.com
                </div>
            </div>

            {{--                <div style="width: 50px; float: right;">--}}
            {{--                    <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/moderne.jpeg"))) }}" alt="" style=" width:50px; height: 50px; border-radius: 30px">--}}
            {{--                </div>--}}
        </div>

    <!-- Bloc signatures superposées à droite (même logique que abiscoms) -->
    <div class="signature-block">
        @if(file_exists(public_path('public/profil/seal-signature-director.png')))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
        @endif
    </div>
    </div>

    <hr class="dashed-line">
{{--    <hr style="padding: 2px; background-color: white; border: 1px solid white">--}}

    <div id="part2">
        <table style="width: 100%; margin-bottom: 10px; ">
            <tr style="">
                <td style="text-align: center; width: 35%; font-size: 15px">
                    REPUBLIQUE DU CAMEROUN <br>
                    paix-travail-patrie <br>
                    <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                    Ministere de l'education de Base <br>
                    Region du Littoral <br>
                    Departement du Wouri
                </td>

                <td style="width: 30%; height: 12px; text-align: center;">
                    <img style="width: 100px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/prestige.jpeg"))) }}">
                    {{--                <img style="width: 100px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">--}}
                </td>

                <td style="text-align: center; width: 35%;">
                    REPUBLIC OF CAMEROON <br>
                    peace-work-fatherland <br>
                    <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                    Ministry of basic education <br>
                    Littoral Region<br>
                    Wouri Division
                </td>
            </tr>
        </table>

        <table style="text-align: center;  width: 100%; margin-bottom: 10px">
            <tr>
                <td style="text-align: center; font-size:12px; color:green; "><strong>ÉCOLE MATERNELLE ET PRIMAIRE BILINGUE MODERNE</strong></td>
            </tr>
        </table>

        <table style="text-align: center;  width: 100%; margin-bottom: 25px">
            <tr>
                <td style="text-align: center; font-size:10px; color:#007a32; FONT-WEIGHT:BOLD; "><strong>*** CERTIFICAT DE SCOLARITÉ / SCHOOL CERTIFICATE ***</strong></td>
            </tr>
            <tr>
                <td style="text-align: center; font-size:8px; color:#007a32; "><strong>{{ __('document_certificat_scolarite.school_year') }}: {{ $academic_year }}</strong></td>
            </tr>

        </table>

        <div style="padding: 10px 30px; margin-bottom: 47px">
            <div style="justify-content: start; width: 100%;">
                Je soussigné <span>.........................................................................................................................</span> DIRECTEUR de l'école
                <br> maternelle et primaire bilingue moderne, atteste que l'élève <br>
                <span>.........................................................................................................................................................................</span> <br>
                Né(e) le <span>...................................................................</span> à <span>..................................................................</span> <br>
                fils/fille de <span>.....................................................................</span> profession <span>...........................................</span> et de <br>
                <span>.....................................................................</span> profession <span>......................................................................</span> <br><br>
                Est inscrit(e) dans mon école sous le matricule <span>...............................</span> En classe de <span>.....................................</span> <br>
                Pour l'année scolaire 202.. / 202.. <br><br>

                En foi de quoi ce certificat lui est délivré pour valoir de ce que de droit. LA DIRECTRICE
            </div>
        </div>

{{--        //Footer--}}
        <div style="font-size: 12px; height: 65px; background-color:#007a32; color: white; border: 1px solid #007a32; margin-bottom: 0px !important;">

            <div style="width: 100%; text-align: center; padding-top: 15px;">
                <div style="display: inline-block; text-align: center; font-size: 11px;">
                    Siège social: Rail - Bonaberi - Douala | Contacts: 6 99 80 26 88 / 6 74 18 41 35 <br>
                    email: info@ecole-bilingue-moderne-prestige.com | site web : ecole-bilingue-moderne-prestige.com
                </div>
            </div>

            {{--                <div style="width: 50px; float: right;">--}}
            {{--                    <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/moderne.jpeg"))) }}" alt="" style=" width:50px; height: 50px; border-radius: 30px">--}}
            {{--                </div>--}}
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
