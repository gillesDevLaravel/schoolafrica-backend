<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('bul_mat.titre') }}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
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

@php
    $legend_of_grade = legendOfGrade();
@endphp

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
<table width="90%" style="margin-left: 5%">
    <tr>
        <td style="text-align:center; background-color:green;font-size:14px;padding:5px; color:white;display:flex;" >{{ __('bul_mat.bul_notes') }}</td>
        <td style="text-align:center; background-color:red;font-size:14px;padding:5px; color:white;">{{ __('bul_mat.ensgn_franc') . " ". $trimestre->name }}</td>
        <td style="text-align:center; background-color:rgb(239, 239, 49);font-size:14px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
    </tr>
</table>

<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr>
        <td rowspan="2" width="50px">
            @if(file_exists(public_path("/public/profil/{$user->photo}")))
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$user->photo}"))) }}">
            @else
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
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
        <td colspan="2" style="width: 150px">
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
        <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
            <td class="td_border"  style="width: 35%">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; ">
                    {{ __('bul_mat.dom') }}
                </p>
            </td>
            <td class="td_border" style="width: 35%">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; ">
                    {{ __('bul_mat.acti') }}
                </p>
            </td>
            @php $assessmentTypes = $trimestre->assessmentTypes; @endphp
            @foreach($assessmentTypes as $assessType)
                <td class="td_border" style="width: 6%;" >
                    <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
                        {{ $assessType->name }}
                    </p>
                </td>
            @endforeach
            <td class="td_border" style="width: 6%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">SCORE</p>
            </td>
            <td class="td_border" style="width: 12%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
                    {{ __('bul_mat.appr') }}
                </p>
            </td>
            <td class="td_border" style="width: 13%;" >
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
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
                            @if($key != count($assessment->typeEvaluation)-1)
                                <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid black; padding: 2px 0; height: 20px;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                            @endif
                        @endforeach
                        <p class="s14" style="vertical-align:middle; text-align:center; padding: 2px 0; height: 20px;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                    </td>
                    @php $sum_notes_on_assessment =0; @endphp
                    @foreach($assessmentTypes as $assessType)
                        <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                            @php $sum_ratings = 0 @endphp
                            @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                                    @foreach($typeEvaluation->trimestre as $trimestre) {{-- y'a un seul trimestre ici même d'abord --}}
                                        @foreach($trimestre->assessmentType as $sequence)
                                            @if($sequence->id == $assessType->id)
                                            @if(isset($sequence->ratings->value))
                                                @php
                                                    $sum_ratings += $sequence->ratings->value;
                                                    $note = $sum_notes_on_assessment = $sequence->ratings->value;

                                                    $note_max = @$typeEvaluation->value;
                                                    $grade_img = getAppreciationSticker($note, $note_max);
                                                @endphp

                                                <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1) border-bottom: 1px solid black;@endif text-align: center;">
                                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img"))) }}">
                                                </p>
                                            @else
                                                <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1) border-bottom: 1px solid black;@endif text-align: center;">
                                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation0.png"))) }}">
                                                </p>
                                            @endif
                                                @else
                                            @endif
                                        @endforeach
                                    @endforeach
                            @endforeach
                        </td>
                    @endforeach

                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @php $sum_notes_on_typeEvaluation = 0; $nbre = 0; @endphp
                            @foreach($typeEvaluation->trimestre[0]->assessmentType as $sequence)
                                @php
                                    if(isset($sequence->ratings->value)){
                                        $sum_notes_on_typeEvaluation += $sequence->ratings->value;
                                        $nbre++;
                                    }
                                @endphp
                            @endforeach

                        @php
                            if($nbre!=0){
                                $note_trim_on_typeEvaluation = $sum_notes_on_typeEvaluation / $nbre;
                                $grade_img_for_score_trimestre = getAppreciationSticker($note_trim_on_typeEvaluation, @$typeEvaluation->value);
                            }else{
                                $grade_img_for_score_trimestre = "appreciation0.png";
                            }
                        @endphp

                            <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid black;@endif text-align: center;">
                                <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img_for_score_trimestre"))) }}">
                            </p>
                        @endforeach
                    </td>

                    <td class="td_border" style="width: 100px">
                        <p class="s14" style="text-align: center;">
                            @php $noteTotaleTrim = $nbreTrim = 0; $nbre = 0;
                                foreach($assessmentTypes as $sequence){
                                    $tmp_name_total_assessment = "total_note_assessment" . mb_substr($sequence->name, -1, 1);
                                    $noteTotaleTrim += $assessment->$tmp_name_total_assessment;

                                    if($assessment->$tmp_name_total_assessment>0) $nbre++;
                                }

                                if($nbre!=0){
                                    $grade_img_for_assessment = getAppreciationSticker($noteTotaleTrim / $nbre, $assessment->notemax);
                                }else{
                                    $grade_img_for_assessment = "appreciation0.png";
                                }

                            @endphp

                            <img class="appreciation_img" style="width: 50px; height: 50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$grade_img_for_assessment"))) }}">
                        </p>
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080"></td>
                </tr>
            @endforeach
        @endforeach
    </table>
