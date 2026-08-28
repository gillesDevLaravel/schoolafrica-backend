<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('document_list_students.title') . $class_name}}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            font-family: 'Arial', sans-serif;
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
        p{
            font-size: 18px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .verticalAlign{
            /*max-width: 20pt; !* Largeur maximale *!*/
            max-height: 100px; /* Hauteur maximale */
            height: 100px; /* Hauteur fixe */
            text-align: center; /* Centrer le texte */
            vertical-align: middle; /* Centrer verticalement */
        /*    writing-mode: vertical-rl; !* Afficher le texte verticalement *!*/
        /*    !*transform: rotate(-90deg); !* Faire pivoter le texte *!*!*/
            /*overflow: hidden; !* Caché si le texte déborde *!*/
            white-space: nowrap; /* Ne pas faire de retour à la ligne */
            padding: 1pt 5pt;
            text-indent: 0pt;
            font-size: 8px;
        /*    margin: 0;*/
        }
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;font-size: 13px">
            <strong>REPUBLIQUE DU CAMEROUN</strong> <br> <br>
            <span style="font-size: 12px">paix-travail-patrie</span> <br>
            <span style="font-size: 12px">*******</span> <br>

            <span style="font-size: 12px">Ministère de l'Education de Base</span> <br>
            <span style="font-size: 12px">Région du Centre</span> <br>
            <span style="font-size: 12px">Département du Mfoundi</span> <br>
        </td>

        <td style="width:70%; text-align:center;">
            <img style="width:40%; margin-right:10px;margin-top:-10px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
        </td>

        <td style="text-align: center; width: 40%;font-size: 13px">
            <strong>REPUBLIC OF CAMEROON</strong> <br> <br>
            <span style="font-size: 12px">peace-work-fatherland</span> <br>
            <span style="font-size: 12px">*******</span> <br>

            <span style="font-size: 12px">Ministry of basic education</span> <br>
            <span style="font-size: 12px">Center Region</span> <br>
            <span style="font-size: 12px">Mfoundi Division</span> <br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="color:#{{$code_couleurs[0]}}; text-align: center; font-size:14px; "><strong>{{ strtoupper($school->name) }}</strong></td>
    </tr>
</table>

<div style="text-align: center; font-weight: bold; font-size: 20px;">{{ __('bulletin_primaire.mark_sheet') }}</div>
<hr>

<div style="text-align: center; width: 100%; margin-top: 10px">
    <strong>{{ $assessmentType->name }} / {{ $class_name }} </strong> ({{$trimestre->name}} / 2024-2025 / {{$section->name}})
</div>

<table style="width: 100%; margin-top: 10px;">
    <tr>
        <td style="width: 100%;">
            <table style="border-collapse: collapse; margin-top: 5px;  width: 100%" cellspacing="0">
                <tr style="background-color: rgba(207, 196, 196, 0.4)">
                    <td colspan="3" style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.nouveaux') }}</strong></p>
                    </td>
                    <td colspan="3"
                        style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; padding-right: 2pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.redoublants') }}</strong></p>
                    </td>
                    <td colspan="3"
                        style=" width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>TOTAL</strong></p>
                    </td>
                </tr>

                <tr>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">M</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">F</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['nouveaux_m'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['nouveaux_f'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['nouveaux_total'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['redoublants_m'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['redoublants_f'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['redoublants_total'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['effectif_general_m'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['effectif_general_f'] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $infosGeneralesClasse['effectif_general_total'] }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="listStudents" style="border-collapse: collapse; margin-top: 20pt;  width: 100%" cellspacing="0">
    <tr>
        <td></td>
        <td></td>
        @foreach($assessments as $assessment)
        <td class="" style="width:15pt; border: 1pt solid #212628; vertical-align: middle; text-align: center">
            <span class="verticalAlign" style="vertical-align: middle;">{{ substr($assessment['codeMatter'], 0, 5) }} </span>
        </td>
        @endforeach
        <td class="" style="width:15pt; border: 1pt solid #212628; vertical-align: middle; text-align: center">
            <span class="s2 verticalAlign">TOTAL</span>
        </td>
        <td class="" style="width:20pt; border: 1pt solid #212628; vertical-align: middle; text-align: center">
            <span class="verticalAlign">{{ strtoupper(__('bulletin_primaire.avg')) }}</span>
        </td>
        <td class="" style="width:15pt; border: 1pt solid #212628; vertical-align: middle; text-align: center">
            <span class="s2 verticalAlign">R</span>
{{--            <span class="s2 verticalAlign">{{ strtoupper(__('bulletin_primaire.rank')) }}</span>--}}
        </td>
        <td class="" style="width:15pt; border: 1pt solid #212628; vertical-align: middle; text-align: center">
            <span class="s2 verticalAlign">APP.</span>
        </td>
        <td class="" style="text-align:center; max-width:15pt; border: 1pt solid #212628; vertical-align: middle;">
            <span class="verticalAlign">{{ mb_substr(strtoupper(__('bulletin_primaire.PASSED')), 0, 1) }} / {{ mb_substr(strtoupper(__('bulletin_primaire.FAILED')), 0, 1) }} </span>
        </td>
    </tr>
    <tr style="">
        <td> </td>
        <td style=" border: 1pt solid #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                <strong>{{ strtoupper(__('bulletin_primaire.note_on')) }}</strong>
            </p>
        </td>
        @foreach($assessments as $key => $assessment)
            <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                    {{ $assessment['notemax'] }}
                </p>
            </td>
        @endforeach
        <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                {{ $total_note_max }}
            </p>
        </td>
        <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">/20</p>
        </td>
        <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">{{ $effectifClasse }}</p>
        </td>
        <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle;"></td>
        <td style="width: 5pt; vertical-align: middle;"></td>
    </tr>
    <tr>
        <td></td>
        <td style="width: 5pt; border: 1pt solid #212628; vertical-align: middle; background-color: #808080; height: 3pt" colspan="{{ 6 + count($assessments) }}"></td>
    </tr>

    @php $cpt = 1; @endphp
    @foreach($students as $student)
        <tr>
            <td style="vertical-align:middle; width: 5pt;">
                <p class="s2" style=" padding-right:2pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $cpt }}</p>
            </td>
            <td style="border: 1pt solid #212628; width: 95pt!important;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; margin-left: 5pt;font-size: 12px">
                    @php
                        $name = substr($student->name, 0, 20);
                        if(strlen($student->name)>20) $name .='...'
                    @endphp

                    {{$name}}
                </p>
{{--                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; margin-left: 5pt;font-size: 12px">{{ implode(' ', $firstTwoWords) }}</p>--}}
            </td>

            @foreach($student->matterGroup as $matterGroup)
                @foreach ($matterGroup->assessment as $assessment)
                    @php $appreciation = getAppreciationGradeAndColor($assessment->$num_total_note_assessment, $assessment->notemax); @endphp

                    <td style="border: 1pt solid #212628; vertical-align: middle;">
                        <p class="s2" style="font-weight: bold; padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0; color: #{{$legend_of_grade[$appreciation[1]]}}">
                            {{ $assessment->$num_total_note_assessment ?? "-" }}
                        </p>
                    </td>
                @endforeach
            @endforeach
            <td style="width: 40pt; border: 1pt solid #212628; vertical-align: middle;">
                @php $appreciation = getAppreciationGradeAndColor($student->$numMoyenneSequence, 20); @endphp
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                    <span style="font-weight: bold">{{ $student->$numTotalSequenceUser }}</span> / {{ $student->totalNoteMax }}
                </p>
            </td>
            <td style="border: 1pt solid #212628; vertical-align: middle;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0; color: #{{$legend_of_grade[$appreciation[1]]}}">
                    {{ number_format($student->$numMoyenneSequence, 2) }}
                </p>
            </td>
            <td style="border: 1pt solid #212628; vertical-align: middle;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                    {{ $student->$num_rang_moyenneSequence }}
                </p>
            </td>
            <td style="border: 1pt solid #212628; vertical-align: middle;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0; color: #{{$legend_of_grade[$appreciation[1]]}}">
                    {{ $appreciation[0] }}
                </p>
            </td>
            <td style="border: 1pt solid #212628; vertical-align: middle;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0; @if($student->$numMoyenneSequence<10) color:red;@endif">
                    @php
                     if($student->$numMoyenneSequence >= 10) echo mb_substr(strtoupper(__('bulletin_primaire.PASSED')), 0, 1);
                     else echo mb_substr(strtoupper(__('bulletin_primaire.FAILED')), 0, 1);
                    @endphp
                </p>
            </td>
        </tr>
        @php $cpt++; @endphp
    @endforeach
</table>

<table width="100%" style="border-collapse: collapse; margin-left: 0; margin-top: 10px">
    <tr>
        <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
            <p class="s10" style="font-size:10pt; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ __('bulletin_primaire.leg_of_grade') }}
            </p>
        </td>
        <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
            <p class="s10" style="font-size:10pt; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                ({{__('bulletin_primaire.appr_nye')}}) {{ __('bulletin_primaire.appr_nye_txt') }} : [0;10[
                <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
            </p>
        </td>
        <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
            <p class="s10" style="font-size:10pt; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                ({{__('bulletin_primaire.appr_ae')}}) {{ __('bulletin_primaire.appr_ae_txt') }} : [10;15[
                <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
            </p>
        </td>
        <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
            <p class="s10" style="font-size:10pt; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                ({{__('bulletin_primaire.appr_me')}}) {{ __('bulletin_primaire.appr_me_txt') }} : [15;18[
                <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
            </p>
        </td>
        <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
            <p class="s10" style="font-size:10pt; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                ({{__('bulletin_primaire.appr_abe')}}) {{ __('bulletin_primaire.appr_abe_txt') }} : [18;20]
                <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
            </p>
        </td>
    </tr>
</table>


<div style="width: 100%; display: flex; page-break-inside: avoid">
    <div style="float:left; width: 50%">
        <div style="text-align: center; width: 100%; margin-top: 20pt;">
            <strong>{{ __('bulletin_primaire.legende') }}</strong>
        </div>

        <table style="border-collapse: collapse; font-size: 12px; width: 100%;" cellspacing="0">
            <tr style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif">
                <td style="width: 50pt; border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    CODE
                </td>
                <td style="border: 1pt solid #212628; vertical-align: middle; padding: 2pt">
                    {{ __('bulletin_primaire.matter') }}
                </td>
            </tr>
            @foreach($assessments as $assessment)
                <tr style="">
                    <td style="width: 50pt; border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                            {{ $assessment['codeMatter'] }}
                        </p>
                    </td>
                    <td style="border: 1pt solid #212628; vertical-align: middle;">
                        <p class="s2" style="padding: 2pt; text-indent: 0pt; font-size: 12px; margin: 0;">
                            {{ $assessment['nameMatter'] }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div style="float: right; width: 49%; margin-left: 1%">
        <div style="text-align: center; width: 100%; margin-top: 20pt;">
            <strong>Exam Statistics</strong>
        </div>

        <style>
            .table_header{
                width: 75pt;
                height: 25pt;
            }
        </style>

        <table style="border-collapse: collapse; font-size: 12px; width: 100%;" cellspacing="0">
            <tr style="">
                <td class="table_header" style="vertical-align: middle; text-align: center"></td>
                <td style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ __('bulletin_primaire.boys_abbr') }}</td>
                <td style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ __('bulletin_primaire.girls_abbr') }}</td>
                <td style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle;  text-align: center">T</td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle; text-align: center">{{ ucwords(strtolower(__('bulletin_primaire.total_effectif'))) }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_boys'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_girls'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_boys'] + $infosGeneralesClasse['nbre_girls'] }}</td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle; text-align: center">{{ __('bulletin_primaire.exam_sats') }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_boys_compose'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_girls_compose'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $infosGeneralesClasse['nbre_boys_compose'] + $infosGeneralesClasse['nbre_girls_compose'] }}</td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle; text-align: center">N° {{ ucwords(strtolower(__('bulletin_primaire.passed'))) }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_boys_passed'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_girls_passed'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_boys_passed'] + $exam_statistics['nbre_girls_passed'] }}</td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle; text-align: center">N° {{ ucwords(strtolower(__('bulletin_primaire.failed'))) }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_boys_failed'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_girls_failed'] }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ $exam_statistics['nbre_boys_failed'] + $exam_statistics['nbre_girls_failed'] }}</td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle; text-align: center">% {{ ucwords(strtolower(__('bulletin_primaire.passed'))) }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php
                        $total_boys = $exam_statistics['nbre_boys_passed'] + $exam_statistics['nbre_boys_failed'];
                        $effectifCompose = $infosGeneralesClasse['nbre_boys_compose'] + $infosGeneralesClasse['nbre_girls_compose']; // effectif total de ceux qui ont composé

                        $percent_boys_passed = $exam_statistics['nbre_boys_passed']*100 / $effectifCompose;
                    @endphp

                    {{ round($percent_boys_passed,2) }}%
                </td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php $percent_girls_passed = $exam_statistics['nbre_girls_passed']*100 / $effectifCompose; @endphp

                    {{ round($percent_girls_passed,2) }}%
                </td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php $percent_total_passed = ($exam_statistics['nbre_boys_passed'] + $exam_statistics['nbre_girls_passed']) * 100 / $effectifCompose; @endphp

                    {{ round($percent_total_passed,2) }}%
                </td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle;  text-align: center">% {{ ucwords(strtolower(__('bulletin_primaire.failed'))) }}</td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php $percent_boys_failed = $exam_statistics['nbre_boys_failed']*100 / $effectifCompose; @endphp

                    {{ round($percent_boys_failed,2) }}%
                </td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php $percent_girls_failed = $exam_statistics['nbre_girls_failed']*100 / $effectifCompose; @endphp

                    {{ round($percent_girls_failed,2) }}%
                </td>
                <td style="border: 1pt solid #212628; vertical-align: middle;  text-align: center">
                    @php $percent_total_failed = 100 - $percent_total_passed; @endphp

                    {{ round($percent_total_failed,2) }}%
                </td>
            </tr>
            <tr style="">
                <td class="table_header" style="background-color: @if($code_couleurs[0]) #{{$code_couleurs[0]}} @else #808080 @endif; border: 1pt solid #212628; vertical-align: middle;  text-align: center">{{ __('bulletin_primaire.class_average') }}</td>
                <td  colspan="2" class="" style="border: 1pt solid #212628; vertical-align: middle; border-right:none; text-align: center"></td>
                <td style="border: 1pt solid #212628; border-left: none; vertical-align: middle;  text-align: center">
                    {{ $infosGeneralesClasse['moyenne_generale'] }}
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
