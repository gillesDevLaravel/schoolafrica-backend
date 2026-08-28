<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin Maternelle</title>
    <style type="text/css">
        body {
            padding: 10px 15px;
            font-size: 8px;
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

        p {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
            margin: 0pt;
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

        td{
            vertical-align: middle;
            /*padding-left: 1pt;*/
        }

        .td_border{
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

        .appreciation_img{
            text-align: center;
            margin-top: 2px;
            width: 25px;
            height: 25px;
            margin-right:10px;
            border-radius: 50%
        }
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIQUE DU CAMEROUN <br>
                paix-travail-patrie <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                Ministere de l'education de Base <br><br>
                Region du Centre <br>
                Departement du Mfoundi
            </strong>
        </td>

        <td style="width: 70%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$school->logo}")))
                <img style="max-height: 80px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
            @endif
        </td>
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIC OF CAMEROON <br>
                peace-work-fatherland <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                Ministry of basic education <br><br>
                Center Region<br>
                Mfoundi Division
            </strong>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="color:#{{$code_couleurs[0]}}; text-align: center; font-size:14px; "><strong>{{ strtoupper($school->name) }}</strong></td>
    </tr>
</table>

<hr>
<table width="80%" style="margin-left: 10%">
    <tr>
        <td style="background-color:green;font-size:14px;padding:5px; color:white;display:flex;" >Bulletin de notes</td>
        <td style="background-color:red;font-size:14px;padding:5px; color:white;">Enseignement francophones * séquence</td>
        <td style="background-color:rgb(239, 239, 49);font-size:14px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
    </tr>
</table>

<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr>
        <td rowspan="2" width="50px">
            @if(file_exists(public_path("/public/profil/{$user->photo}")))
                <img style="width: 70px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$user->photo}"))) }}">
            @else
                <img style="width: 70px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
            @endif
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt"><strong>{{ $user->name }}</strong></p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt"><strong>{{ $classe->name }}</strong></p>
        </td>
    </tr>
    <tr>
        <td >
            <p style="margin-left: 1pt">
                {{__('bulletin_primaire.reg_number')}}: <strong>{{ $user->matricule }}</strong> <br>
                {{__('bulletin_primaire.sex')}}: <strong><strong>{{ $user->gender[0] }}</strong></strong> <br>
                {{__('bulletin_primaire.repeater')}}: <strong>{{ ($user->repeater) ? __('bulletin_primaire.oui') : __('bulletin_primaire.non') }}</strong>
            </p>
        </td>
        <td >
            <p style="margin-left: 1pt">
                @php
                    $dateString = $user->birthday;
                    $date = new DateTime($dateString);
                    $formattedDate = $date->format('d / m / Y');
                @endphp

                {{__('bulletin_primaire.birth_date')}}: <strong>{{ (!is_null($user->birthday)) ? $formattedDate : "-" }}</strong> <br>


                {{__('bulletin_primaire.pays')}}: <strong>{{ $user->nationality }}</strong> <br>
                {{__('bulletin_primaire.ville')}} <strong>{{ $user->city }}</strong>
            </p>
        </td>
        <td colspan="2" style="width: 200px">
            <p style="margin-left: 1pt">
                <strong>{{ $section->name }}</strong> <br>
                {{__('bulletin_primaire.effectif')}}: <strong style="color: green">{{ $effectifClasse }}</strong> <br>
                {{__('bulletin_primaire.teacher')}}: {{ @$teacher_principal->name }}
            </p>
        </td>
    </tr>
</table>
<br>

<div @if(file_exists(public_path("/public/profil/{$school->logo}")))
         style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}');
             background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%"
    @endif
