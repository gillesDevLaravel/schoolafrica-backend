<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin {{ $user->name }}</title>
    <style type="text/css">
        body {
            padding: 5px 30px;
            font-size: 10px;
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
            font-weight: bold;
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
            font-weight: bold;
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
            font-weight: bold;
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
            <strong>
                MINISTERE DES ENSEIGNEMENTS SECONDAIRES <br>
                <div style="margin-left: 10%; margin-top: 1pt; margin-bottom: 4pt;">*****************************</div>
                DELEGATION REGIONALE POUR LE CENTRE <br>
                <div style="margin-left: 10%; margin-top: 1pt; margin-bottom: 4pt;">*****************************</div>
                DELEGATION DEPARTEMENTALE DU MFOUDI <br>
                <div style="margin-left: 10%; margin-top: 1pt; margin-bottom: 4pt;">*****************************</div>
                COMPLEXE SCOLAIRE BILINGUE B. OLIVE <br>
            </strong>
        </td>

        <td style="width: 35%; text-align: center;">
            <img style="width: 50%; margin-right: 10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
        </td>
        <td style="width: 40%; padding-top: 15px; text-align: center">
            <strong>
                REPUBLIQUE DU CAMEROUN <br>
                <div style="text-align: center">Paix - Travail - Patrie</div>
                <div style="text-align: center; margin-bottom: 4pt;">**************</div>
                ANNEE SCOLAIRE
            </strong>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin: 5pt 0">
    <tr>
        <td style="text-align: center"><strong>BULLETIN DE NOTES DU {{ $user->trimestre[0]->name }}</strong></td>
    </tr>
</table>

<table style="width: 100%; font-size: 13px;">
    <tr>
        <td style="width: 50%">
            <div>Nom et prenom : {{ $user->name }}</div>
            <div>Sexe: {{ $user->gender }}</div>
            <div>Matricule: {{ $user->matricule }} </div>
            <div>Né(e) le : {{ $user->birthday }}</div>
            <div>Année scolaire : 2023 - 2024</div>
        </td>
        <td style="width: 50%; text-align: right">
            <div>Classe : {{ $user->classe }}</div>
            <div>Redoublant : {{ ($user->repeater) ? "Yes" : "Non"  }}</div>
            <div>Effectifs : {{ $effectifClasse }}</div>
            <div>Situation : {{ ($user->situation=="new" ? "Nouveau" : "Redoublant")  }}</div>
            <div>Professeur Titulaire : </div>
        </td>
    </tr>
</table>

<table style="border-collapse: collapse; margin-top: 15px;  width: 100%" cellspacing="0">
    <tr>
        <td style="width: 95pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">DISCIPLINES</p>
        </td>
        <td
            style="width: 95pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; padding-right: 2pt; text-indent: 0pt; text-align: center;">ENSEIGNANTS</p>
        </td>
        <td
            style=" width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">EVAL {{ $user->trimestre[0]->assessmentType[0]->name }}</p>
        </td>
        <td
            style=" width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">EVAL {{ $user->trimestre[0]->assessmentType[1]->name }}</p>
        </td>
        <td
            style=" width: 45pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">TRIM</p>
        </td>
        <td
            style=" width: 30pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">COEF.</p>
        </td>
        <td
            style=" width: 45pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">TOTAL</p>
        </td>
        <td
            style=" width: 30pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">RANG</p>
        </td>
        <td
            style=" width: 45pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">MENTIONS</p>
        </td>
        <td
            style=" width: 30pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">VISA</p>
        </td>
    </tr>

    @foreach($user->trimestre[0]->assessmentType[0]->matterGroup as $key => $mattergroups)
        @foreach($mattergroups->assessment as $sub_key => $assessment)
            <tr>
                <td style="height: 21pt; width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; padding-left: 1pt; text-indent: 0pt; text-align: left;">{{ $assessment->nameMatter }}</p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 4pt; padding-left: 1pt; padding-right: 2pt; text-indent: 0pt; text-align: center;">{{ $assessment->tearcherName }}</p>
                </td>
                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="@if(@$assessment->ratings->value??0 < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$assessment->ratings->value??0 }}</p>
                </td>
                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="@if(@$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0 < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0 }}</p>
                </td>
                <td style=" width: 35pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    @php $trim = (@$assessment->ratings->value??0 + @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->value??0) / 2; @endphp
                    <p class="@if($trim < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">
                        {{ $trim }}
                    </p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->coefficient??0 }}</p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ ($trim) * @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->assessment[$sub_key]->ratings->coefficient??0 }}</p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;"></p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;"></p>
                </td>
                <td style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p style="text-indent: 0pt; text-align: center;"></p>
                </td>
            </tr>
        @endforeach

        <tr>
            <td
                style="height: 20pt; width: 25%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; " colspan="2" bgcolor="#C1C4C4" >
                <p class="s2" style="padding-top: 4pt; padding-left: 1pt; text-indent: 0pt; text-align: left;">{{ $mattergroups->description }}</p>
            </td>
            <td
                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$mattergroups->totalNoteByMatterGroup }}</p>
            </td>
            <td
                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; " bgcolor="#C1C4C4" >
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->totalNoteByMatterGroup }}</p>
            </td>
            <td
                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">
                    @php $trim_total = @$mattergroups->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[1]->matterGroup[$key]->totalNoteByMatterGroup; @endphp
                    {{ $trim_total / 2 }}
                </p>
            </td>
            <td
                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4" >
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$mattergroups->totalCoefMatterGroupAssessment }}</p>
            </td>
            <td
                style=" width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4">
                <p class="s2" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">{{ @$mattergroups->totalNoteCoefByMatterGroup }}</p>
            </td>
            <td
                style=" width: 25%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2" bgcolor="#C1C4C4">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">MOY</p>
            </td>
            <td
                style="text-align: center; width: 10%; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" bgcolor="#C1C4C4">
                <p class="@if(@$mattergroups->MoyenneMatterGroup < 10) s4 @else s2 @endif" style="padding-top: 4pt; text-indent: 0pt; text-align: center;">{{ @$mattergroups->MoyenneMatterGroup }}</p>
            </td>
        </tr>
    @endforeach

    <tr>
        <td style="height: 20pt; width: 25%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2">
            <p class="s2" style="padding-top: 5pt; padding-left: 1pt; text-indent: 0pt; text-align: left;">TOTAL TRIMESTRIELLE </p>
        </td>
        <td style=" width: 15%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">
                @php $total_eval1 = @$user->trimestre[0]->assessmentType[0]->matterGroup[0]->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[0]->matterGroup[1]->totalNoteByMatterGroup; @endphp
                {{ $total_eval1 }}
            </p>
        </td>
        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">
                @php $total_eval2 = @$user->trimestre[0]->assessmentType[1]->matterGroup[0]->totalNoteByMatterGroup + @$user->trimestre[0]->assessmentType[1]->matterGroup[1]->totalNoteByMatterGroup; @endphp
                {{ $total_eval2 }}
            </p>
        </td>
        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">{{ ($total_eval1 + $total_eval2) / 2 }}</p>
        </td>
        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->totalCoef }}</p>
        </td>
        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->total }}</p>
        </td>
        <td style=" width: 25%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" colspan="2">
            <p class="s2" style="padding-top: 5pt; padding-left: 15pt; text-indent: 0pt; text-align: left;">MOY TRIM</p>
        </td>
        <td style=" width: 10%; border-top-style: solid; border-top-width: 2pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="@if(@$user->trimestre[0]->moyenneTrimestre < 10) s4 @else s2 @endif" style="padding-top: 5pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->moyenneTrimestre }}</p>
        </td>
    </tr>