</div>

<br>
<div style="width: 100%; display: flex; page-break-inside: avoid">
    <table style="width:58%; float:left; border-collapse: collapse;">
        <tr>
            <td rowspan="2" style="width: 20%; vertical-align: middle" class="td_border" >
                <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{!! __('bulletin_primaire.leg_br_of_grade') !!}</strong>
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    [0;10[ = {{ __('bulletin_primaire.appr_nye') }} = {{ __('bulletin_primaire.appr_nye_txt') }}
{{--                    : {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}--}}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    [10;15[ = {{ __('bulletin_primaire.appr_ae') }} = {{ __('bulletin_primaire.appr_ae_txt') }}
{{--                    : {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}--}}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    [15;18[ = {{ __('bulletin_primaire.appr_me') }} = {{ __('bulletin_primaire.appr_me_txt') }}
{{--                    : {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}--}}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    [18;20] = {{ __('bulletin_primaire.appr_abe') }} = {{ __('bulletin_primaire.appr_abe_txt') }}
{{--                    : {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}--}}
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
    <table width="40%" style="float:right; border-collapse: collapse; margin-left: 0;">
        <tr>
            @foreach($assessmentTypes as $sequence)
                <td style="vertical-align: middle" class="td_border" >
                    <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                        <strong>{{ $sequence->name }}</strong>
                    </p>
                </td>
            @endforeach
        </tr>
        <tr>
            @php $moyennes = array(); @endphp
            @foreach($assessmentTypes as $sequence)
                @php
                    $name = "moyenneSequence".mb_substr($sequence->name, -1, 1);
                    if($user->$name!=0) $moyennes[] = $user->$name;

                    $moyenne = $user->$name;

                    if($moyenne == 0) { $appreciation_img = "appreciation0.png"; $appreciation_txt = ""; }
                    else if($moyenne < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                    else if($moyenne < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                    else if($moyenne < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                    else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }

                    $moyenneColor = getAppreciationGradeAndColor($moyenne, 20);
                @endphp
                <td style="vertical-align: middle" class="td_border" >
                    <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                        <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$appreciation_img"))) }}">
{{--                        <strong>{{ $user->$name }}</strong>--}}
                    </p>
                </td>
            @endforeach
        </tr>
    </table>
</div>

<div style="margin-top: 80px">
    <table style="width: 100%; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
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
                        $moyenneTrimestre = array_sum($moyennes) / count($moyennes);

                        if($moyenneTrimestre < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                        else if($moyenneTrimestre < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                        else if($moyenneTrimestre < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                        else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }

                        $moyenneTrimestreColor = getAppreciationGradeAndColor($moyenneTrimestre, 20);
                    @endphp

                    <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$appreciation_img"))) }}">
                </p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
        </tr>
        <tr>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$moyenneTrimestreColor[1]]}}"> {{ $appreciation_txt }}</p>
            </td>
        </tr>
{{--        <tr>--}}
{{--            <td style="width: 20%;" class="td_border" >--}}
{{--                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">--}}
{{--                    {{ __('bul_mat.decision') }}:--}}
{{--                    @if($moyenneTrimestre >= 10)--}}
{{--                        <strong style="color: #{{$legend_of_grade[$moyenneTrimestreColor[1]]}}">{{ __('bul_mat.admis') }}</strong>--}}
{{--                    @else--}}
{{--                        <strong style="color: #{{$legend_of_grade[$moyenneTrimestreColor[1]]}}">{{ __('bul_mat.echoue') }}</strong>--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--            </td>--}}
{{--        </tr>--}}
    </table>
</div>

</body>
</html>
