<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin {{ $user->name }}</title>
    <style type="text/css">
        body {
            padding: 5px 30px;
            font-size: 11px;
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        p {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
            margin: 0pt;
        }

        .s1 {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s2 {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
        }

        .s3 {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s4 {
            color: #f44336;
            font-family: Arial, sans-serif;
            font-style: normal;
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
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
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            REPUBLIQUE DU CAMEROUN <br>
            <strong><i>Paix - Travail - Patrie</i></strong>
            <div style="margin-top: 1pt;">**************</div>
            MINISTERE DES ENSEIGNEMENTS SECONDAIRES <br>
            <div style="margin-top: 1pt;">**************</div>
            <strong>DELEGATION REGIONALE DE ........... </strong><br>
            <div style="margin-top: 1pt;">**************</div>
            DELEGATION DEPARTEMENTALE DE ........... <br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($school->name) }}<br>
        </td>

        <td style="width: 35%; text-align: center;">
            <img style="width: 50%; margin-right: 10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
        </td>

        <td style="text-align: center; width: 40%;">
            REPUBLIC OF CAMEROON <br>
            <strong><i>Peace - Work - Fatherland</i></strong>
            <div style="margin-top: 1pt;">**************</div>
            MINISTRY OF SECONDARY EDUCATION <br>
            <div style="margin-top: 1pt;">**************</div>
            <strong>REGIONAL DELEGATION OF ........... </strong><br>
            <div style="margin-top: 1pt;">**************</div>
            DIVISIONAL DELEGATION ........... <br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($school->name) }}<br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin: 1pt 0">
    <tr>
        <td style="text-align: center; font-size: 12pt"><strong>BULLETIN SCOLAIRE DU {{ strtoupper($periode->name) }} TRIMESTRE </strong></td>
    </tr>

    <tr>
        <td>Année Scolaire: 2024 / 2025</td>
    </tr>
</table>

<table style="width: 100%; margin-top: 5px; text-align: left">
    <tr>
        <td style="width: 15%; align-items: center; justify-content: center;">
            <img style="margin: 5px 0; width: 100%; max-height: 100%;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path('/public/profil/'.$user->photo))) }}">
        </td>

        <td style="width: 85%;">
            <table style="border-collapse: collapse;width: 100%" cellspacing="0">
                <tr>
                    <td colspan="3" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Nom et Prénom de l'élève: <strong>{{ strtoupper($user->name) }}</strong> </p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Classe: <strong>{{ strtoupper($user->classe) }}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Date et Lieu de Naissance: <strong>{{ $user->birthday->format('d/m/Y') }}</strong> à <strong>{{ $user->placeofbirth }}</strong> </p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Genre: <strong>{{ ($user->gender=="Male") ? "M" : "F" }}</strong></p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Effectif: <strong>{{ $effectifClasse }}</strong> </p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 185pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Identifiant Unique: <strong>{{ $user->matricule }}</strong> </p>
                    </td>
                    <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">
                            Redoublant:
                                Oui <input type="checkbox" style="height: 10pt; margin-bottom: 2pt;" @if($user->repeater) checked @endif>
                                Non <input type="checkbox" style="height: 10pt; margin-bottom: 2pt;" @if(!$user->repeater) checked @endif>
                        </p>
                    </td>
                    <td rowspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">Professeur Principal: </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 50px; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">
                            Noms et Contacts des Parents / Tuteurs:
                            <strong>{{ $user->father }}</strong> / <strong>{{ $user->phone }}</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table style="border-collapse: collapse; margin-top: 15px;  width: 100%" cellspacing="0">
    <tr>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>MATIERES ET NOM DE L'ENSEIGNANT</strong></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>COMPETENCE EVALUEES</strong></p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>N/20</strong></p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>M/20</strong></p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>Coef</strong></p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>M * Coef</strong></p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>Cote</strong></p>
        </td>
        <td style="width: 40pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>[Min - Max]</strong></p>
        </td>
        <td style="width: 100pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>Appréciations et Visa de l'enseignant</strong></p>
        </td>
    </tr>

    @php $total_note_coef = 0; $total_coef = 0; @endphp
    @foreach($ratings as $rating)
        <tr>
            <td style="width:120pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;">
                    {{ strtoupper($rating->matter->name) }}
                    <br><br>
                    M/Mme {{ strtoupper($rating->teacher->name) }}
                </p>
            </td>
            <td style="width:130pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;">Use appropriate language skills and resources to talk about the environment, health, feeding habits and safety needs.</p>
            </td>
            <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $rating->value }}</p>
            </td>
            <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;"></p>
            </td>
            <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                @php $total_coef+= $rating->coef @endphp
                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $rating->coef }}</p>
            </td>
            <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                @php $tmp_n_c = $rating->value * $rating->coef; $total_note_coef+= $tmp_n_c @endphp
                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $tmp_n_c }}</p>
            </td>
            <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;"></p>
            </td>
            <td style="width: 40pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;"></p>
            </td>
            <td style="width: 100pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $rating->observation }}</p>
            </td>
        </tr>
    @endforeach

    <tr>
        <td colspan="4" style="text-align: right; margin-right: 5pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <strong style="margin-right: 5pt;">TOTAL</strong>
        </td>
        <td style=" border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $total_coef }}</p>
        </td>
        <td style=" border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $total_note_coef }}</p>
        </td>
        <td colspan="3" style=" border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <strong style="margin-left: 5pt;">MOYENNE: {{ @round($total_note_coef / $total_coef, 2) }}</strong>
        </td>
    </tr>