>
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr style="background-color: #{{$code_couleurs[0]}};">
        <td class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>Domaines</strong>
            </p>
        </td>
        <td class="td_border">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>Activité</strong>
            </p>
        </td>
        <td class="td_border" style="width: 50pt;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>Note</strong>
            </p>
        </td>
        <td class="td_border" style="width: 50pt;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>Appréciation</strong>
            </p>
        </td>
        <td class="td_border" style="width: 50pt;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>Remarques</strong>
            </p>
        </td>
    </tr>

    @foreach($user->trimestre[0]->assessmentType[0]->matterGroup as $matterGroup)
        <tr>
            <td class="td_border">
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ $matterGroup->name }}</strong>
                </p>
            </td>
            <td class="td_border">
                @foreach($matterGroup->assessment as $key => $assessment)
                    @if($key != count($matterGroup->assessment)-1)
                        <p class="s14" style="text-align:center;border-bottom: 1px solid black; padding: 2px 0; height: 25px;">{{ $assessment->nameMatter ?? "-" }}</p>
                    @else
                        <p class="s14" style="text-align:center; padding: 2px 0; height: 25px;">{{ $assessment->nameMatter ?? "-" }}</p>
                    @endif
                @endforeach
            </td>
            <td class="td_border">
                @php $sum_ratings = 0 @endphp
                @foreach($matterGroup->assessment as $keyA => $assessment)
                    @php
                        $notemaxToCkech = $assessment->notemax;
                        $noteToCheck = @$assessment->ratings->value;
                        $grade_img = getAppreciationStickerForMaternelle($noteToCheck);
                    @endphp

                    @if($keyA != count($matterGroup->assessment)-1)
                        <p class="s14" style="border-bottom: 1px solid black; text-align: center;">
                            <span style=" width: 25px; height: 25px; padding: 2px">
                            @if(!is_null($noteToCheck))
                                <img style="text-align: center; width: 25px; height: 25px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">
                            @else
                                ---
{{--                                <img style="text-align: center; width: 25px; height: 25px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">--}}
                            @endif
                            </span>
                        </p>
                    @else
                        <p class="s14" style="text-align: center;">
                            <span style="  width: 25px; height: 25px; padding: 2px">
                            @if($noteToCheck)
                                <img style="text-align: center; width: 25px; height: 25px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">
                            @else
                                -
                            @endif
                            </span>
                        </p>
                    @endif
                @endforeach
            </td>

            <td class="td_border">
                <p class="s14" style="text-align: center;">
                    @php
                        $noteTotale = $matterGroup->MoyenneMatterGroup;

                        $grade_img = getAppreciationStickerForMaternelle($noteTotale);
                    @endphp

                    <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">
                </p>
            </td>
            <td class="td_border">
                <p class="s10" style="text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong></strong>
                </p>
            </td>
        </tr>
    @endforeach
</table>
</div>

<br>
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr">
        <td rowspan="2" style="width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>Légendes appréciations</strong>
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [0;10[ = NA = Non Acquis
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [10;15[ = EA = En Cours d'acquisition
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [15;18[ = A = Acquis
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [18;20] = A+ = Expert
            </p>
        </td>
    </tr>

    <tr>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation1.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation2.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation3.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation4.png"))) }}">
        </td>
    </tr>
</table>

<br>
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr bgcolor="#DBDBDB">
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                Résumé du travail
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                Visa de l'enseignant
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                Visa Directeur
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                Visa du parent
            </p>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php
                    $moyenne = $user->trimestre[0]->assessmentType[0]->moyenne;

                    if($moyenne < 1) { $appreciation_img = "appreciation1.png"; $appreciation_txt = "Non Acquis"; }
                    else if($moyenne < 2) { $appreciation_img = "appreciation2.png"; $appreciation_txt = "En Cours d'aquisitiion"; }
                    else if($moyenne < 3) { $appreciation_img = "appreciation3.png"; $appreciation_txt = "Acquis"; }
                    else { $appreciation_img = "appreciation4.png"; $appreciation_txt = "Expert"; }
                @endphp

                <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$appreciation_img"))) }}">
            </p>
        </td>
        <td rowspan="3" style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
        </td>
        <td rowspan="3" style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
        </td>
        <td rowspan="3" style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"> {{ $appreciation_txt }}</p>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                Décision:
                @if($moyenne >= 2)
                <strong>Admis(e)</strong>
                @else
                <strong>Échoué(e)</strong>
                @endif
            </p>
        </td>
    </tr>
</table>

</body>
</html>
