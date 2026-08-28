<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin Primaire Sequence - {{ $user->name }}</title>
    <style type="text/css">
        body {
            padding: 10px 20px;
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
        <td style="text-align:center; background-color:green;font-size:18px;padding:5px; color:white;display:flex;" >{{ __('bul_mat.bul_notes') }}</td>
        <td style="text-align:center; background-color:red;font-size:18px;padding:5px; color:white;">{{ __('bul_mat.ensgn_franc') . " " . $assessmentType->name }}</td>
        <td style="text-align:center; background-color:rgb(239, 239, 49);font-size:18px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
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


<div @if(file_exists(public_path("/public/profil/{$school->logo}"))) style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}'); background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%" @endif>
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr style="height: 16pt; background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
            <td style="width: 50pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.domain_subject')) }}</strong>
                </p>
            </td>
            <td style="width: 50pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.description')) }}</strong>
                </p>
            </td>
            <td style="width: 20pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.evaluations')) }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.t_mark')) }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.score')) }}</strong>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.rank')) }}</strong>
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>%S</strong>
                </p>
            </td>
            <td style="width: 5pt;border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper(__('bulletin_primaire.gen_avg')) }}</strong>
                </p>
            </td>
            <td style="width: 50pt; border: 1pt solid #808080;">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{!! strtoupper(__('bulletin_primaire.skill_synth')) !!}</strong>
                </p>
            </td>
            <td style="width: 12pt; border: 1pt solid #808080">
                <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ strtoupper("App.") }}</strong>
                </p>
            </td>
        </tr>

        @php $index_tr = 0; //index des balises tr du tableau @endphp
        @foreach($user->matterGroup as $matterGroup)
            @foreach($matterGroup->assessment as $assessment)
                <tr style="height: 16pt; @if($index_tr % 2 == 1) background-color: #e8e7e7; @endif ">
                    <td style="width: 100pt;vertical-align: middle;border: 1pt solid #808080">
                        <p class="s13" style="font-weight: bold; line-height: 109%; text-align: center; margin-left: 1pt;">{{ "(". $assessment->codeMatter .") ". $assessment->nameMatter }}</p>
                    </td>
                    <td style="width: 80pt; border: 1pt solid #808080; vertical-align: middle;">
                        <p class="s13" style="font-size:8px; text-align: center; margin: 0;">{{ $assessment->libelleMatter }}</p>
                    </td>
                    <td style="padding-left:0pt!important; width: 20pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @if($key != count($assessment->typeEvaluation)-1)
                                <p class="s14" style="text-align:center; border-bottom: 1px solid #808080; padding-left: 2pt;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                            @endif
                        @endforeach
                        <p class="s14" style="text-align:center; padding-left: 2pt; text-indent: 0pt;">{{ $typeEvaluation->libelle ?? "-" }}</p>
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt; text-align:center; border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @if($key != count($assessment->typeEvaluation)-1)
                                <p class="s14" style="border-bottom: 1px solid #808080; text-align: center">/{{ @$typeEvaluation->value }}</p>
                            @endif
                        @endforeach
                        <p class="s14" style="padding-left: 1pt; text-indent: 0pt; text-align: center">/{{ @$typeEvaluation->value }}</p>
                    </td>
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @php $sum_ratings = 0 @endphp
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $sum_ratings += @$sequence->ratings->value; @endphp
                                        @php $note = @$sequence->ratings->value; $note_max = @$typeEvaluation->value ;  @endphp
                                        @php $appreciation = getAppreciationGradeAndColor($note, $note_max); @endphp

                                        <p class="s14" style="font-weight: bold; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                            {{ @$sequence->ratings->value ?? "-" }}
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $rang = @$sequence->ratings->rang; @endphp
                                        <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif">
                                            @if(is_numeric($rang))
                                                {!! getStudentRank($rang) !!}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 30pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $appreciation = getAppreciationGradeAndColor(@$sequence->ratings->success_percentage, 100); @endphp

                                        <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif color: #{{$legend_of_grade[$appreciation[1]]}}">
                                            @if(isset($sequence->ratings->success_percentage))
                                            {{ @$sequence->ratings->success_percentage }}%
                                            @else
                                                -
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="padding-left:0pt!important; width: 30pt;border: 1pt solid #808080">
                        @foreach($assessment->typeEvaluation as $key => $typeEvaluation)
                            @foreach($typeEvaluation->trimestre as $trimestre)
                                @foreach($trimestre->assessmentType as $sequence)
                                    @if($sequence->id == $assessmentType->id)
                                        @php $appreciation = getAppreciationGradeAndColor(@$sequence->ratings->g_avg, 20); @endphp

                                        <p style="text-indent: 0pt; text-align: center; @if($key != count($assessment->typeEvaluation)-1)border-bottom: 1px solid #808080;@endif color: #{{$legend_of_grade[$appreciation[1]]}}">
                                            @if(isset($sequence->ratings->g_avg))
                                            {{ @$sequence->ratings->g_avg }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </td>
                    <td style="vertical-align: middle;width: 20pt; padding-left: 5pt; border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                        @foreach($assessment->typeEvaluation[0]->trimestre as $trimestre)
                            @foreach($trimestre->assessmentType as $sequence)
                                @if($sequence->id == $assessmentType->id)
                                    <p style="font-size: 10px; text-indent: 0pt; text-align: center;">
                                        @if($sequence->note_on_assessment >0)
                                            @php $appreciation = getAppreciationGradeAndColor($sequence->note_on_assessment, $assessment->notemax); @endphp
                                        <span style="color: #{{$legend_of_grade[$appreciation[1]]}}">{{ $sequence->note_on_assessment }}</span> /{{ $assessment->notemax }}
                                        <br> {{ __('bulletin_primaire.rank') }}: {{ @$sequence->rank_on_assessment }}
                                        <br> {{ round(@$sequence->nbreSuccessOnAssessment, 2) }} %S
                                        @else
                                            -
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td style="width: 20pt;border: 1pt solid #808080">
                        @php
                            $noteToCheck = $assessment->{"total_note_assessment".mb_substr($assessmentType->name, -1)}; //->total_note_assessment1;
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

                        @if($noteToCheck>0)
                            <p class="s13" style="font-weight: bold; text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}">{{ $grade }}</p>
                        @else
                            <p style="text-align: center">-</p>
                        @endif

                    </td>
                </tr>

                @php $index_tr++ @endphp
            @endforeach
        @endforeach
    </table>
</div>
<br>

<table width="100%" style="border-collapse: collapse; margin-left: 0;">
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

<table width="100%" style="border-collapse: collapse; margin-left: 0; margin-top: 5px; page-break-inside: avoid">
    <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
        <td colspan="4" style="width: 80px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>{{ __('bulletin_primaire.res_analys') }}</strong>
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
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php
                    $totalSequence = "totalSequence".$num_sequence."User";
                    $totalSequenceUser = $user->$totalSequence;
                    $userMoyenneColor = getAppreciationGradeAndColor($totalSequenceUser, $user->totalNoteMax);
                @endphp

                <strong>TOTAL</strong>:
                <span style="font-weight:bold; color: #{{$legend_of_grade[$userMoyenneColor[1]]}}">{{ $totalSequenceUser }} / {{ $user->totalNoteMax }}</span>
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.high_av') }}
            </p>
        </td>
        <td style="width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $bestMoyenneColor = getAppreciationGradeAndColor($first_moyenne, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$bestMoyenneColor[1]]}}">{{ number_format_if_float($first_moyenne, 2) }}/20</strong>
            </p>
        </td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
        <td colspan="2" rowspan="4" style="border: 1pt solid #808080"></td>
    </tr>
    <tr>
        @php
            $moyenneSeqName = "moyenneSequence".$num_sequence;

            $moyenneSequence = number_format_if_float($user->$moyenneSeqName, 2);

            $moyenneSequenceColor = getAppreciationGradeAndColor($moyenneSequence, 20);
        @endphp
        <td colspan="2" rowspan="2" style="width:27px;border: 1pt solid #808080; background-color: #{{$legend_of_grade[$moyenneSequenceColor[1]]}}">
            <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                {{ __('bulletin_primaire.avg') }} :
                <span style="font-size:20px;">{{ $moyenneSequence }}</span> /20
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.low_avg') }}
            </p>
        </td>
        <td style="width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $worstMoyenneColor = getAppreciationGradeAndColor($last_moyenne, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$worstMoyenneColor[1]]}}">{{ number_format_if_float($last_moyenne, 2) }}/20</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.class_avg') }}
            </p>
        </td>
        <td style="width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $classAverageColor = getAppreciationGradeAndColor($class_average, 20); @endphp
                <strong style="color: #{{$legend_of_grade[$classAverageColor[1]]}}">{{$class_average}}/20</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:27px;border: 1pt solid #808080">
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <span style="font-weight:bold; color: #{{$legend_of_grade[$userMoyenneColor[1]]}}">
                    {{ $userMoyenneColor[2] }}
                </span>
            </p>
        </td>
        <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width:59px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                % {{ __('bulletin_primaire.success') }}
            </p>
        </td>
        <td style="width:27px;border: 1pt solid #808080" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                @php $classSuccessPercentageColor = getAppreciationGradeAndColor($class_success_percentage, 100); @endphp
                <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">{{$class_success_percentage}}%</strong>
            </p>
        </td>
    </tr>
</table>

</body>
</html>
