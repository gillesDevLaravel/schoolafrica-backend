<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin Primaire séquence</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            font-size: 10px;
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
            padding-left: 1pt;
            page-break-inside: avoid;
        }

        .td_border{
            border: 1pt solid #808080;
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

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr style="height: 10pt;">
        <td >
            <p class="s10" style="font-size:15px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.prog_rep_card') }} /
                <span style="text-decoration: underline">{{ __('bulletin_primaire.eng_educ') }}</span> /
                <strong>{{ $assessmentType->name }}</strong> /
                <strong>2024/2025</strong>
            </p>
        </td>
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
            <p style="margin-left: 1pt; color:#{{$code_couleurs[0]}}"><strong>{{ $user->name }}</strong></p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt; color:#{{$code_couleurs[0]}}"><strong>{{ $classe->name }}</strong></p>
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
                {{__('bulletin_primaire.effectif')}}: <strong style="color:#{{$code_couleurs[0]}}">{{ $effectifClasse }}</strong> <br>
                {{__('bulletin_primaire.teacher')}}: {{ @$teacher_principal->name }}
            </p>
        </td>
    </tr>
</table>
<br>

<div @if(file_exists(public_path("/public/profil/{$school->logo}"))) style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}'); background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%" @endif>
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr style="height: 16pt; background-color: #{{$code_couleurs[0]}};">
            <td style=" width: 10pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{__('bul_mat.matter_group')}}
                </p>
            </td>
            <td style="height: 16pt; width: 50pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bulletin_primaire.domain_subject') }}
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bulletin_primaire.evaluations') }}
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    SCORE
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    %S
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;" >
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    {{ __('bulletin_primaire.gen_avg') }}
                </p>
            </td>
            <td style="border: 1pt solid #808080" >
                <p class="s10" style="font-weight:bold;padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    App.
                </p>
            </td>
        </tr>


        @foreach($user->matterGroup as $matterGroup)
            <tr style="height: 10pt;">
                <td rowspan="{{count($matterGroup->assessment)}}" style="width:15pt; height:10pt;vertical-align: middle;border: 1pt solid #808080;">
                    <p class="s13" style="font-weight: bold; font-size: 15px; text-align: center; margin-left: 1pt; ">
                        {{ $matterGroup->name}}
                    </p>
                </td>
                <td style="padding: 2pt; width: 100pt;vertical-align: middle;border: 1pt solid #808080;">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt; font-weight: bold; font-size: 13px">
                        {{$matterGroup->assessment[0]->libelleMatter}}
                    </p>
                </td>
                <td style="height:10pt;vertical-align: middle;border: 1pt solid #808080;">
                    @foreach($matterGroup->assessment[0]->typeEvaluation as $key => $typeEvaluation)
                        <p class="s14" style="text-align: center; @if($key != count($matterGroup->assessment[0]->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif padding: 2pt;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                    @php $sum_ratings = 0 @endphp
                    @foreach($matterGroup->assessment[0]->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trimestre)
                            @foreach($trimestre->assessmentType as $sequence)
                                @if($sequence->id == $assessmentType->id)
                                    @php $sum_ratings += @$sequence->ratings->value; @endphp
                                    @php $note = @$sequence->ratings->value; $note_max = @$matterGroup->assessment[0]->typeEvaluation[0]->value ;  @endphp

                                    <p class="s14" style="font-weight: bold; @if($key != count($matterGroup->assessment[0]->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">

                                        @php
                                            $noteSticker = (!is_null(@$sequence->ratings->value)) ? getAppreciationStickerForMaternelle(@$sequence->ratings->value) : "appreciation0.png";
                                        @endphp
                                        <img style="width:25px; height:25px; padding:2pt" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$noteSticker"))) }}">
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                    @php $sum_ratings = 0 @endphp
                    @foreach($matterGroup->assessment[0]->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trimestre)
                            @foreach($trimestre->assessmentType as $sequence)
                                @if($sequence->id == $assessmentType->id)
                                    @php $sum_ratings += @$sequence->ratings->value; @endphp
                                    @php $note = @$sequence->ratings->success_percentage; $note_max = @$matterGroup->assessment[0]->typeEvaluation[0]->value ;  @endphp

                                    <p class="s14" style="font-weight: bold; @if($key != count($matterGroup->assessment[0]->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < 50) color: red @endif">
                                        {{ @$note."%" ?? "-" }}
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                    @php $sum_ratings = 0 @endphp
                    @foreach($matterGroup->assessment[0]->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trimestre)
                            @foreach($trimestre->assessmentType as $sequence)
                                @if($sequence->id == $assessmentType->id)
                                    @php $sum_ratings += @$sequence->ratings->value; @endphp
                                    @php $note = @$sequence->ratings->value; $note_max = @$matterGroup->assessment[0]->typeEvaluation[0]->value ;  @endphp

                                    <p class="s14" style="font-weight: bold; @if($key != count($matterGroup->assessment[0]->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">
                                        @php
                                            $avgSticker = (!is_null(@$sequence->ratings->g_avg)) ? getAppreciationStickerForMaternelle(@$sequence->ratings->g_avg) : "appreciation0.png";
                                        @endphp
                                        <img style="width: 25px; height: 25px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$avgSticker"))) }}">
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </td>
                <td style="width: 20pt; vertical-align: middle;border: 1pt solid #808080; text-align: center">
                    @php
                        $noteToCheck = $matterGroup->assessment[0]->{"total_note_assessment".mb_substr($assessmentType->name, -1)};
                        $app_assessment_img = getAppreciationStickerForMaternelle($noteToCheck);
                    @endphp

                    <img style="width: 50px; height:50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$app_assessment_img"))) }}">
                </td>
            </tr>

            @foreach($matterGroup->assessment as $keyA => $assessment)
                @if($keyA!=0)
                    <tr style="height: 10pt;">
                        <td style="padding: 2pt; width: 100pt;vertical-align: middle;border: 1pt solid #808080;">
                            <p class="s13" style="font-weight: bold; font-size: 13px; line-height: 109%; text-align: center; margin-left: 1pt; font-weight: bold">
                                {{$assessment->libelleMatter}}
                            </p>
                        </td>
                        <td style="height:10pt;vertical-align: middle;border: 1pt solid #808080;">
                            @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                                <p class="s14" style="text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif padding: 2pt;">
                                    {{ $typeEvaluation->libelle ?? "-" }}
                                </p>
                            @endforeach
                        </td>
                        <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                            @php $sum_ratings = 0 @endphp
                            @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                                @foreach($typeEvaluation->trimestre as $trimestre)
                                    @foreach($trimestre->assessmentType as $sequence)
                                        @if($sequence->id == $assessmentType->id)
                                            @php $sum_ratings += @$sequence->ratings->value; @endphp
                                            @php $note = @$sequence->ratings->value; $note_max = @$assessment->typeEvaluation[0]->value ;  @endphp

                                            <p class="s14" style="font-weight: bold; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">

                                                @php
                                                    $noteSticker = (!is_null(@$sequence->ratings->value)) ? getAppreciationStickerForMaternelle(@$sequence->ratings->value) : "appreciation0.png";
                                                @endphp
                                                <img style="width:25px; height:25px; padding:2pt" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$noteSticker"))) }}">
                                            </p>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </td>
                        <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                            @php $sum_ratings = 0 @endphp
                            @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                                @foreach($typeEvaluation->trimestre as $trimestre)
                                    @foreach($trimestre->assessmentType as $sequence)
                                        @if($sequence->id == $assessmentType->id)
                                            @php $sum_ratings += @$sequence->ratings->value; @endphp
                                            @php $note = @$sequence->ratings->success_percentage; $note_max = @$assessment->typeEvaluation[0]->value ;  @endphp

                                            <p class="s14" style="font-weight: bold; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < 50) color: red @endif">
                                                {{ $note."%" ?? "-" }}
                                            </p>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </td>
                        <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                            @php $sum_ratings = 0 @endphp
                            @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                                @foreach($typeEvaluation->trimestre as $trimestre)
                                    @foreach($trimestre->assessmentType as $sequence)
                                        @if($sequence->id == $assessmentType->id)
                                            @php $sum_ratings += @$sequence->ratings->value; @endphp
                                            @php $note = @$sequence->ratings->value; $note_max = @$assessment->typeEvaluation[0]->value ;  @endphp

                                            <p class="s14" style="font-weight: bold; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">
                                                @php
                                                    $avgSticker = (!is_null(@$sequence->ratings->g_avg)) ? getAppreciationStickerForMaternelle(@$sequence->ratings->g_avg) : "appreciation0.png";
                                                @endphp
                                                <img style="width: 25px; height: 25px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$avgSticker"))) }}">
                                            </p>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </td>
                        <td style="width: 20pt; vertical-align: middle;border: 1pt solid #808080; text-align: center">
                            @php
                                $noteToCheck = $assessment->{"total_note_assessment".mb_substr($assessmentType->name, -1)};
                                $app_assessment_img = getAppreciationStickerForMaternelle($noteToCheck);
                            @endphp

                            <img style="width: 50px; height:50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$app_assessment_img"))) }}">
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </table>
</div>


