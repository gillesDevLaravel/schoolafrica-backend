<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('bul_mat.titre') }}</title>
    <style type="text/css">
        body {
            padding: 10px 15px;
            font-size: 8px;
            font-family: 'Arial', sans-serif !important;
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
            REPUBLIQUE DU CAMEROUN <br>
            paix-travail-patrie <br>
            <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
            Ministere de l'education de Base <br><br>
            Region du Centre <br>
            Departement du Mfoundi
        </td>

        <td style="width: 70%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$school->logo}")))
                <img style="max-height: 80px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
            @endif
        </td>
        <td style="text-align: center; width: 40%;">
            REPUBLIC OF CAMEROON <br>
            peace-work-fatherland <br>
            <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
            Ministry of basic education <br><br>
            Center Region<br>
            Mfoundi Division
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
        <td style="text-align:center; background-color:green;font-size:14px;padding:5px; color:white;display:flex;" >{{ __('bul_mat.bul_notes') }}</td>
        <td style="text-align:center; background-color:red;font-size:14px;padding:5px; color:white;">{{ __('bul_mat.ensgn_franc') . " ". $assessmentType->name }}</td>
        <td style="text-align:center; background-color:rgb(239, 239, 49);font-size:14px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
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
            <p style="margin-left: 1pt; color: green"><strong>{{ $user->name }}</strong></p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt; color: green"><strong>{{ $classe->name }}</strong></p>
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
        <td>
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
            <td class="td_border"  style="width: 35%">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                    {{ __('bul_mat.dom') }}
                </p>
            </td>
            <td class="td_border" style="width: 35%">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                    {{ __('bul_mat.acti') }}
                </p>
            </td>
            <td class="td_border" style="width: 5%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bul_mat.note') }}
                </p>
            </td>
            <td class="td_border" style="width: 12%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bul_mat.appr') }}
                </p>
            </td>
            <td class="td_border" style="width: 13%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bul_mat.remq') }}
                </p>
            </td>
        </tr>

        @foreach($user->matterGroup as $matterGroup)
            @foreach($matterGroup->assessment as $assessment)
                <tr style="height: 16pt;">
                    <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                        <p class="s13" style="text-align: center; margin: 0; font-weight: bold">{{ $assessment->nameMatter }}</p>
                    </td>
                    <td style="padding-left:0pt!important; width: 100pt;border: 1pt solid #808080;vertical-align:middle;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            <p class="s14" style="vertical-align:middle; text-align:center;@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif padding: 2px 0; height: 20px;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @php $sum_ratings = 0 @endphp
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $sum_ratings += @$sequence->ratings->value; @endphp
                                        @php $note = @$sequence->ratings->value; $note_max = @$typeEvaluation->value ;  @endphp
                                        @php $grade_img = getAppreciationSticker($note, $note_max); @endphp

                                        <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif text-align: center;">
                                            <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @php
                            $note_assessment = $assessment->{"total_note_assessment".mb_substr($assessmentType->name, -1)}; //total_note_assessment1;
                            $grade_img_assessment = getAppreciationSticker($note_assessment, $assessment->notemax); @endphp
                        <img class="appreciation_img" style="width: 50px; height: 50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img_assessment"))) }}">
                    </td>
                </tr>
            @endforeach
        @endforeach
    </table>
</div>

<br>
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr>
        <td rowspan="2" style="width: 20%; vertical-align: middle" class="td_border" >
            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{!! __('bulletin_primaire.leg_br_of_grade') !!}</strong>
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [0;10[ = {{ __('bulletin_primaire.appr_nye') }} = {{ __('bulletin_primaire.appr_nye_txt') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [10;15[ = {{ __('bulletin_primaire.appr_ae') }} = {{ __('bulletin_primaire.appr_ae_txt') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [15;18[ = {{ __('bulletin_primaire.appr_me') }} = {{ __('bulletin_primaire.appr_me_txt') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                [18;20] = {{ __('bulletin_primaire.appr_abe') }} = {{ __('bulletin_primaire.appr_abe_txt') }}
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
<table width="100%" style="border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
    <tr bgcolor="#DBDBDB">
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.res_travail') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.visa_ens') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.visa_dir') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.visa_par') }}
            </p>
        </td>
    </tr>
    <tr>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php
                    $moyenneSequence = "moyenneSequence$num_sequence";
                    $moyenne = $user->$moyenneSequence;

                    if($moyenne < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                    else if($moyenne < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                    else if($moyenne < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                    else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }
                @endphp

                {{--                {{$moyenne}}--}}
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
                {{ __('bul_mat.decision') }}:
                @if($moyenne >= 10)
                    <strong>{{ __('bul_mat.admis') }}</strong>
                @else
                    <strong>{{ __('bul_mat.echoue') }}</strong>
                @endif
            </p>
        </td>
    </tr>
</table>

</body>
</html>
