<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin Secondaire séquence - {{ $user->name }}</title>
    <style type="text/css">
        body {
            padding: 5px 30px;
            font-size: 11px;
            /*font-family: Arial, sans-serif;*/
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        p {
            color: #202429;
            /*font-family: Arial, sans-serif;*/
            font-style: normal;
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
            margin: 0pt;
        }

        .s1 {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s2 {
            color: #202429;
            font-family: Arial, sans-serif;
            /*font-style: normal;*/
            /*font-weight: bold;*/
            text-decoration: none;
            font-size: 8pt;
        }

        .s3 {
            color: #202429;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s4 {
            color: #f44336;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
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
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            REPUBLIQUE DU CAMEROUN <br>
            <strong><i>Paix - Travail - Patrie</i></strong>
            <div style="margin-top: 1pt;">**************</div>
            MINISTERE DES ENSEIGNEMENTS SECONDAIRES <br>
            <div style="margin-top: 1pt;">**************</div>
            <strong>DELEGATION REGIONALE DE ........... </strong><br>
            <div style="margin-top: 1pt;">**************</div>
            DELEGATION DEPARTEMENTALE DE ........... <br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($school->name) }}<br>
        </td>

        <td style="width: 35%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$school->logo}")))
            <img style="width: 50%; margin-right: 10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$school->logo}"))) }}">
            @endif
        </td>

        <td style="text-align: center; width: 40%;">
            REPUBLIC OF CAMEROON <br>
            <strong><i>Peace - Work - Fatherland</i></strong>
            <div style="margin-top: 1pt;">**************</div>
            MINISTRY OF SECONDARY EDUCATION <br>
            <div style="margin-top: 1pt;">**************</div>
            <strong>REGIONAL DELEGATION OF ........... </strong><br>
            <div style="margin-top: 1pt;">**************</div>
            DIVISIONAL DELEGATION ........... <br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($school->name) }}<br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin: 1pt 0">
    <tr>
        <td style="text-align: center; font-size: 12pt"><strong>{{ __('bulletin_secondaire.bul_sec_seq') }} </strong></td>
{{--        <td style="text-align: center; font-size: 12pt"><strong>BULLETIN SCOLAIRE DE SEQUENCE {{ strtoupper($periode->name) }}  </strong></td>--}}
    </tr>

    <tr>
        <td>{{ __('bulletin_secondaire.school_year') }}: 2024 / 2025</td>
    </tr>
</table>


