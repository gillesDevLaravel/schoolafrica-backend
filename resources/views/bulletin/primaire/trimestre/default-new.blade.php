<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$user->name}} - {{ $trimestre->name }}</title>
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

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIQUE DU CAMEROUN <br>
                paix-travail-patrie <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                Ministère de l'éducation de Base <br><br>
                Région du Centre <br>
                Département du Mfoundi
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

<table style="width:100%; text-align: center">
    <tr style="height: 10pt;">
        <td colspan="6" style="" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.prog_rep_card') }} /
                <u>{{ __('bulletin_primaire.eng_educ') }}</u> /
                <strong>{{ $trimestre->name }}</strong> /
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
            <p style="margin-left: 1pt; color: #{{$code_couleurs[0]}}"><strong>{{ $user->name }}</strong></p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt;">Class: <strong style="color: #{{$code_couleurs[0]}}">{{ $classe->name }}</strong></p>
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
                {{__('bulletin_primaire.effectif')}}: <strong style="color: #{{$code_couleurs[0]}}">{{ $effectifClasse }}</strong> <br>
                {{__('bulletin_primaire.teacher')}}: <strong>{{ @$teacher_principal->name }}</strong>
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
                    {{ __('bulletin_primaire.domain_subject') }}
                </p>
            </td>
            <td class="td_border" style="width: 35%">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                    {{ __('bul_mat.acti') }}
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>MKS</strong>
                </p>
            </td>
            @php $assessmentTypes = $trimestre->assessmentTypes; @endphp
            @foreach($assessmentTypes as $assessType)
                <td class="td_border" style="width: 6%;" >
                    <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                        EVAL {{ $assessType->name[-1] }}
                    </p>
                </td>
            @endforeach
            <td style="border-right: 1pt solid white; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
                <p class="s10" style="color: white; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>SCORE</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ __('bulletin_primaire.rank') }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>%S</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ __('bulletin_primaire.gen_avg') }}</strong>
                </p>
            </td>
            <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{!! __('bulletin_primaire.skill_synth') !!}</strong>
                </p>
            </td>
            <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>App.</strong>
                </p>
            </td>
        </tr>

        @foreach($user->matter_groups as $matterGroup)
            <tr style="height: 10pt;">
                <td colspan="{{9+count($assessmentTypes)}}" style="background-color: #bdb3b3;height:10pt;vertical-align: middle;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;"><strong>{{ $matterGroup->name . " : " . $matterGroup->description }}</strong></p>
                </td>
            </tr>

            @foreach($matterGroup->matters as $matter)
            <tr style="height: 10pt;">
                @php
                    $notemax_matter = array();
                    foreach($matter->trimestres[0]->assessment_types as $tmp_seq){
                        foreach($tmp_seq->assessment->types_evaluations as $tmp_type_evaluation){
                            if(isset($tmp_type_evaluation->notemax) && $tmp_type_evaluation->notemax>0) $notemax_matter[] = $tmp_type_evaluation->notemax;
                        }
                    }

                    $notemax_matter = safeArraySum($notemax_matter, true) ;
                @endphp

                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">
                        {{$matter->name}}
{{--                        ({{ number_format_if_float($notemax_matter) }}mrks)--}}
                    </p>
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matter->trimestres[0]->assessment_types[0]->assessment->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        <p class="s14" style="vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->assessment_types[0]->assessment->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif">
                            {{ $tmp_type_evaluation->libelle ?? "-" }}
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matter->trimestres[0]->types_evaluations as $k => $teSurTrimestre)
                        @php $notemax_te_sur_trim = ($teSurTrimestre->nbreEvals>0) ? $teSurTrimestre->notemax : null; @endphp
{{--                        @php $notemax_te_sur_trim = ($teSurTrimestre->nbreEvals>0) ? $teSurTrimestre->notemax / $teSurTrimestre->nbreEvals : null; @endphp--}}
                        <p class="s14" style="vertical-align:middle; text-align:center;@if($k != count($matter->trimestres[0]->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif">
                            {{ (!is_null($notemax_te_sur_trim)) ? "/".number_format_if_float($notemax_te_sur_trim) : "-" }}
                        </p>
                    @endforeach


                    @php
                        $recap_notemax_te_matter = array(); // tableau des notes max des typesEvaluations de cette matière
                    @endphp
                    @foreach($matter->trimestres[0]->assessment_types[0]->assessment->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        @php
                            //TODO: on pourra améliorer ce code plus tard
                            // On va aussi déterminer la notemax du typeEvaluation sur le trimestre
                            $notemax_matter_type_evaluations = array();
                            foreach($matter->trimestres[0]->assessment_types as $tmp_tmp_seq){
                                foreach($tmp_tmp_seq->assessment->types_evaluations as $tmp_tmp_type_evaluation){
                                    if(isset($tmp_tmp_type_evaluation->notemax) && $tmp_type_evaluation->id==$tmp_tmp_type_evaluation->id)
                                        (!is_null($tmp_tmp_type_evaluation->notemax)) ? $notemax_matter_type_evaluations[] = $tmp_tmp_type_evaluation->notemax : "";
                                }
                            }

                            $notemax_matter_type_evaluation = safeArraySum($notemax_matter_type_evaluations, true) ;
                            $recap_notemax_te_matter[] = $notemax_matter_type_evaluation;
                        @endphp

{{--                        <p class="s14" style="vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->assessment_types[0]->assessment->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif">--}}
{{--                            {{ "/".number_format_if_float($recap_notemax_te_matter[$tmpKeyTypeEvaluation]) ?? "-" }}--}}
{{--                        </p>--}}
                    @endforeach
                </td>

                @foreach($matter->trimestres[0]->assessment_types as $evaluationSequence)
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                        @foreach($evaluationSequence->assessment->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                            @php $value = @$tmp_type_evaluation->rating->value; @endphp
                            <p class="s14" style="font-weight:bold; vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($evaluationSequence->assessment->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif
                            @if($value < ($notemax_matter_type_evaluation/2)) color:red @endif">
                                {{ $value ?? "-" }}
                            </p>
                        @endforeach
                    </td>
                @endforeach

                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matter->trimestres[0]->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        <p class="s14" style="font-weight:bold; vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif
                        @if(@$tmp_type_evaluation->note < ($notemax_matter_type_evaluation/2)) color:red @endif">
                            {{ (!is_null($tmp_type_evaluation->note)) ? number_format_if_float($tmp_type_evaluation->note,2) : "-" }}
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matter->trimestres[0]->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        <p class="s14" style="vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif">
                            @if(!is_null($tmp_type_evaluation->rang))
                            {!! getStudentRank($tmp_type_evaluation->rang) !!}
                            @else
                            -
                            @endif
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matter->trimestres[0]->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        @php
                            $class_success_percentage = @$tmp_type_evaluation->class_success_percentage;
                            $class_success_percentage_color = getAppreciationGradeAndColor($class_success_percentage, 100);
                        @endphp

                        <p class="s14" style="font-weight:bold; vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif color: #{{$legend_of_grade[$class_success_percentage_color[1]]}}
                           @if(@$tmp_type_evaluation->class_success_percentage < 50) color:red @endif">
                            @if($tmp_type_evaluation->class_success_percentage >  0)
                            {{ @number_format_if_float($tmp_type_evaluation->class_success_percentage, 1)."%" ?? "-" }}
                            @else
                            -
                            @endif
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matter->trimestres[0]->types_evaluations as $tmpKeyTypeEvaluation => $tmp_type_evaluation)
                        @php
                            $class_avg = @$tmp_type_evaluation->class_avg;
                            $class_avg_te_color = (!is_null($tmp_type_evaluation->nbreEvals) && $tmp_type_evaluation->nbreEvals>0)
                            ? getAppreciationGradeAndColor($class_avg, $tmp_type_evaluation->notemax/$tmp_type_evaluation->nbreEvals)
                            : getAppreciationGradeAndColor(0, 100);
                        @endphp
                        <p class="s14" style="font-weight:bold; vertical-align:middle; text-align:center;@if($tmpKeyTypeEvaluation != count($matter->trimestres[0]->types_evaluations)-1)border-bottom: 1pt solid #808080;@endif
                        @if($tmp_type_evaluation->class_avg < ($recap_notemax_te_matter[$tmpKeyTypeEvaluation]/2)) color:red @endif color: #{{$legend_of_grade[$class_avg_te_color[1]]}}">
                            @if($tmp_type_evaluation->class_avg > 0)
                            {{ @number_format_if_float($class_avg, 1) ?? "-" }}
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @php
                        $noteOnAssessmentOnTrim = $matter->trimestres[0]->total_note;
                    @endphp
                    <p style="font-size:10px; text-indent: 0pt; text-align: center;">
                        <span style="font-weight: bold;
{{--                        @if($noteOnAssessmentOnTrim < $notemax_matter/2) color: red @endif--}}
                        ">{{ number_format_if_float($noteOnAssessmentOnTrim,1) ." / ". number_format_if_float($notemax_matter) }}</span>

                        <br> {{ __('bulletin_primaire.rank') }}: @if(!is_null($matter->trimestres[0]->rang)) {!! getStudentRank($matter->trimestres[0]->rang) !!} @else - @endif

                        @if(!is_null($matter->trimestres[0]->class_success_percentage))
                        <br> <span style="@if($matter->trimestres[0]->class_success_percentage<50)color:red @endif">{{ @number_format_if_float($matter->trimestres[0]->class_success_percentage, 2)."%" }}</span>
                        @else
                        -
                        @endif
                    </p>
                </td>
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @php
                        $noteToCheck = $matter->trimestres[0]->total_note;
                        $notemaxToCkech = $notemax_matter;

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

                    <p class="s13" style="text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}"><strong>{{ $grade }}</strong></p>
                </td>
            </tr>
            @endforeach
        @endforeach
    </table>
</div>

<div style="width: 100%; display: flex; page-break-inside: avoid; margin: 5px 0px">
    <table style="width:69%; padding-right:1%;float:left; border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    ({{__('bulletin_primaire.appr_nye')}}) {{ __('bulletin_primaire.appr_nye_txt') }} : [0;10[
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    ({{__('bulletin_primaire.appr_ae')}}) {{ __('bulletin_primaire.appr_ae_txt') }} : [10;15[
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    ({{__('bulletin_primaire.appr_me')}}) {{ __('bulletin_primaire.appr_me_txt') }} : [15;18[
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    ({{__('bulletin_primaire.appr_abe')}}) {{ __('bulletin_primaire.appr_abe_txt') }} : [18;20]
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
                        <strong>EVAL {{ substr($sequence->name, -1) }}</strong>
                    </p>
                </td>
            @endforeach
        </tr>
        <tr>
            @php $moyennes = array(); @endphp
            @foreach($user->moyennes_par_trimestre->{$trimestre->id}->sequences as $sequence)
                @php $seqColor = getAppreciationGradeAndColor($sequence->moyenne, 20); @endphp
                <td style="vertical-align: middle; @if(!$sequence->isUsedForMoyenneTrimestre) background-color:black @endif" class="td_border" >
                    <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color:#{{$legend_of_grade[$seqColor[1]]}}">
                        @if(!is_null($sequence->moyenne))
                        <strong>{{ number_format_if_float($sequence->moyenne, 2) }}</strong>
                        @else
                        -
                        @endif
                    </p>
                </td>
            @endforeach
        </tr>
    </table>
</div>

<div style="margin-top: 55px">
    <table style="width: 100%; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
        <tr>
            <td colspan="4" style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bulletin_primaire.res_analys') }}</strong>
                </p>
            </td>
            <td colspan="2" style="width: 15%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bulletin_primaire.teach_sign') }}</strong>
                </p>
            </td>
            <td colspan="2" style="width: 15%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bulletin_primaire.dir_sign') }}</strong>
                </p>
            </td>
            <td colspan="2" style="width: 25%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bulletin_primaire.par_sign') }}</strong>
                </p>
            </td>
        </tr>
        <tr>
            @php
                $moyenneTrimestre = $user->moyennes_par_trimestre->{$trimestre->id}->moyenne;

                $appreciation = getAppreciationGradeAndColor($moyenneTrimestre, 20);
            @endphp

            <td colspan="2" rowspan="2"  style="width: 20%;border: 1pt solid #808080; color: white; background-color: #{{$legend_of_grade[$appreciation[1]]}}">
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ __('bulletin_primaire.avg') }}</strong>:

                    <span style="font-weight:bold;">{{ number_format_if_float($moyenneTrimestre, 2) }} /20</span>
                </p>
            </td>
            <td style="width: 15%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.high_av') }}
                </p>
            </td>
            <td style="width: 15%;border: 1pt solid #808080" >
                @php
                    $bestMoyenne = $moyenneStudents[0];
                    $gradeBestMoyenne = getAppreciationGradeAndColor($bestMoyenne, 20);
                @endphp
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeBestMoyenne[1]]}}">
                    {{ number_format_if_float($bestMoyenne, 2) }} /20
                </p>
            </td>
            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>
            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>
            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>
        </tr>
        <tr>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.low_avg') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                @php
                    $worstMoyenne = end($moyenneStudents);
                        $gradeWorstMoyenne = getAppreciationGradeAndColor($worstMoyenne, 20);
                @endphp
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeWorstMoyenne[1]]}}">
                    {{ number_format_if_float($worstMoyenne, 2) }} /20
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 20%;border: 1pt solid #808080">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    @php
                        $appreciation = getAppreciationGradeAndColor($moyenneTrimestre, 20);
                        $total_trimestre = $user->moyennes_par_trimestre->{$trimestre->id}->total_note_trimestre;
                        $total_notemax_trimestre = $user->moyennes_par_trimestre->{$trimestre->id}->total_notemax_trimestre;
                    @endphp
                    TOTAL: <span style="color: #{{$legend_of_grade[$appreciation[1]]}}">{{ number_format_if_float($total_trimestre ,2) }}</span> /{{ number_format_if_float($total_notemax_trimestre,0) }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.class_avg') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                @php
                    $classAvgColor = getAppreciationGradeAndColor($moyennesGenerales->mg, 20);
                @endphp
                <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$classAvgColor[1]]}}">
                    {{ number_format_if_float($moyennesGenerales->mg, 2) }} /20
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="width: 20%;border: 1pt solid #808080">
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bulletin_primaire.rank') }}:
                        @if(!is_null($user->moyennes_par_trimestre->{$trimestre->id}->rang))
                        {!! getStudentRank($user->moyennes_par_trimestre->{$trimestre->id}->rang) !!} / {{ $effectifClasse }}
                        @else
                        -
                        @endif
                    </strong>
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    % {{ __('bulletin_primaire.success') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    @php
                        $class_success_percentage = $moyennesGenerales->class_success_percentage;
                        $classSuccessPercentageColor = getAppreciationGradeAndColor($class_success_percentage, 100);
                    @endphp
                    <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">{{ number_format_if_float($class_success_percentage, 2) }}%</strong>
                </p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
