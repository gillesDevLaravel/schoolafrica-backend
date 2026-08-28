<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFOS GENERALES - {{ $ecole->name }} - {{ $trimestre->name }}</title>
    <style type="text/css">
        body {
            padding: 15px 15px;
            /* La police est commentée, mais vous pouvez l'activer si nécessaire */
            /* font-family: Arial, sans-serif; */
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            font-size: 13px;
        }


    </style>
</head>
<body>


<!-- Filifranne -->
<div
    @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
        style="background-image: url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}');
               background-repeat: no-repeat;
               background-position: center;
               background-size: 80%;
               opacity: 0.1;
               position: absolute;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               z-index: -1;"
    @endif
>
    <!-- Contenu de la page -->
</div>

<!-- Inlcusion des entetes de bulletin en fonction de l'établissement -->
@if(isset($route) && $route == "abiscoms")
    @include('documents.create-documents.entetes.entete-bulletin-secondaire-abiscom')
@elseif(isset($route) && $route == "afc")
    @include('documents.create-documents.entetes.entete-bulletin-secondaire-afc')
@else
    @include('documents.create-documents.entetes.entete-bulletin-secondaire')
@endif

<table style="text-align: center; width: 100%; margin: 10px 10px;">
    <tr>
        <td><strong style="text-align: center; font-size: 16pt;"> INFOS GENERALES - {{ $ecole->name }}- {{ $trimestre->name }} </strong></td>
    </tr>
</table>


<div style="overflow-x: auto; max-width: 100%;">
    <table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; line-height: 20px;">
        <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ $couleurs[0] ?? 'C8C8C8' }};">
            <th style="width: 5%; border: 1px solid #181A1B; text-align: center; padding: 4px;">N°</th>
            <th style="width: 55%; border: 1px solid #181A1B; text-align: center; padding: 4px;">{{ __('infos-ecole.classe') }}</th>
            <th style="width: 20%; border: 1px solid #181A1B; text-align: center; padding: 4px;">{{ __('infos-ecole.moy_gen') }}</th>
            <th style="width: 20%; border: 1px solid #181A1B; text-align: center; padding: 4px;">%S</th>
        </thead>

        <tbody>
        <tr style="background-color: rgba(74,72,72,0.1);">
            <td style="height: 50pt; text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></td>
            <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">ECOLE</td>
            <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ number_format_if_float($infos_ecole['moyenne_generale'], 2) }} /20
            </td>
            <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ number_format_if_float($infos_ecole['pourcentage_reussite'], 2) }}%
            </td>
        </tr>

        @php $cpt = 1; @endphp
        @foreach($moyennes_generales_par_classe as $par_classe)
            <tr style="background-color: rgba(200, 200, 200, 0.1)">
                <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{$cpt}}
                </td>
                <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $par_classe['name'] }}
                </td>
                <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; @if($par_classe['moyenne_generale_classe']<10)color:red;@endif">
                    {{ number_format_if_float($par_classe['moyenne_generale_classe'], 2) }} /20
                </td>
                <td style="text-align:center; font-weight: bold; border: 1px solid #212628; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; @if($par_classe['pourcentage_reussite_classe']<50)color:red;@endif">
                    {{ number_format_if_float($par_classe['pourcentage_reussite_classe'], 2) }}%
                </td>
            </tr>
            @php $cpt++; @endphp
        @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
