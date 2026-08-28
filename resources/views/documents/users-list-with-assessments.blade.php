<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('document_list_students.title') . $class_name}}</title>
    <style type="text/css">
        body {
            padding: 10px 30px;
            font-family: 'Calibri', sans-serif;
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
</table><br>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="text-align: center; font-size:16px; color:#0a92d6; ">
            <strong>{{ strtoupper($school_name) }}</strong> <br>
        </td>
    </tr>
</table>

<hr>
<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="text-align: center; font-size:16px;">
            <strong>{{ strtoupper(__('list_assess.by_matter_title')) }} / {{ $class_name }}</strong></strong>
        </td>
    </tr>
</table>
<hr>

<table id="listStudents" style="border-collapse: collapse; margin-top: 15px;  width: 100%" cellspacing="0">
    <tr style="background-color: rgba(207, 196, 196, 0.4)">
        <td rowspan="2" style="width: 5pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                <strong>N°</strong>
            </p>
        </td>
        <td rowspan="2" style="width: 100pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; vertical-align: middle;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px; margin: 0;">
                <strong>{{ strtoupper(__('list_assess.student')) }}</strong>
            </p>
        </td>

        @php $nbreCases = 0; @endphp

        @foreach($evaluations as $evaluation)
            <td colspan="{{ count($evaluation->types) }}"
                style=" width: 30pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ $evaluation->matter->name }}</strong></p>
            </td>
        @endforeach
    </tr>
    <tr style="background-color: rgba(207, 196, 196, 0.4)">
        @foreach($evaluations as $evaluation)
            @foreach($evaluation->types as $type_evaluation)
                @php $nbreCases++; @endphp
                <td style=" width: 10pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                    <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ strtoupper($type_evaluation->name[0]) }}</p>
                </td>
            @endforeach
        @endforeach
    </tr>

    @php $cpt = 1; @endphp
    @foreach($students as $student)
        <tr>
            <td style=" width: 10pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $cpt }}</p>
            </td>
            <td style=" width: 10pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; margin-left: 5pt;font-size: 12px">{{ strtoupper($student->name) }}</p>
            </td>
            @for($n = 0; $n < $nbreCases; $n++)
            <td colspan="" style=" width: 10pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"></p>
            </td>
            @endfor
        </tr>
        @php $cpt++; @endphp
    @endforeach
</table>

{{--<footer>--}}
{{--    <hr>--}}
{{--    <div style="float:left; width:10%;">--}}
{{--        <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}" alt="" style=" width:50px;";>--}}
{{--    </div>--}}
{{--    <div style="width:90%; text-align:center; float:right; margin-top:5px;">--}}
{{--        <p style="font-size: 12px; margin-top:5px;"> Tel: {{ $school->phone . " / " . $school->mobile }} | Email: {{ $school->email }} | Site web: {{ $school->website }}</p>--}}
{{--        <p style="font-size: 12px"> Siege Social : {{ $school->adresse }} </p>--}}
{{--    </div>--}}
{{--</footer>--}}


</body>
</html>
