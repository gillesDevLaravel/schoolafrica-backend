<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Report Card {{ $trimestre->name }} - {{ $user->name }}</title>
    <style type="text/css">
        body {
            padding: 10px 20px;
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

@php $legend_of_grade["ae_color"] = "ff8040"; @endphp

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
        <td style="text-align:center; background-color:green;font-size:17px;padding:5px; color:white;display:flex;" >{{ __('bul_mat.bul_notes') }}</td>
        <td style="text-align:center; background-color:red;font-size:17px;padding:5px; color:white;">{{ __('bul_mat.ensgn_franc') . " " . $trimestre->name }}</td>
        <td style="text-align:center; background-color:rgb(239, 239, 49);font-size:17px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
    </tr>
</table>

<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr>
        <td rowspan="2" style="width: 100px;">
            @if(file_exists(public_path("/public/profil/{$user->photo}")))
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$user->photo}"))) }}">
            @else
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
            @endif
        </td>
        <td colspan="2">
            <p style="font-size:14px; margin-left: 1pt; color: green"><strong>{{ $user->name }}</strong></p>
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
                {{--                {{__('bulletin_primaire.ville')}} <strong>{{ $user->city }}</strong>--}}
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
    @php $assessmentTypes = $trimestre->assessmentTypes; @endphp
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
            <td style="width: 50pt;border: 1pt solid #808080; ">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                    {{ strtoupper(__('bulletin_primaire.domain_subject')) }}
                </p>
            </td>
            <td style="width: 90pt;border: 1pt solid #808080; ">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                    {{ strtoupper(__('bulletin_primaire.description')) }}
                </p>
            </td>
            <td style=" width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                    {{ strtoupper(__('bulletin_primaire.evaluations')) }}
                </p>
            </td>
            <td style=" width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; text-align: center; font-weight: bold">
                    MKS
                </p>
            </td>
            @foreach($assessmentTypes as $assessType)
                <td class="td_border" style="width: 60%;" >
                    <p class="s10" style="font-weight: bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                        {{ strtoupper($assessType->name) }}
                    </p>
                </td>
            @endforeach
            <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>SCORE</strong>
                </p>
            </td>
            <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                    {{ strtoupper(__('bulletin_primaire.rank')) }}
                </p>
            </td>
            <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                    %S
                </p>
            </td>
            <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ strtoupper(__('bulletin_primaire.gen_avg')) }}
                </p>
            </td>
            <td style="border-right: none; border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {!! strtoupper(__('bulletin_primaire.skill_synth')) !!}
                </p>
            </td>
            <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ strtoupper('App.') }}
                </p>
            </td>
        </tr>

        @php $index_tr = 0; //index des balises tr du tableau @endphp
        @foreach($user->matterGroup as $matterGroup)
            @foreach($matterGroup->assessment as $assessment)
                <tr style="height: 16pt; @if($index_tr % 2 == 1) background-color: #e8e7e7; @endif "">
                <td style="width: 30pt;vertical-align: middle;border: 1pt solid #808080">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;font-weight: bold">{{ "(". $assessment->codeMatter .") ". $assessment->nameMatter }}</p>
                </td>
                <td style="width: 40pt; border: 1px solid #808080; vertical-align: middle;">
                    <p class="s14" style="text-align: center; margin: 0;font-size: 9px">{{ $assessment->libelleMatter }}</p>
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        @if($key != count($assessment->typeEvaluation)-1)
                            <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                        @endif
                    @endforeach
                    <p class="s14" style="vertical-align:middle; text-align:center;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                </td>
                <td style="padding-left:0pt!important; width: 3pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif text-align: center;">/{{ @$typeEvaluation->value }}</p>
                    @endforeach
                </td>
                @php $sum_notes_on_assessment =0; @endphp
                @foreach($assessmentTypes as $assessType)
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @php $sum_ratings = 0 @endphp
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trim)
                                @foreach($trim->assessmentType as $sequence)
                                    @if($sequence->id == $assessType->id)
                                        @if(isset($sequence->ratings->value))
                                            @php
                                                $sum_ratings += $sequence->ratings->value;
                                                $note = $sum_notes_on_assessment = $sequence->ratings->value;

                                                $note_max = @$typeEvaluation->value;
                                                $appreciation = getAppreciationGradeAndColor($note, $note_max);
                                            @endphp

                                            @if($key != count($assessment->typeEvaluation)-1)
                                                <p class="s14" style="font-weight:bold; border-bottom: 1px solid #808080; text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                                    {{$note}}
                                                </p>
                                            @else
                                                <p class="s14" style="font-weight:bold; text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">{{$note}}</p>
                                            @endif

                                        @else
                                            @if($key != count($assessment->typeEvaluation)-1)
                                                <p class="s14" style="border-bottom: 1px solid #808080; text-align: center;">-</p>
                                            @else
                                                <p class="s14" style="text-align: center;">-</p>
                                            @endif
                                        @endif
                                    @else
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                @endforeach

                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080">
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        @php $sum_notes_on_typeEvaluation = 0; $nbre = 0; $note_max = @$typeEvaluation->value; @endphp
                        @foreach($typeEvaluation->trimestre as $tmp_trim)
                            @if($tmp_trim->id == $trimestre->id)
                                @foreach($tmp_trim->assessmentType as $sequence)
                                    @php
                                        if(isset($sequence->ratings->value)){
                                            $sum_notes_on_typeEvaluation += $sequence->ratings->value;
                                            $nbre++;
                                        }
                                    @endphp
                                @endforeach
                            @endif
                        @endforeach

                        @php
                            if($nbre!=0){
                                $note_trim_on_typeEvaluation = $sum_notes_on_typeEvaluation / $nbre;
//                                    $grade_img_for_score_trimestre = getAppreciationSticker($note_trim_on_typeEvaluation, @$typeEvaluation->value);
                            }else{
                                $note_trim_on_typeEvaluation = "-";
//                                    $grade_img_for_score_trimestre = "appreciation0.png";
                            }

                            $appreciation_note_trim_on_typeEvaluation = getAppreciationGradeAndColor($note_trim_on_typeEvaluation, $note_max);
                        @endphp

                        <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif text-align: center; font-weight: bold; color: #{{$legend_of_grade[$appreciation_note_trim_on_typeEvaluation[1]]}}">
                            @if($note_trim_on_typeEvaluation > 0)
                                {{ number_format_if_float((float) $note_trim_on_typeEvaluation, 2) }}
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trim)
                            @if($trim->id == $trimestre->id)
                                @php $rang = @$trim->rang_trim; @endphp
                                <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif">
                                    @if(@$trim->success_percentage_trim >0 )
                                        @if(is_numeric($rang))
                                            {!! getStudentRank($rang) !!}
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </p>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 20pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trim)
                            @if($trim->id == $trimestre->id)
                                @php $appreciation = getAppreciationGradeAndColor(@$trim->success_percentage_trim, 100); @endphp
                                <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif color: #{{$legend_of_grade[$appreciation[1]]}}">
                                    @if(@$trim->success_percentage_trim >0 )
                                        {{ @$trim->success_percentage_trim }}%
                                    @else
                                        -
                                    @endif
                                </p>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 15pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                        @foreach($typeEvaluation->trimestre as $trim)
                            @if($trim->id == $trimestre->id)
                                @php $appreciation = getAppreciationGradeAndColor(@$trim->g_avg_trim, 20); @endphp
                                <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif color: #{{$legend_of_grade[$appreciation[1]]}}">
                                    @if(@$trim->g_avg_trim >0 )
                                        {{ @number_format_if_float($trim->g_avg_trim, 2) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="vertical-align: middle;width: 25pt; padding-left: 5pt; border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    @foreach($assessment->typeEvaluation[0]->trimestre as $trim)
                        @php
                            $noteOnAssessmentOnTrim = 0; $nbreSequences = 0;

                            foreach ($trim->assessmentType as $sequence){
                                $noteOnAssessmentOnTrim += @$sequence->note_on_assessment;

                                if(@$sequence->note_on_assessment > 0) $nbreSequences++;
                            }

                            if($nbreSequences > 0) $noteOnAssessmentOnTrim = $noteOnAssessmentOnTrim / $nbreSequences;
                        @endphp

                        <p style="font-size:9px; text-indent: 0pt; text-align: center;">
                            @if($nbreSequences > 0)
                                <span style="font-weight: bold; @if($noteOnAssessmentOnTrim < $assessment->notemax/2) color: red @endif"> {{ number_format_if_float($noteOnAssessmentOnTrim, 1) }}</span> /{{ $assessment->notemax }}
                                <br> {{ __('bulletin_primaire.rank') }}: {{ @$assessment->rangTrimestreActuel }}
                                <br> {{ round(@$assessment->successPercentageTrimestreActuel, 2) }} %S
                            @endif
                        </p>
                    @endforeach
                </td>
                <td style="width: 20pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    @php
                        $noteToCheck = array(); // on a déjà cette valeur plus
                        $notemaxToCkech = $assessment->notemax; // celle ci aussi est plus haut

                        foreach ($assessmentTypes as $assessmentTypeTmpl) {
                            $tmp_total_note_assess = "total_note_assessment".mb_substr($assessmentTypeTmpl->name, -1, 1);
                            ($assessment->$tmp_total_note_assess >0 ) ? $noteToCheck[] = $assessment->$tmp_total_note_assess : "";
                        }

                        $noteToCheck = safeArraySum($noteToCheck, true);

                        if($noteToCheck < $notemaxToCkech/2)
                        {
                            $grade = __('bulletin_primaire.appr_nye');
                            $grade_color = "nye_color";
                        }
                        else if($notemaxToCkech/2 <= $noteToCheck && $noteToCheck < $notemaxToCkech * (3/4)){
                            $grade = __('bulletin_primaire.appr_ae');
                            $grade_color = "ae_color";
                        }
                        else if($notemaxToCkech * (3/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (9/10)){
                            $grade = __('bulletin_primaire.appr_me');
                            $grade_color = "me_color";
                        }else{
                            $grade = __('bulletin_primaire.appr_abe');
                            $grade_color = "abe_color";
                        }
                    @endphp

                    @if($noteToCheck > 0)
                        <p class="s13" style="text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}"><strong>{{ $grade }}</strong></p>
                    @else
                        <p style="text-align: center">-</p>
                    @endif
                </td>
                </tr>
                @php $index_tr++; @endphp
            @endforeach
        @endforeach
    </table>
</div>

<br>

<div style="width: 100%; display: flex; page-break-inside: avoid">
    <table style="width:69%; padding-right:1%;float:left; border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="font-weight: bold; width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['nye_color']}}">({{__('bulletin_primaire.appr_nye')}}) {{ __('bulletin_primaire.appr_nye_txt') }} : [0;10[</span>
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['ae_color']}}">({{__('bulletin_primaire.appr_ae')}}) {{ __('bulletin_primaire.appr_ae_txt') }} : [10;15[</span>
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['me_color']}}">({{__('bulletin_primaire.appr_me')}}) {{ __('bulletin_primaire.appr_me_txt') }} : [15;18[</span>
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['abe_color']}}">({{__('bulletin_primaire.appr_abe')}}) {{ __('bulletin_primaire.appr_abe_txt') }} : [18;20]</span>
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>

    <table width="30%" style="float:right; border-collapse: collapse; margin-left: 0;">
        <tr bgcolor="#DBDBDB">
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
                    $marquer_moyenne_comme_pas_inutile_pour_trimestre = true;
                    $tmp_num = mb_substr($sequence->name, -1);
                    $name = "moyenneSequence".$tmp_num;
                    if($user->$name > 0 && isset($user->totalNoteMaxes[$tmp_num])){
                        $marquer_moyenne_comme_pas_inutile_pour_trimestre = false;
                        $moyennes[] = $user->$name;
                        $total_notes_sequences[] = $user->{"totalSequence".$tmp_num."User"};
                    }

                    $seqColor = getAppreciationGradeAndColor($user->$name, 20);
                @endphp

                <td style="vertical-align: middle; @if($marquer_moyenne_comme_pas_inutile_pour_trimestre)background-color: black; @endif" class="td_border">
                    <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold; color:#{{$legend_of_grade[$seqColor[1]]}}; ">
                        @if($user->$name > 0) {{ number_format_if_float($user->$name, 2) }} @else - @endif
                    </p>
                </td>
            @endforeach
        </tr>
    </table>
