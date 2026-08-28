<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('document_list_students.title') . ""}}</title>

    <style type="text/css">
        body {
            padding: 10px 30px;
            font-family: 'Arial', sans-serif;
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

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .verticalAlign{
            /*max-width: 20pt; !* Largeur maximale *!*/
            max-height: 100px; /* Hauteur maximale */
            height: 100px; /* Hauteur fixe */
            text-align: center; /* Centrer le texte */
            vertical-align: middle; /* Centrer verticalement */
        /*    writing-mode: vertical-rl; !* Afficher le texte verticalement *!*/
        /*    !*transform: rotate(-90deg); !* Faire pivoter le texte *!*!*/
            /*overflow: hidden; !* Caché si le texte déborde *!*/
            white-space: nowrap; /* Ne pas faire de retour à la ligne */
            padding: 1pt 5pt;
            text-indent: 0pt;
            font-size: 8px;
        /*    margin: 0;*/
        }
    </style>

</head>
<body>
    {{-- Entête du document --}}

    @if(isset($route) && $route == "cim")
    @include('documents.create-documents.entetes.entete-bulletin-secondaire-montreal')
    @else
    <table style="width: 100%;">
        <tr style="">
            <td style="text-align: center; width: 40%;font-size: 13px">
                <strong>REPUBLIQUE DU CAMEROUN</strong> <br> <br>
                <span style="font-size: 12px">paix-travail-patrie</span> <br>
                <span style="font-size: 12px">*******</span> <br>

                <span style="font-size: 12px">Ministère de l'Education de Base</span> <br>
                <span style="font-size: 12px">Région du Centre</span> <br>
                <span style="font-size: 12px">Département du Mfoundi</span> <br>
            </td>

            <td style="width:70%; text-align:center;">
                <img style="width:30%; height:130px; margin-right:10px;margin-top:-10px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$ecole->logo"))) }}">
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
    </table>
    @endif
    {{-- Entête du pv --}}
    <table style="text-align: center;  width: 100%; margin-bottom: 8px">
        <tr>
            <td style="color:#{{$code_couleurs[0]}}; text-align: center; font-size:18px; "><strong>{{ NOM DE L'ECOLE }}</strong></td>
        </tr>
    </table>

    <div style="text-align: center; font-weight: bold; font-size: 20px;">{{ __('bulletin_primaire.mark_sheet') }}</div>
    <hr>

    <div style="text-align: center; width: 100%; margin-top: 10px">
    <strong>{{ Nom de la classe }} </strong> ({{Nom de l'évaluation / 2024-2025 / Nom de section}})
    </div>


    {{-- Tableau des effectifs de la classe --}}
    <table style="width: 100%; margin-top: 10px;">
        <tr>
            <td style="width: 100%;">
                <table style="border-collapse: collapse; margin-top: 5px;  width: 100%" cellspacing="0">
                    <tr style="background-color: rgba(207, 196, 196, 0.4)">
                        <td colspan="3" style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.nouveaux') }}</strong></p>
                        </td>
                        <td colspan="3"
                            style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; padding-right: 2pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.redoublants') }}</strong></p>
                        </td>
                        <td colspan="3"
                            style=" width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>TOTAL</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Nouveaux }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Nouvelles }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Nouveaux + nouvelles }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Redoublants}}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Redoublantes }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Redoublants + Redoublantes }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Nombre de garcon }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ Nombre de fille }}</p>
                        </td>
                        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ nbrF + nbrG }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
