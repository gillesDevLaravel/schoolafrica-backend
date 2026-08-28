<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('document_list_parents.list_parents_of'). $class_name }}</title>
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

        /*#listStudents .listParents:nth-child(odd) {*/
        /*    background-color: rgba(207, 196, 196, 0.4);*/
        /*}*/

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

        .page-break {
            page-break-before: always;
        }

        td{
            padding: 2px
        }
    </style>
</head>
<body>

<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 200px;font-size: 15px">
            <strong>REPUBLIQUE DU CAMEROUN</strong> <br> <br>
            <span style="font-size: 12px">paix-travail-patrie</span> <br>
            <span style="font-size: 12px">*******</span> <br>

            <span style="font-size: 12px">Ministère de l'Education de Base</span> <br>
            <span style="font-size: 12px">Région du Centre</span> <br>
            <span style="font-size: 12px">Département du Mfoundi</span> <br>
        </td>

        <td style="width:50px; max-height: 50px; text-align:center;">
            <img style="max-height: 150px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
{{--            <img style="width:50px; margin-right:10px;margin-top:-10px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">--}}
        </td>

        <td style="text-align: center; width: 200px;font-size: 15px;">
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
        <td style="text-align: center; font-size:40px; color:#{{ $couleurs[0] }}; ">
            <strong>{{ strtoupper($school_name) }}</strong> <br>
        </td>
    </tr>
</table>

<hr>
<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="text-align: center; font-size:16px;">
            <strong>{{ __('document_list_parents.list_parents_of'). $class_name }} / <strong>{{ $academic_year }}</strong></strong>
        </td>
    </tr>
</table>
<hr>

<table id="listStudents" style="border-collapse: collapse; margin-top: 15px;  width: 100%" cellspacing="0">
    <tr style="background-color: #{{ $couleurs[0] }}; color: white">
        <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>S/N</strong></p>
        </td>
        <td
            style=" width: 150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_parents.name_of_father') }}</strong></p>
        </td>
        <td
            style=" width: 65pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>TEL</strong></p>
        </td>
        <td
            style=" width: 150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_parents.name_of_mother') }}</strong></p>
        </td>
        <td
            style=" width: 65pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>TEL</strong></p>
        </td>
        <td
            style=" width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>EMAIL</strong></p>
        </td>
        <td
            style=" width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>USERNAME</strong></p>
        </td>
        <td
            style=" width: 150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
            <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_parents.name_of_children') }}</strong></p>
        </td>
    </tr>

    @php $cpt = 1; $nbreTrForChildren = 0; $page = 1; @endphp
    @foreach($parents as $parent)
{{--        Si la somme de tr + ceux que mes enfants vont ajouter est > 22,
                on fais le page-break et on définit le nouveau trCount au nbre d'enfants que j'ai;
                sinon on ajoute juste mon nomnbre d'enfants au trCount
--}}
{{--        @if(($nbreTrForChildren+count($parent->eleves)) > 29)--}}
{{--            @php $nbreTrForChildren = count($parent->eleves); @endphp--}}
{{--            <tr class="listParents page-break">--}}
{{--        @else--}}
{{--            @php $nbreTrForChildren += count($parent->eleves)-1; @endphp--}}
{{--            <tr class="listParents">--}}
{{--        @endif--}}
        <tr class="listParents" style="page-break-inside: avoid;">
            <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 11px;">{{ $cpt }}</p>
            </td>
            <td
                style=" width: 150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; padding-left: 2px; font-size: 12px; margin-left: 2px;"><strong>{{ $parent->pere }}</strong></p>
            </td>
            <td
                style="width: 20pt !important; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                <p class="" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px;">{{ $parent->phone }}</p>
            </td>
            <td
                style="width:150pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: left;font-size: 12px; margin-left: 2px;"><strong>{{ $parent->mother }}</strong></p>
            </td>
            <td
                style=" width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px;">{{ $parent->phone_2 }}</p>
            </td>
            <td
                style=" width: 50pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px;">{{ $parent->email }}</p>
            </td>
            <td
                style="max-width: 40pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 11px;">{{ $parent->username }}</p>
            </td>
            <td
                style=" width: 125pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">
                @foreach($parent->eleves as $key => $eleve)
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: left; font-size: 12px; margin-left: 2px;">{{ $eleve->name }}</p>
                @endforeach
            </td>
        </tr>
{{--        @foreach($parent->eleves as $key => $eleve)--}}
{{--            @if($key > 0)--}}
{{--                <tr>--}}
{{--                    <td--}}
{{--                        style=" width: 125pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628; ">--}}
{{--                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center; font-size: 12px;">{{ $eleve->name }}</p>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endif--}}
{{--        @endforeach--}}
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