<table width="100%" style="margin-top:5pt; border-collapse: collapse; margin-left: 0;">
    <tr>
        <<tr>
        <td rowspan="2" style="width: 20%; vertical-align: middle" class="td_border" >
            <p class="s10" style="font-size: 14px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{!! __('bulletin_primaire.leg_br_of_grade') !!}</strong>
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                {{ __('bulletin_primaire.appr_nye_classik') }} = {{ __('bulletin_primaire.appr_nye_txt_classik') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                {{ __('bulletin_primaire.appr_ae_classik') }} = {{ __('bulletin_primaire.appr_ae_txt_classik') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                {{ __('bulletin_primaire.appr_me_classik') }} = {{ __('bulletin_primaire.appr_me_txt_classik') }}
            </p>
        </td>
        <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
            <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                {{ __('bulletin_primaire.appr_abe_classik') }} = {{ __('bulletin_primaire.appr_abe_txt_classik') }}
            </p>
        </td>
    </tr>

    <tr>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation1.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation2.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation3.png"))) }}">
        </td>
        <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
            <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation4.png"))) }}">
        </td>
    </tr>
</table>

<br>
<table width="100%" style="border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
    <tr bgcolor="#{{$code_couleurs[0]}}">
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="font-size:15px;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.res_travail') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="font-size:15px;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.visa_ens') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="font-size:15px;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bul_mat.visa_dir') }}
            </p>
        </td>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="font-size:15px;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
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

                    if($moyenne < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt_classik'); }
                    else if($moyenne < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt_classik'); }
                    else if($moyenne < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt_classik'); }
                    else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt_classik'); }

                    $moyenne_img = getAppreciationStickerForMaternelle($moyenne);
                    $moyenne_grade = getAppreciationColorForMaternelle($moyenne);
                @endphp
                <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$moyenne_img"))) }}">
            </p>
        </td>
        <td rowspan="2" style="width: 20%;" class="td_border" ></td>
        <td rowspan="2" style="width: 20%;" class="td_border" ></td>
        <td rowspan="2" style="width: 20%;" class="td_border" ></td>
    </tr>
    <tr>
        <td style="width: 20%;" class="td_border" >
            <p class="s10" style="font-size:15px;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$moyenne_grade[0]]}}"> {{ $moyenne_grade[1] }}</p>
        </td>
    </tr>
</table>

</body>
</html>