<table style="width: 100%; margin-top: 5px; text-align: left">
    <tr>
        <td style="width: 15%; align-items: center; justify-content: center;">
            @if(file_exists(public_path("/public/profil/{$user->photo}")))
                <img style="margin: 5px 0; width: 100%; max-height: 100%;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path('/public/profil/'.$user->photo))) }}">
            @else
                <img style="margin: 5px 0; width: 100%; max-height: 100%;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path('/public/profil/user.jpg'))) }}">
            @endif
        </td>

        <td style="width: 85%;">
            <table style="border-collapse: collapse;width: 100%" cellspacing="0">
                <tr>
                    <td colspan="3" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_secondaire.nom_prenom') }}: <strong>{{ strtoupper($user->name) }}</strong> </p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_secondaire.class') }}: <strong>{{ strtoupper($user->classe) }}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1pt solid #212628">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">
                            {{ __('bulletin_secondaire.date_birth_place') }}:
                            @php
                                $dateString = $user->birthday;
                                $date = new DateTime($dateString);
                                $formattedDate = $date->format('d / m / Y');
                            @endphp

                            <strong>{{ $formattedDate }}</strong> {{ __('bulletin_secondaire.at') }} <strong>{{ $user->placeofbirth }}</strong>
                        </p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_secondaire.gender') }}: <strong>{{ ($user->gender=="Male") ? "M" : "F" }}</strong></p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_primaire.effectif') }}: <strong>{{ $effectifClasse }}</strong> </p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 185pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_secondaire.id_num') }}: <strong>{{ $user->matricule }}</strong> </p>
                    </td>
                    <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">
                            {{ __('bulletin_primaire.repeater') }}:
                            {{ __('bulletin_primaire.oui') }} <input type="checkbox" style="height: 10pt; margin-bottom: 2pt;" @if($user->repeater) checked @endif>
                            {{ __('bulletin_primaire.non') }} <input type="checkbox" style="height: 10pt; margin-bottom: 2pt;" @if(!$user->repeater) checked @endif>
                        </p>
                    </td>
                    <td rowspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">{{ __('bulletin_secondaire.main_teacher') }}:
                            <br>
                            <strong>{{ @$teacher_principal->name }}</strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 50px; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; margin-left: 2pt; text-align: left;">
                            {{ __('bulletin_secondaire.tutor_name') }}:
                            <strong>{{ $user->father }}</strong> / <strong>{{ $user->phone }}</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    <div @if(file_exists(public_path("/public/profil/filigranne.jpeg")))
             style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/filigranne.jpeg"))) }}');
             background-repeat: no-repeat; background-position: center; background-size: cover; z-index: -1; opacity: 0.25; background-size: 60%"
        @endif
    >
        <table style="border-collapse: collapse; margin-top: 15px;  width: 100%" cellspacing="0">
            <tr>
                <td style="width:100pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>{{ __('bulletin_secondaire.matter_group') }}</strong></p>
                </td>
                <td style="width:150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>{{ __('bulletin_secondaire.comp_eval') }}</strong></p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>N/20</strong></p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>M/20</strong></p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>Coef</strong></p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>M * Coef</strong></p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>Cote</strong></p>
                </td>
                <td style="width: 40pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>[Min - Max]</strong></p>
                </td>
                <td style="width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>{!! __('bulletin_secondaire.app_and_teacher_visa') !!}</strong></p>
                </td>
            </tr>

            @php $total_note_coef = 0; $total_coef = 0; @endphp
            @foreach($user->trimestre[0]->assessmentType[0]->matterGroup as $matterGroup)
                <tr style="">
                    <td style="page-break-inside: avoid !important; vertical-align: middle; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-align: center;"><strong>{{ $matterGroup->name }}</strong></p>
                    </td>
                    <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        @foreach($matterGroup->assessment as $key => $assessment)
                            @if($key != count($matterGroup->assessment)-1)
                                <p class="s14" style="padding-top: 4pt; text-align: center; border-bottom: 1px solid black; "><strong>{{ $assessment->nameMatter ?? "-" }}</strong></p>
                            @endif
                        @endforeach
                        <p class="s14" style="padding-top: 4pt; text-align: center; text-indent: 0pt;"><strong>{{ $assessment->nameMatter ?? "-" }}</strong></p>
                    </td>
                    <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        @foreach($matterGroup->assessment as $key => $assessment)
                            @if($key != count($matterGroup->assessment)-1)
                                <p class="s14" style="padding-top: 4pt; text-align: center; border-bottom: 1px solid black; "><strong>{{ $assessment->ratings->value ?? "-" }}</strong></p>
                            @endif
                        @endforeach
                        <p class="s14" style="padding-top: 4pt; text-align: center; padding-left: 2pt; text-indent: 0pt;"><strong>{{ $assessment->ratings->value ?? "-" }}</strong></p>
                    </td>
                    <td style="vertical-align: middle; width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        @if(count($matterGroup->assessment)>=1)
                            <p class="s2" style="padding-top: 4pt; text-align: center;">{{ round($matterGroup->totalNoteByMatterGroup / count($matterGroup->assessment), 2) }}</p>
                        @else
                            <p class="s2" style="padding-top: 4pt; text-align: center;">{{ round($matterGroup->totalNoteByMatterGroup, 2) }}</p>
                        @endif
                    </td>
                    <td style="vertical-align: middle; width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $matterGroup->totalCoefMatterGroupAssessment }}</p>
                    </td>
                    <td style="vertical-align: middle; width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-align: center;">{{ $matterGroup->totalNoteCoefByMatterGroup }}</p>
                    </td>
                    <td style="vertical-align: middle; width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-align: center;">000</p>
                    </td>
                    <td style="vertical-align: middle; width: 40pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        @php
                            $min = $notesPerMatterGroup[$matterGroup->id]['min'];
                            $max = $notesPerMatterGroup[$matterGroup->id]['max'];
                        @endphp
                        <p class="s2" style="padding-top: 4pt; text-align: center;">[{{$min}} - {{$max}}]</p>
                    </td>
                    <td style="vertical-align: middle; width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-align: center;"></p>
                    </td>
                </tr>
            @endforeach
        </table>

        <table style="margin-top: 18pt; border-collapse: collapse; width: 100%" cellspacing="0">
            <tr>
                <td colspan="4" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>{{ __('bulletin_secondaire.discipline') }}</strong></p>
                </td>
                <td colspan="4" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>{{ __('bulletin_secondaire.stud_work') }}</strong></p>
                </td>
                <td colspan="2" style="width:150px; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;"><strong>{{ __('bulletin_secondaire.class_profile') }}</strong></p>
                </td>
            </tr>

            <tr>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">{{ __('bulletin_secondaire.abs_non_j') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $absences_non_j }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.aver_cond') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $avertiss_conduite }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.tot_gen') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $user->trimestre[0]->assessmentType[0]->totalSequenceNoteCoef }}</p>
                </td>
                <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>APPRECIATION</strong></p>
                </td>
                <td style="width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>{{ __('bulletin_secondaire.gen_avg') }}</strong></p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $moyenne_generale_classe }}</p>
                </td>
            </tr>

            <tr>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">{{ __('bulletin_secondaire.abs_j') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $absences_j }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.blam_cond') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $blame_conduite }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">COEF</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $user->trimestre[0]->assessmentType[0]->totalSequenceCoef }}</p>
                </td>
                <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <table style=" border-collapse: collapse; width: 100%" cellspacing="0">
                        <tr>
                            <td style="padding-left: 2pt; border-top-color: #212628; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                                <span style="padding-left: 2pt">CTBA</span>
                            </td>
                            <td style="width: 20pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628;">
                                <span style="padding-left: 2pt"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                                <span style="padding-left: 2pt">CBA</span>
                            </td>
                            <td style="width: 20pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; ">
                                <span style="padding-left: 2pt"></span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"><strong>[Min - Max]</strong></p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">[{{$last_moyenne}} - {{$first_moyenne}}]</p>
                </td>
            </tr>

            <tr>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">{{ __('bulletin_secondaire.nbre_retards') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $retards }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.exclu_jrs') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $exclusions_jour }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.moy_seq') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center"><strong>{{ $user->trimestre[0]->assessmentType[0]->moyenne }}</strong></p>
                </td>
                <td colspan="2" style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <table style="border-collapse: collapse; width: 100%" cellspacing="0">
                        <tr>
                            <td style="border-top-color: #212628; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                                <span style="padding-left: 2pt">CA</span>
                            </td>
                            <td style="width: 20pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628;"></td>
                        </tr>
                        <tr>
                            <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                                <span style="padding-left: 2pt">CMA</span>
                            </td>
                            <td style=" width: 20pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; "></td>
                        </tr>
                    </table>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.nbre_moy') }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $nbre_moyennes }}</p>
                </td>
            </tr>

            <tr>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt">{{ __('bulletin_secondaire.cons_hr') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $consignes_heures }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.exclus_def') }}</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ $exclusions_definitive }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">COTE</p>
                </td>
                <td style="width: 25pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">000</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">CNA</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;"></p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: left; margin-left: 2pt;">{{ __('bulletin_secondaire.taux_reus') }}</p>
                </td>
                <td style="border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center">{{ round(($nbre_moyennes*100)/$effectifClasse, 2) }}%</p>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;">{{ __('bulletin_secondaire.app_stud_work') }}</p>
                </td>
                <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;">{{ __('bulletin_secondaire.parent_tutor_visa') }}</p>
                </td>
                <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;">{{ __('bulletin_secondaire.main_teacher_visa') }}</p>
                </td>
                <td colspan="2" style="height: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s3" style="padding-top: 3pt; text-align: center;">{{ __('bulletin_secondaire.the_school_chef') }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
