<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
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
            <img style="width:40%; margin-right:10px;margin-top:-10px !important;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school->logo"))) }}">
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
        <td style="text-align: center; font-size:16px; color: #0a92d6; ">
            <strong>{{ strtoupper($school->name) }}</strong> <br>
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; background-color: #0a92d6">
    <tr>
        <td style="text-align: center; font-size:20px; color: white">
            <strong>{{ $title }}</strong>
        </td>
    </tr>
</table>

<table id="listStudents" style="margin-top: 20px; width: 100%" cellspacing="0">
    <tr style="width: 100%;background-color: #0a92d6; color: white">
        <td style="width: 10pt; ">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>Nº</strong></p>
        </td>
        <td
            style="width: 150pt; padding-left: 5px; ">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; padding-right: 2pt; text-indent: 0pt; text-align: left;font-size: 12px"><strong>NOM</strong></p>
        </td>
        <td
            style=" width:30pt; padding-left:5px;">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt;font-size: 12px"><strong>TYPE</strong></p>
        </td>
        <td
            style=" width:150pt; padding-left:5px;">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt;font-size: 12px"><strong>Fournisseur</strong></p>
        </td>
        <td
            style=" width:50pt; padding-left:5px;">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt;font-size: 12px"><strong>Montant</strong></p>
        </td>
        <td
            style=" width:50pt; padding-left:5px;">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt;font-size: 12px"><strong>Statut</strong></p>
        </td>
        <td
            style=" width:50pt; padding-left:5px;">
            <p class="s2" style="padding-top: 4pt; padding-bottom: 4pt; text-indent: 0pt;font-size: 12px"><strong>Date</strong></p>
        </td>
    </tr>

    @php $cpt = 1; @endphp
    @foreach($invoices as $key => $invoice)
        <tr @if($key % 2 == 0) style="background-color: rgba(246,243,243,0.82);" @endif>
            <td style="width: 10pt; ">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px;">{{ $cpt }}</p>
            </td>
            <td style="width: 10pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ $invoice['reasons'] }}</p>
            </td>
            <td style="width: 10pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ $invoice['type_invoice']['name'] }}</p>
            </td>
            <td style="width: 100pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ $invoice['invoiceable']['name'] }}</p>
            </td>
            <td style="width: 10pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ number_format($invoice['amount']) }} XAF</p>
            </td>
            <td style="width: 10pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ $invoice['statut'] }}</p>
            </td>
            <td style="width: 10pt; padding-left:5px;">
                <p class="s2" style="padding-top: 4pt; text-indent: 0pt; font-size: 12px;">{{ \Carbon\Carbon::parse($invoice['date'])->format('d M Y') }}</p>
            </td>
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