</div>

<table width="100%" style="margin-top:55px; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
    <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
        <td colspan="4" style="width: 80px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{{ __('bulletin_primaire.res_analys_trim') }}</strong>
            </p>
        </td>
        <td colspan="2" style="border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{{ __('bul_mat.visa_ens') }}</strong>
            </p>
        </td>
        <td colspan="2" style="border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{{ __('bul_mat.visa_dir') }}</strong>
            </p>
        </td>
        <td colspan="2" style="border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{{ __('bul_mat.visa_par') }}</strong>
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="width:55px;border: 1pt solid #808080">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                @php
                    $totalSequenceName = 0; $nbreTotaxSequane = 0;
                    $moyenneTrimestre = (!empty($moyennes)) ? array_sum($moyennes) / count($moyennes) : null;

                    if($moyenneTrimestre < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                    else if($moyenneTrimestre < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                    else if($moyenneTrimestre < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                    else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }

                    $nbreSequences = 0 // on remet à 0.. je veux pas savoir à quoi ça a servit jusqu'ici
                @endphp
                @foreach($assessmentTypes as $sequence)
                    @php
                        $totalSequenceTmpName = "totalSequence".mb_substr($sequence->name, -1)."User";
                        $totalSequenceName += $user->$totalSequenceTmpName;
                        if($user->$totalSequenceTmpName != 0) $nbreSequences++;
                    @endphp
                @endforeach

                @php
                    $moyenneTrimestre = $user->moyenneTrim; //(!empty($user->totalNoteMaxes)) ? $totalSequenceName*20 / safeArraySum($user->totalNoteMaxes) : null;
                    $moyenneTrimColor = getAppreciationGradeAndColor($moyenneTrimestre, 20);
                @endphp
                @if($nbreSequences > 0)
                    TOTAL: <span style="color: #{{$legend_of_grade[$moyenneTrimColor[1]]}}">
                        @if(!empty($user->totalNoteMaxes))
                            {{ number_format_if_float(safeArraySum($total_notes_sequences, true),2) }} / {{ number_format_if_float(safeArraySum($user->totalNoteMaxes, true)) }}
                        @else
                            -
                        @endif
                    </span>
                @else
                    -
                @endif
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px; border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.high_av') }}
            </p>
        </td>
        <td style="width: 27px; border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $bestMoyenneColor = getAppreciationGradeAndColor($moyenneStudents[0], 20); @endphp
                <strong style="color: #{{$legend_of_grade[$bestMoyenneColor[1]]}}">{{ number_format_if_float($moyenneStudents[0], 1) }}/20</strong>
            </p>
        </td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
    </tr>

    <tr>
        <td colspan="2" rowspan="2"  style="width: 27px;border: 1pt solid #808080; background-color: #{{$legend_of_grade[$moyenneTrimColor[1]]}}">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white; font-weight: bold">
                {{ __('bulletin_primaire.avg') }}:
                <span style="font-size:20px;">{{ round($user->moyenneTrim, 1) }}</span>/20
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.low_avg') }}
            </p>
        </td>
        <td style="width: 27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $worstMoyenneColor = getAppreciationGradeAndColor(end($moyenneStudents), 20); @endphp
                <strong style="color: #{{$legend_of_grade[$worstMoyenneColor[1]]}}">{{ number_format_if_float(end($moyenneStudents), 1) }}/20</strong>
            </p>
        </td>
    </tr>

    <tr>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.class_avg') }}
            </p>
        </td>
        <td style="width: 27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $classAverageColor = getAppreciationGradeAndColor($class_average, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$classAverageColor[1]]}}">{{ number_format_if_float($class_average, 1) }}/20</strong>
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="width: 27px;border: 1pt solid #808080">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold; color: #{{$legend_of_grade[$moyenneTrimColor[1]]}}">
                @php
                    $rang_trimestre = count(array_filter($moyennes, function($moyenneStud) use ($moyenneTrimestre) {
                        return $moyenneStud > $moyenneTrimestre;
                    })) + 1
                @endphp
                {{$moyenneTrimColor[2]}}
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 59px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                % {{ __('bulletin_primaire.success') }}
            </p>
        </td>
        <td style="width: 27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $classSuccessPercentageColor = getAppreciationGradeAndColor($class_success_percentage, 100); @endphp

                <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">{{$class_success_percentage}}%</strong>
            </p>
        </td>
    </tr>
</table>

</body>
</html>
