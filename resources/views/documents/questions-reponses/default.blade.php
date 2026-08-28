<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('liste_des_questions_reponses.questions_answers_list_of') }} {{ $student->name }}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            /*font-family: "Times New Roman", serif;*/
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }

        .image-block img {
            width: 60%;
            height: auto;
            margin-right: 10px;
        }

        p{
            font-size: 14px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
</head>
<body>

    <table style="width: 100%;">
        <tr style="">
            <td style="text-align: center; width: 40%;font-size: 12px">
                <strong>REPUBLIQUE DU CAMEROUN</strong> <br> <br>
                <span style="font-size: 12px">paix-travail-patrie</span> <br>
                <span style="font-size: 12px">*******</span> <br>

                <span style="font-size: 12px">Ministère de l'Education de Base</span> <br>
                <span style="font-size: 12px">Région du Centre</span> <br>
                <span style="font-size: 12px">Département du Mfoundi</span> <br>
            </td>

            <td style="width:70%; text-align:center;">
                @if(file_exists(public_path("/public/profil/{$school->logo}")))
                    <img style="width:30%; margin-right:10px;margin-top:-5px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school->logo"))) }}">
                @endif
            </td>

            <td style="text-align: center; width: 40%;font-size: 12px">
                <strong>REPUBLIC OF CAMEROON</strong> <br> <br>
                <span style="font-size: 12px">peace-work-fatherland</span> <br>
                <span style="font-size: 12px">*******</span> <br>

                <span style="font-size: 12px">Ministry of basic education</span> <br>
                <span style="font-size: 12px">Center Region</span> <br>
                <span style="font-size: 12px">Mfoundi Division</span> <br>
            </td>
        </tr>
    </table><br>

    <table style="text-align: center;  width: 100%; margin-bottom: 8px">
        <tr>
            <td style="text-align: center; font-size:16px; color: #0a92d6; ">
                <strong>{{ mb_strtoupper($school->name, 'UTF-8') }}</strong> <br>
            </td>
        </tr>
    </table>

    <table style="text-align: center;  width: 100%; background-color: #0a92d6">
        <tr>
            <td style="text-align: center; font-size:20px; color: white">
                <strong>{{ __("Liste des questions / réponses aux examens") }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="width: 50%">
                <div style="margin-top: 20px; margin-bottom: 20px;">
                    <p style="margin: 5px">
                        <span style="text-decoration: underline">{{ __('liste_des_questions_reponses.name') }}</span>: {{ $student->name }}
                    </p>
                    <p style="margin: 5px">
                        <span style="text-decoration: underline">{{ __('liste_des_questions_reponses.matricule') }}</span>: {{ $student->matricule }}
                    </p>
                    <p style="margin: 5px">
                        <span style="text-decoration: underline">{{ __('liste_des_questions_reponses.classe') }}</span>: {{ $classe->name }}
                    </p>
                    <p style="margin: 5px">
                        <span style="text-decoration: underline">{{ __('liste_des_questions_reponses.annee_academique') }}</span>: 2024 / 2025
                    </p>
                    <p style="margin: 5px">
                        <span style="text-decoration: underline">{{ __('liste_des_questions_reponses.evaluation') }}</span>: {{ $assessmentType->name }}
                    </p>
                </div>
            </td>
            <td style="text-align:right; width: 50%; margin-top: 20px; margin-bottom: 20px;">
                @if(file_exists(public_path("/public/profil/{$student->photo}")))
                    <img style="margin-top: 20px; margin-bottom: 20px; width:30%; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$student->photo"))) }}">
                @endif
            </td>
        </tr>
    </table>

    <div style="width: 100%">
        <div style="text-align: center; background-color: #0a92d6; margin-bottom: 10px; color: white; height: 25px; padding-top: 5px">
            <strong>{{ __('liste_des_questions_reponses.evaluation') . ": " .mb_strtoupper($exam->name, 'UTF-8') }}</strong>
        </div>

        @foreach($exam->questions as $question)
        <div style="margin-bottom: 15px;">
            <p style="font-size:18px; margin-bottom: 5px; padding: 3px; font-weight: bold; line-height: 30px;">{!! $question->intitule !!}</p>

            <p style="font-size:18px; text-align: justify; line-height: 30px;">{!! nl2br($question['proposition_etudiant']['response']) !!}</p>
        </div>
        @endforeach
    </div>
</body>
</html>