</table>

<table style="margin-top: 18pt; border-collapse: collapse; width: 100%" cellspacing="0">
    <tr style="">
        <td style="height: 16pt; width: 54pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Total Abs</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Non-Justifiées Abs</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Sanctions</p>
        </td>
        <td style=" width: 55pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-indent: 0pt; text-align: center;">Conseil de Dsicipline</p>
        </td>
        <td style=" width: 137pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; padding-right: 2pt; text-indent: 0pt; text-align: center;">Commentaire</p>
        </td>
    </tr>
    <tr style="">
        <td style="height: 18pt; width: 54pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->totalAbs }}</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; text-indent: 0pt; text-align: center;"></p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; text-indent: 0pt; text-align: center;"></p>
        </td>
        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-indent: 0pt; text-align: center;"></p>
        </td>
        <td style=" width: 137pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;" rowspan="3">
            <p style="text-indent: 0pt; text-align: left;"></p>
        </td>
    </tr>
    <tr style="">
        <td style="height: 16pt; width: 54pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Moy Classe</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Moy Eleve</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Rang</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s3" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">Commentaire</p>
        </td>
    </tr>
    <tr style="">
        <td style="height: 16pt; width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="@if($moyenneClasse < 10) s4 @else s2 @endif" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">{{ $moyenneClasse }}</p>
        </td>
        <td style=" width: 83pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="@if(@$user->trimestre[0]->moyenneTrimestre < 10) s4 @else s2 @endif" style="padding-top: 3pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->moyenneTrimestre }}</p>
        </td>
        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-indent: 0pt; text-align: center;">{{ @$user->trimestre[0]->rangTrimestre }}</p>
        </td>
        <td style=" width: 55pt; border-top-style: solid; border-top-width: 0pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 3pt; padding-left: 1pt; padding-right: 1pt; text-indent: 0pt; text-align: center;"></p>
        </td>
    </tr>
</table>

<table style="width: 100%;">
    <tr>
        <td>fait à Yaoundé le :</td>
    </tr>
    <tr>
        <td style="padding-top: 20px; width: 50%"><strong>Parent</strong></td>
        <td style="padding-top: 20px; width: 50%; text-align: right"><strong>Principal</strong></td>
    </tr>
</table>

</body>
</html>