{{--    @foreach($user->trimestre[0]->assessmentType[0]->matterGroup as $key => $ratings)--}}
{{--        @foreach($ratings->assessment as $sub_key => $assessment)--}}
{{--            <tr>--}}
{{--                <td style="height: 21pt; width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="s2" style="padding-top: 4pt; padding-left: 1pt; text-align: left;">{{ $assessment->nameMatter }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="s3" style="padding-top: 4pt; padding-left: 1pt; padding-right: 2pt; text-align: center;">{{ $assessment->tearcherName }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="@if(@$assessment->ratings->value??0 < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-align: center;">{{ @$assessment->ratings->value??0 }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="@if(@$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0 < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0 }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    @php $trim = (@$assessment->ratings->value??0 + @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0) / 2; @endphp--}}
{{--                    <p class="@if($trim < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-align: center;">--}}
{{--                        {{ $trim }}--}}
{{--                    </p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="s2" style="padding-top: 4pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->coefficient??0 }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p class="s2" style="padding-top: 4pt; text-align: center;">{{ ($trim) * @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->coefficient??0 }}</p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">--}}
{{--                    <p class="s2" style="padding-top: 4pt; text-align: center;"></p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">--}}
{{--                    <p class="s2" style="padding-top: 4pt; text-align: center;"></p>--}}
{{--                </td>--}}
{{--                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--                    <p style="text-indent: 0pt; text-align: center;"></p>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}

{{--        <tr>--}}
{{--            <td--}}
{{--                style="height: 20pt; width: 25%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; " colspan="2" bgcolor="#C1C4C4" >--}}
{{--                <p class="s2" style="padding-top: 4pt; padding-left: 1pt; text-align: left;">{{ $ratings->description }}</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >--}}
{{--                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ @$ratings->totalNoteByMatterGroup }}</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; " bgcolor="#C1C4C4" >--}}
{{--                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->totalNoteByMatterGroup }}</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >--}}
{{--                <p class="s2" style="padding-top: 4pt; text-align: center;">--}}
{{--                    @php $trim_total = @$ratings->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->totalNoteByMatterGroup; @endphp--}}
{{--                    {{ $trim_total / 2 }}--}}
{{--                </p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >--}}
{{--                <p class="s2" style="padding-top: 4pt; text-align: center;">{{ @$ratings->totalCoefMatterGroupAssessment }}</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4">--}}
{{--                <p class="s2" style="padding-top: 3pt; text-align: center;">{{ @$ratings->totalNoteCoefByMatterGroup }}</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style=" width: 25%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2" bgcolor="#C1C4C4">--}}
{{--                <p class="s2" style="padding-top: 4pt; text-align: center;">MOY</p>--}}
{{--            </td>--}}
{{--            <td--}}
{{--                style="text-align: center; width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4">--}}
{{--                <p class="@if(@$ratings->MoyenneMatterGroup < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-align: center;">{{ @$ratings->MoyenneMatterGroup }}</p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}

{{--    <tr>--}}
{{--        <td style="height: 20pt; width: 25%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2">--}}
{{--            <p class="s2" style="padding-top: 5pt; padding-left: 1pt; text-align: left;">TOTAL TRIMESTRIELLE </p>--}}
{{--        </td>--}}
{{--        <td style=" width: 15%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 5pt; text-align: center;">--}}
{{--                @php $total_eval1 = @$user->trimestre[0]->assessmentType[0]->matterGroup[0]->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[0]->matterGroup[1]->totalNoteByMatterGroup; @endphp--}}
{{--                {{ $total_eval1 }}--}}
{{--            </p>--}}
{{--        </td>--}}
{{--        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 5pt; text-align: center;">--}}
{{--                @php $total_eval2 = @$user->trimestre[0]->assessmentType[1]->matterGroup[0]->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[1]->matterGroup[1]->totalNoteByMatterGroup; @endphp--}}
{{--                {{ $total_eval2 }}--}}
{{--            </p>--}}
{{--        </td>--}}
{{--        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 5pt; text-align: center;">{{ ($total_eval1 + $total_eval2) / 2 }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 5pt; text-align: center;">{{ @$user->trimestre[0]->totalCoef }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 5pt; text-align: center;">{{ @$user->trimestre[0]->total }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 25%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2">--}}
{{--            <p class="s2" style="padding-top: 5pt; padding-left: 15pt; text-align: left;">MOY TRIM</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="@if(@$user->trimestre[0]->moyenneTrimestre < 10) s4 @else s2 @endif" style="padding-top: 5pt; text-align: center;">{{ @$user->trimestre[0]->moyenneTrimestre }}</p>--}}
{{--        </td>--}}
{{--    </tr>--}}
</table>

<table style="margin-top: 18pt; border-collapse: collapse; width: 100%" cellspacing="0">
    <tr style="">
        <td colspan="4" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>Discipline</strong></p>
        </td>
        <td colspan="4" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>Travail de l'élève</strong></p>
        </td>
        <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>Profil de la classe</strong></p>
        </td>
    </tr>
    <tr>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">Abs. Non. J. (h)</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Avertissement de Conduite</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">TOTAL GENERAL</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>APPRECIATION</strong></p>
        </td>
        <td style="width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>Moyenne Générale</strong></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong></strong></p>
        </td>
    </tr>
    <tr>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">Abs. J. (h)</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Blâme de Conduite</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">COEF</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <table style="border-collapse: collapse; width: 100%" cellspacing="0">
                <tr>
                    <td style="margin-left: 2pt; border-top-color: #212628; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">CTBA</td>
                    <td style="margin-left: 2pt; width: 20pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628;"></td>
                </tr>
                <tr>
                    <td style="margin-left: 2pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">CBA</td>
                    <td style="margin-left: 2pt; width: 20pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; "></td>
                </tr>
            </table>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>[Min - Max]</strong></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong></strong></p>
        </td>
    </tr>
    <tr>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">Retards (nombre de fois)</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Exclusions (jours)</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">MOYENNE TRIM</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <table style="border-collapse: collapse; width: 100%" cellspacing="0">
                <tr>
                    <td style="margin-left: 2pt; border-top-color: #212628; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">CA</td>
                    <td style="margin-left: 2pt; width: 20pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628;"></td>
                </tr>
                <tr>
                    <td style="margin-left: 2pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">CMA</td>
                    <td style="margin-left: 2pt; width: 20pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; "></td>
                </tr>
            </table>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Nombre de moyennes</p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong></strong></p>
        </td>
    </tr>
    <tr>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">Consignes (heures)</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Exclusions définitive</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">COTE</p>
        </td>
        <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">CNA</p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">Taux de réussite</p>
        </td>
        <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong></strong></p>
        </td>
    </tr>

    <tr>
        <td colspan="4" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;">Appréciation du travail de l'élève (points forts et poitns à améliorer)</p>
        </td>
        <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;">Visa du parent / Tuteur</p>
        </td>
        <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;">Nom et visa du professeur principal</p>
        </td>
        <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-align: center;">Le Chef d'établissement</p>
        </td>
    </tr>
{{--    <tr style="">--}}
{{--        <td style="height: 18pt; width: 54pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; text-align: center;">{{ @$user->trimestre[0]->totalAbs }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; text-align: center;"></p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; text-align: center;"></p>--}}
{{--        </td>--}}
{{--        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-align: center;"></p>--}}
{{--        </td>--}}
{{--        <td style=" width: 137pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" rowspan="3">--}}
{{--            <p style="text-indent: 0pt; text-align: left;"></p>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr style="">--}}
{{--        <td style="height: 16pt; width: 54pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s3" style="padding-top: 3pt; text-align: center;">Moy Classe</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s3" style="padding-top: 3pt; text-align: center;">Moy Eleve</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s3" style="padding-top: 3pt; text-align: center;">Rang</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s3" style="padding-top: 3pt; text-align: center;">Commentaire</p>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <tr style="">--}}
{{--        <td style="height: 16pt; width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="@if($moyenneClasse < 10) s4 @else s2 @endif" style="padding-top: 3pt; text-align: center;">{{ $moyenneClasse }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="@if(@$user->trimestre[0]->moyenneTrimestre < 10) s4 @else s2 @endif" style="padding-top: 3pt; text-align: center;">{{ @$user->trimestre[0]->moyenneTrimestre }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-align: center;">{{ @$user->trimestre[0]->rangTrimestre }}</p>--}}
{{--        </td>--}}
{{--        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">--}}
{{--            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-align: center;"></p>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}

{{--<table style="width: 100%;">--}}
{{--    <tr>--}}
{{--        <td>fait à Yaoundé le :</td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td style="padding-top: 20px; width: 50%"><strong>Parent</strong></td>--}}
{{--        <td style="padding-top: 20px; width: 50%; text-align: right"><strong>Principal</strong></td>--}}
{{--    </tr>--}}
</table>

</body>
</html>
