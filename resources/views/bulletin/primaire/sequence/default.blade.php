<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$user->name}} - {{ $assessmentType->name }}</title>
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
            <img style="max-height: 75px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
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

<div @if(file_exists(public_path("/public/profil/{$school->logo}"))) style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}'); background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%" @endif>
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr style="height: 16pt; background-color: #{{$code_couleurs[0]}};">
            <td style="height: 16pt; width: 50pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ __('bulletin_primaire.domain_subject') }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>{{ __('bul_mat.acti') }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                    <strong>MKS</strong>
                </p>
            </td>
            <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
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

        @foreach($user->matterGroup as $matterGroup)
            <tr style="height: 10pt;">
                <td colspan="9" style="background-color: #bdb3b3;height:10pt;vertical-align: middle;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;"><strong>{{ $matterGroup->name . " : " . $matterGroup->description }}</strong></p>
                </td>
            </tr>
            @foreach($matterGroup->assessment as $assessment)
                <tr style="height: 16pt;">
                    <td style="padding: 2pt; width: 100pt;vertical-align: middle;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;">
                            <strong>{{$assessment->libelleMatter}} ({{$assessment->notemax}}mrks)</strong>
                        </p>
                    </td>
                    <td style="padding-left:0pt!important;width: 10pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @if($key != count($assessment->typeEvaluation)-1)
                            <p class="s14" style="text-align: center; border-bottom: 1px solid black; padding-left: 2pt;">
                                {{ $typeEvaluation->libelle ?? "-" }}
                            </p>
                            @endif
                        @endforeach
                        <p class="s14" style="text-align: center; padding-left: 2pt; text-indent: 0pt;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @if($key != count($assessment->typeEvaluation)-1)
                                <p class="s14" style="border-bottom: 1px solid black; text-align: center">/{{ @$typeEvaluation->value }}</p>
                            @endif
                        @endforeach
                        <p class="s14" style="padding-left: 1pt; text-indent: 0pt; text-align: center">/{{ @$typeEvaluation->value }}</p>
    {{--                    <p style="text-indent: 0pt; text-align: center;">/{{ $assessment->typeEvaluation[0]->value }}</p>--}}
                    </td>
                    <td style="padding-left:0pt!important; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @php $sum_ratings = 0 @endphp
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @if($key != count($assessment->typeEvaluation)-1)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $sum_ratings += @$sequence->ratings->value; @endphp
                                        @php $note = @$sequence->ratings->value; $note_max = @$assessment->typeEvaluation[0]->value ;  @endphp

                                        <p class="s14" style="font-weight: bold;border-bottom: 1px solid black; text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">{{ @$sequence->ratings->value ?? "-" }}</p>
                                    @endif
                                @endforeach
                            @endforeach
                            @else
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $sum_ratings += @$sequence->ratings->value; @endphp
                                        @php $note = @$sequence->ratings->value; $note_max = @$assessment->typeEvaluation[0]->value ;  @endphp

                                        <p class="s14" style="font-weight: bold;text-align: center; @if($note < @$typeEvaluation->value/2) color: red @endif">{{ @$sequence->ratings->value ?? "-" }}</p>
                                    @endif
                                @endforeach
                            @endforeach
                            @endif
                        @endforeach
    {{--                    <p class="s14" style="text-align: center; @if($note < $note_max/2) color: red @endif">{{ $sequence->ratings->value ?? "-" }}</p>--}}
                    </td>
                    <td style="padding-left:0pt!important; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $rang = @$sequence->ratings->rang; @endphp
                                        <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid black;@endif">
                                            @if($rang != "-")
                                                {!! getStudentRank($rang) !!}
{{--                                                @if($rang==1) {{$rang}}<sup>er</sup> @else {{$rang}}<sup>e</sup> @endif --}}
                                            @else - @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 30pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $appreciation = getAppreciationGradeAndColor(@$sequence->ratings->success_percentage, 100); @endphp
                                        <p style="font-weight:bold;text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}};@if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid black;@endif @if(@$sequence->ratings->success_percentage < 50) color: red @endif">
                                            @if(@$sequence->ratings->success_percentage > 0)
                                            {{ @$sequence->ratings->success_percentage."%" ?? "-" }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 30pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $appreciation = getAppreciationGradeAndColor(@$sequence->ratings->g_avg, 20); @endphp
                                        <p style="font-weight:bold; text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid black @endif; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                            @if(@$sequence->ratings->g_avg > 0)
                                                {{ @number_format_if_float($sequence->ratings->g_avg, 1) }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="vertical-align: middle;width: 10pt; padding-left: 5pt; border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation[0]->trimestre as $trimestre)
                            @foreach($trimestre->assessmentType as $sequence)
                                @if($sequence->id == $assessmentType->id)
                                    <p style="text-indent: 0pt; text-align: center;">
                                        @if(!is_null($sequence->note_on_assessment) && !is_null($sequence->nbreSuccessOnAssessment))
                                        <span style="font-weight: bold; @if($sequence->note_on_assessment < $assessment->notemax/2) color: red @endif">{{ $sequence->note_on_assessment }} / {{ $assessment->notemax }}</span>
                                        <br> {{ __('bulletin_primaire.rank') }}: {{ @$sequence->rank_on_assessment }}
                                        <br> {{ round(@$sequence->nbreSuccessOnAssessment, 2)."%S" ?? "-" }}
                                        @else
                                        -
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td style="width: 20pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @php
                            $noteToCheck = $assessment->{"total_note_assessment".mb_substr($assessmentType->name, -1)};
                            $notemaxToCkech = $assessment->notemax;

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
                        <p class="s13" style="font-weight:bold; text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}">
                            @if(!is_null($noteToCheck) && $noteToCheck > 0)
                            {{ $grade }}
                            @else
                            -
                            @endif
                        </p>
    {{--                    <p class="s13" style="text-indent: 0pt; text-align: center;"><strong>{{ $sequence->grade_on_assessment }}</strong></p>--}}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </table>
</div>

<table width="100%" style="border-collapse: collapse; margin-left: 0; margin: 2px 0px">
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

<table width="100%" style="border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
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
            $moyenneSeqName = "moyenneSequence".$num_sequence;
            $totalSequence = "totalSequence".$num_sequence."User";

            $moyenneSequence = number_format_if_float($user->$moyenneSeqName, 2);

            $moyenneSequenceColor = getAppreciationGradeAndColor($moyenneSequence, 20);
        @endphp
        <td colspan="2" rowspan="2"  style="width: 20%;border: 1pt solid #808080; color: white; background-color: #{{$legend_of_grade[$moyenneSequenceColor[1]]}}">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>{{ __('bulletin_primaire.avg') }}</strong>:
                <span style="font-weight:bold;">{{ $moyenneSequence }}/20</span>
            </p>
        </td>
        <td style="width: 15%;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.high_av') }}
            </p>
        </td>
        <td style="width: 15%;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $bestMoyenneColor = getAppreciationGradeAndColor($first_moyenne, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$bestMoyenneColor[1]]}}">{{ number_format_if_float($first_moyenne, 2) }} / 20</strong>
{{--                <strong>{{ $first_moyenne }}/20</strong>--}}
            </p>
        </td>
{{--        <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>--}}
{{--        <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>--}}
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
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $worstMoyenneColor = getAppreciationGradeAndColor($last_moyenne, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$worstMoyenneColor[1]]}}">{{ number_format_if_float($last_moyenne, 2) }} / 20</strong>
{{--                <strong>{{$last_moyenne}}/20</strong>--}}
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="width: 20%;border: 1pt solid #808080">
            <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php
                    $totalSequenceUser = $user->$totalSequence;
                    $userMoyenneColor = getAppreciationGradeAndColor($totalSequenceUser, $user->totalNoteMax);
                @endphp
                TOTAL: <span style="font-weight:bold; color: #{{$legend_of_grade[$userMoyenneColor[1]]}}">{{ $totalSequenceUser }}</span> /{{ $user->totalNoteMax }}
            </p>
        </td>
        <td style="width: 20%;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.class_avg') }}
            </p>
        </td>
        <td style="width: 20%;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $classAverageColor = getAppreciationGradeAndColor($class_average, 20); @endphp
                <strong style="font-weight:bold;color: #{{$legend_of_grade[$classAverageColor[1]]}}">{{$class_average}}/20</strong>
            </p>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="width: 20%;border: 1pt solid #808080">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php
                    $rang_moyenneSequence = "rang_moyenneSequence$num_sequence";
                @endphp
                @if(!is_null($user->$rang_moyenneSequence))
                <strong>{{ __('bulletin_primaire.rank') }}: {{ $user->$rang_moyenneSequence }} / {{ $effectifClasse }}</strong>
                @else
                -
                @endif
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
                <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">{{$class_success_percentage}}%</strong>
            </p>
        </td>
    </tr>
</table>

</body>
</html>
