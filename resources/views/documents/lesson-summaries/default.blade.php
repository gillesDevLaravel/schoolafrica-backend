<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('app.resume_title') . json_decode($lesson)->name }}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            font-family: 'Calibri', sans-serif;
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
            <strong>{{ strtoupper($school->name) }}</strong> <br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; background-color: #0a92d6">
    <tr>
        <td style="text-align: center; font-size:20px; color: white">
            <strong>{{ __('app.course_sumary') }}</strong>
        </td>
    </tr>
</table>

<table style="margin-top:15px; width: 100%">
    <tr>
        <td style="width: 10%">
            <strong>{{ __('app.matter') }}</strong>: {{ json_decode($lesson)->chapter->classe_name }}
        </td>
    </tr>
    <tr>
        <td style="width: 10%">
            <strong>{{ __('app.chapter') }}</strong>: {{ json_decode($lesson)->chapter->name }}
        </td>
    </tr>
    <tr>
        <td style="width: 10%">
            <strong>{{ __('app.lesson') }}</strong>: {{ json_decode($lesson)->name }}
        </td>
    </tr>
</table>

@foreach($lesson_summaries as $key => $lesson_summary)
    <div style="width: 100%; margin-top: 15px;">
        <div style="text-align: right; margin-bottom: 10px; height: 25px; padding-top: 5px">
            <strong>Date: {{ $lesson_summary->date }}</strong>
        </div>

        <p style="margin-bottom: 15px">{!! $lesson_summary->description !!}</p>

        @foreach($lesson_summary->images as $image)
            @if(file_exists(public_path("/public/profil/{$image}")))
                <p style="width: 100%; margin-bottom: 10px">
                    <img style="width:60%;" src="data:image/png;base64,{{ @base64_encode(file_get_contents($image)) }}">
                </p>
            @endif
        @endforeach
    </div>
    @if($key != count($lesson_summaries)-1)
        <hr>
    @endif
@endforeach
</body>
</html>
