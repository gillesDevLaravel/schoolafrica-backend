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
                Ministere de l'education de Base <br><br>
                Region du Centre <br>
                Departement du @if($route=="kingdom") Méfou et Akono @else Mfoundi @endif
            </strong>
        </td>

        <td style="width: 70%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$school->logo}")))
                <img style="max-height: 50px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
            @endif
        </td>

        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIC OF CAMEROON <br>
                peace-work-fatherland <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                Ministry of basic education <br><br>
                Center Region<br>
                @if($route=="kingdom") Mefou et Akono @else Mfoundi @endif Division
            </strong>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%;">
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

<table width="100%" style="border-collapse: collapse; margin-left: 0; margin-bottom: 2px">
    <tr>
        <td rowspan="2" width="50px">
            @if(file_exists(public_path("/public/profil/{$user->photo}")))
                <img style="width: 50px; height: 50px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$user->photo}"))) }}">
            @else
                <img style="width: 50px; height: 50px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
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

<div @if(file_exists(public_path("/public/profil/{$school->logo}")))
         style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}');
             background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%"
    @endif>
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr style="background-color: #{{$code_couleurs[0]}};">
            <td class="td_border"  style="width: 35%; border-right-color: #ffffff;">
                <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                    {{ __('bulletin_primaire.domain_subject') }}
                </p>
            </td>
            <td class="td_border" style="width: 35%; border-right-color: #ffffff;">
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
                <td class="td_border" style="width: 6%; border-right-color: #ffffff;" >
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
                    {{--                    <strong>{{ "POS." }}</strong>--}}
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>%S</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ strtoupper(__('bulletin_primaire.gen_avg')) }}</strong>
                </p>
            </td>
            <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>SYN.</strong>
                    {{--                    <strong>{!! __('bulletin_primaire.skill_synth') !!}</strong>--}}
                </p>
            </td>
            <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>APP.</strong>
                </p>
            </td>
        </tr>

        @foreach($user->matterGroup as $matterGroup)
            <tr style="height: 10pt;">
                <td colspan="{{9+count($assessmentTypes)}}" style="background-color: #bdb3b3;height:10pt;vertical-align: middle;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;"><strong>{{ $matterGroup->name . " : " . $matterGroup->description }}</strong></p>
                </td>
            </tr>
            @foreach($matterGroup->assessment as $assessment)
                <tr style="height: 16pt;">
                    <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                        <p class="s13" style="text-align: center; margin: 0; font-weight: bold">
                            {{$assessment->libelleMatter}}
                            {{--                            ({{ number_format_if_float($assessment->notemax, 1) }}mrks)--}}
                        </p>
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            <p class="s14" style="vertical-align:middle; text-align:center;@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif">{{ $typeEvaluation->libelle ?? "-" }}</p>
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            <p class="s14" style="vertical-align:middle; text-align:center;@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif">/{{ @$typeEvaluation->value }}</p>
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
                                                    $grade_img = getAppreciationSticker($note, $note_max);
                                                @endphp

                                                <p class="s14" style="font-weight:bold;  @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">
                                                    {{$note}}
                                                </p>

                                            @else
                                                @if($key != count($assessment->typeEvaluation)-1)
                                                    <p class="s14" style=" border-bottom: 1pt solid #808080; text-align: center;">-</p>
                                                @else
                                                    <p class="s14" style=" text-align: center;">-</p>
                                                @endif
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
//                                    $grade_img_for_score_trimestre = getAppreciationSticker($note_trim_on_typeEvaluation, @$typeEvaluation->value);
                                }else{
//                                    $grade_img_for_score_trimestre = "appreciation0.png";
                                    $note_trim_on_typeEvaluation = null;
                                }
                            @endphp

                            <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif text-align: center; font-weight: bold;">
                                @if(!is_null($note_trim_on_typeEvaluation))
                                    {{ number_format_if_float($note_trim_on_typeEvaluation, 2) }}
                                @else
                                    -
                                @endif
                            </p>
                        @endforeach
                    </td>

                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trim)
                                @if($trim->id == $trimestre->id)
                                    @php $rang = @$trim->rang_trim; @endphp
                                    <p class="s14" style="@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center;">
                                        @if($trim->g_avg_trim > 0)
                                            {!! getStudentRank($rang) !!}
                                        @else
                                            -
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trim)
                                @if($trim->id == $trimestre->id)
                                    @php $appreciation = getAppreciationGradeAndColor(@$trim->success_percentage_trim, 100); @endphp
                                    <p class="s14" style="font-weight:bold;@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                        @if($trim->success_percentage_trim > 0)
                                            {{ @number_format_if_float($trim->success_percentage_trim, 1) }}%
                                        @else
                                            -
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trim)
                                @if($trim->id == $trimestre->id)
                                    @php $appreciation = getAppreciationGradeAndColor(@$trim->g_avg_trim, 20); @endphp
                                    <p class="s14" style="font-weight: bold;@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                        @if($trim->g_avg_trim > 0)
                                            {{ @number_format_if_float($trim->g_avg_trim, 2) ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td style="vertical-align: middle;width: 25pt; padding-left: 5pt; border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation[0]->trimestre as $trim)
                            @php
                                $noteOnAssessmentOnTrim = 0; $nbreSequences = 0;

                                foreach ($trim->assessmentType as $sequence){
                                    $noteOnAssessmentOnTrim += @$sequence->note_on_assessment;

                                    if(@$sequence->note_on_assessment > 0) $nbreSequences++;
                                }

                                if($nbreSequences > 0) $noteOnAssessmentOnTrim = $noteOnAssessmentOnTrim / $nbreSequences;
                            @endphp

                            <p style="text-indent: 0pt; text-align: center;">
                                @if($noteOnAssessmentOnTrim > 0)
                                    <span style="font-weight: bold; @if($noteOnAssessmentOnTrim < $assessment->notemax/2) color: red @endif">{{ number_format_if_float($noteOnAssessmentOnTrim, 1)." / ".$assessment->notemax }}</span>
                                    {{--                                    <br> {{ "Pos" }}: {!! @getStudentRank($assessment->rangTrimestreActuel) !!}--}}
                                    <br> {{ __('bulletin_primaire.rank') }}: {{ @$assessment->rangTrimestreActuel }}
                                    <br> {{ number_format_if_float(@$assessment->successPercentageTrimestreActuel, 1) }}% S
                                @else
                                    -
                                @endif
                            </p>
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @php
                            $noteToCheck = 0;
                            $notemaxToCkech = $assessment->notemax;

                            $nbreSequences = 0;
                            foreach ($trimestre->assessmentTypes as $seq) {
                                $tmp_total_note_assess = "total_note_assessment".mb_substr($seq->name, -1);
                                $noteToCheck += $assessment->$tmp_total_note_assess;

                                if($assessment->$tmp_total_note_assess > 0) $nbreSequences++;
                            }

                            if($nbreSequences > 0) $noteToCheck = $noteToCheck / $nbreSequences;

                            if($noteToCheck < $notemaxToCkech/2)
                            {
                                $grade = __('bulletin_primaire.appr_nye_classik');
                                $grade_color = "nye_color";
                            }
                            else if($notemaxToCkech/2 <= $noteToCheck && $noteToCheck < $notemaxToCkech * (3/4)){
                                $grade = __('bulletin_primaire.appr_ae_classik');
                                $grade_color = "ae_color";
                            }
                            else if($notemaxToCkech * (3/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (9/10)){
                                $grade = __('bulletin_primaire.appr_me_classik');
                                $grade_color = "me_color";
                            }else{
                                $grade = __('bulletin_primaire.appr_abe_classik');
                                $grade_color = "abe_color";
                            }
                        @endphp

                        <p class="s13" style="text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}; font-weight: bold">
                            @if($noteToCheck > 0)
                                {{ $grade }}
                            @else
                                -
                            @endif
                        </p>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </table>
</div>

<div style="width: 100%; display: flex; page-break-inside: avoid; margin: 3px 0px;">
    <table style="width:517px; padding-right:1%;float:left; border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    ({{__('bulletin_primaire.appr_nye_classik')}}) {{ __('bulletin_primaire.appr_nye_txt_classik') }} : [0;10[
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    ({{__('bulletin_primaire.appr_ae_classik')}}) {{ __('bulletin_primaire.appr_ae_txt_classik') }} : [10;15[
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    ({{__('bulletin_primaire.appr_me_classik')}}) {{ __('bulletin_primaire.appr_me_txt_classik') }} : [15;18[
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    ({{__('bulletin_primaire.appr_abe_classik')}}) {{ __('bulletin_primaire.appr_abe_txt_classik') }} : [18;20]
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>

    <table width="220px" style="float:right; border-collapse: collapse; margin-left: 0;">
        <tr bgcolor="#DBDBDB">
            @foreach($assessmentTypes as $sequence)
                <td style="vertical-align: middle" class="td_border" >
                    <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                        <strong>{{ "EVAL " . substr($sequence->name, -1) }}</strong>
                    </p>
                </td>
            @endforeach
        </tr>
        <tr>
            @php $moyennes = array(); $total_notes_sequences = array(); @endphp
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

<div style="width: 100%; margin-top: 51px">
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
                $moyenneTrimestre = array_sum($moyennes) / count($moyennes);

                if($moyenneTrimestre < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt_classik'); }
                else if($moyenneTrimestre < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt_classik'); }
                else if($moyenneTrimestre < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt_classik'); }
                else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt_classik'); }

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
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeBestMoyenne[1]]}}">
                    {{ number_format_if_float($bestMoyenne, 2) }} /20
                </p>
            </td>
            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080; text-align: center; vertical-align: middle;">
                @if($route=="abiscoms" && !is_null(@$teacher_principal->photo) && file_exists(public_path("/public/profil/{$teacher_principal->photo}")))
                    <img style="max-height: 65px; max-width: 70px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$teacher_principal->photo}"))) }}">
                @endif
            </td>
            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080; text-align: center; vertical-align: middle">
                @php $sign_dir_abiscoms = "sign-directeur-abiscoms.png"; @endphp
                @if($route=="abiscoms" && file_exists(public_path("/public/profil/{$sign_dir_abiscoms}")))
                    <img style="max-height: 65px; max-width: 70px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$sign_dir_abiscoms}"))) }}">
                @endif
            </td>
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
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeWorstMoyenne[1]]}}">
                    {{ number_format_if_float($worstMoyenne, 2) }} /20
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="width: 20%;border: 1pt solid #808080">
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">

                    @php
                        $moyenneTrimestre = safeArraySum($moyennes, true);

                        if($moyenneTrimestre < 10) { $appreciation_img = "appreciation1.png"; $appreciation_txt = __('bulletin_primaire.appr_nye_txt_classik'); }
                        else if($moyenneTrimestre < 15) { $appreciation_img = "appreciation2.png"; $appreciation_txt = __('bulletin_primaire.appr_ae_txt_classik'); }
                        else if($moyenneTrimestre < 18) { $appreciation_img = "appreciation3.png"; $appreciation_txt = __('bulletin_primaire.appr_me_txt_classik'); }
                        else { $appreciation_img = "appreciation4.png"; $appreciation_txt = __('bulletin_primaire.appr_abe_txt_classik'); }
                    @endphp

                    @php $appreciation = getAppreciationGradeAndColor($moyenneTrimestre, 20); @endphp
                    TOTAL: <span style="color: #{{$legend_of_grade[$appreciation[1]]}}">{{ number_format_if_float(safeArraySum($total_notes_sequences, true),2) }}</span> /{{ number_format_if_float($user->totalNoteMax) }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.class_avg') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                @php
                    $classAvgColor = getAppreciationGradeAndColor($class_average, 20);
                @endphp
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$classAvgColor[1]]}}">
                    {{ number_format_if_float($class_average, 2) }} /20
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="width: 20%;border: 1pt solid #808080">
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{--                    <strong>{{ "Pos. " }}: {!! getStudentRank($user->rangTrim) !!} / {{ $effectifClasse }}</strong>--}}
                    <strong>{{ __('bulletin_primaire.rank') }}: {!! getStudentRank($user->rangTrim) !!} / {{ $effectifClasse }}</strong>
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    % {{ __('bulletin_primaire.success') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    @php $classSuccessPercentageColor = getAppreciationGradeAndColor($class_success_percentage, 100); @endphp
                    <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">{{ number_format_if_float($class_success_percentage, 2) }}%</strong>
                </p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
