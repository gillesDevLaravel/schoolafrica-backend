<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$infosEleve->name}} - {{ $infosEvaluation->name }}</title>

    @if(str_contains($route, "juniors"))
        @include('documents.bulletin-primaire.styles.juniors')
        @php $legend_of_grade["ae_color"] = "ff8040"; @endphp
    @else
        @include('documents.bulletin-primaire.styles.defaut')
    @endif
</head>
<body>

<!-- Entete du bulletin -->
    @if(str_contains($route, "juniors"))
        @include('documents.bulletin-primaire.entetes.juniors')
    @else
        @include('documents.bulletin-primaire.entetes.defaut')
    @endif


<!-- Informations de l'élève et de la classe -->
    @if(str_contains($route, "juniors"))
        @include('documents.bulletin-primaire.informations.juniors')
    @else
        @include('documents.bulletin-primaire.informations.defaut')
    @endif


    <!-- Logo en filligrane -->
    <div
        @if(file_exists(public_path("/public/profil/{$ecole['logo']}")))
            style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole['logo']}"))) }}');
                background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.05; background-size: 80%"
        @endif
    >

    <!-- Notes et statistiques d'évaluation -->
        @if(str_contains($route, "juniors"))
            @if(count($trimestres) <= 1)
                @include('documents.bulletin-primaire.tableau-de-notes.juniors')
            @else
                @include('documents.bulletin-primaire.tableau-de-notes-annuel.juniors')
            @endif

        @else
            @if(count($trimestres) <= 1)
                @include('documents.bulletin-primaire.tableau-de-notes.defaut')
            @else
                @include('documents.bulletin-primaire.tableau-de-notes-annuel.defaut')
            @endif
        @endif

    </div>

    <br>

    <!-- Legende des appreciations et moyennes séquentielles/Trimestrielle-->
    <div style="width: 100%; display: flex; page-break-inside: avoid; margin-bottom: {{ count($sequences) > 1 ? '57' : '5' }}px">

        @if(str_contains($route, "juniors"))
            @include('documents.bulletin-primaire.appreciations.juniors')
        @else
            @include('documents.bulletin-primaire.appreciations.defaut')
        @endif

            @if(count($sequences) > 1)
                <table width="30%" style="float:right; border-collapse: collapse; margin-left: 0;">
                    <tr bgcolor="#DBDBDB">

                        {{-- === ENTÊTES === --}}
                        @if(count($trimestres) <= 1)
                            @foreach($sequences as $sequence)
                                <td class="td_border" style="vertical-align: middle">
                                    <p class="s10" style="font-size: 12px; padding: 2pt; text-align: center;">
                                        @if(str_contains($route, "juniors"))
                                            <strong>{{ $sequence['name'] }}</strong>
                                        @else
                                            <strong>EVAL {{ $sequence['name'][-1] }}</strong>
                                        @endif
                                    </p>
                                </td>
                            @endforeach
                        @else
                            @foreach($trimestres as $trimestre)
                                <td class="td_border" style="vertical-align: middle">
                                    <p class="s10" style="font-size: 12px; padding: 2pt; text-align: center;">
                                        <strong>{{ strtoupper($trimestre['name']) }}</strong>
                                    </p>
                                </td>
                            @endforeach
                        @endif
                    </tr>
                    @if(count($trimestres) <= 1)
                        <tr>
                            @foreach($sequences as $sequence)
                                @php
                                    $idSequence = $sequence["id"];
                                    $moyenneSequence = $evaluation['moyennesSeq']["moySeq$idSequence"] ?? null;
                                    $isValid = $evaluation['isEvalueSeq']["isEvalueSeq$idSequence"] ?? false;
                                @endphp

                                <td style="vertical-align: middle;
                                @if(!$isValid || $moyenneSequence === null) background-color: black; @endif"
                                    class="td_border">

                                    <p class="s10"
                                       style="font-size: 12px; padding: 2pt; text-align: center;
                                       font-weight: bold;
                                       color:#{{$legend_of_grade[getAppreciationGradeAndColor($moyenneSequence, 20)[1]]}}">

                                        @if($isValid && $moyenneSequence !== null)
                                            {{ number_format_if_float($moyenneSequence, 2) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                            @endforeach
                        </tr>
                    @endif
                    @if(count($trimestres) > 1)
                        <tr>
                            @foreach($trimestres as $trimestre)
                                @php
                                    $idTrimestre = $trimestre["id"];
                                    $moyenneTrimestre = $evaluation['moyennesTrim']["moyTrim$idTrimestre"] ?? null;
                                    $isValid = $evaluation['isEvalueTrim']["isEvalueTrim$idTrimestre"] ?? false;
                                @endphp

                                <td style="vertical-align: middle;
                                @if(!$isValid || $moyenneTrimestre === null) background-color: black; @endif"
                                    class="td_border">

                                    <p class="s10"
                                       style="font-size: 12px; padding: 2pt; text-align: center;
                                       font-weight: bold;
                                       color:#{{$legend_of_grade[getAppreciationGradeAndColor($moyenneTrimestre, 20)[1]]}}">

                                        @if($isValid && $moyenneTrimestre !== null)
                                            {{ number_format_if_float($moyenneTrimestre, 2) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                            @endforeach
                        </tr>
                    @endif
                </table>
            @endif
    </div>


    <!-- Tableau de bilan -->
    @if(str_contains($route, "juniors"))
        @if(count($trimestres) <= 1)
            @include('documents.bulletin-primaire.bilan.juniors')
        @else
            @include('documents.bulletin-primaire.bilan.juniors-annuel')
        @endif
    @else
        @if(count($trimestres) <= 1)
            @include('documents.bulletin-primaire.bilan.defaut')
        @else
            @include('documents.bulletin-primaire.bilan.defaut-annuel')
        @endif
    @endif

{{--    <footer style="position: fixed; bottom: 0; left: 0; width: 100%; padding-bottom: 10px; text-align: center;">--}}
{{--        <hr>--}}
{{--        <p style="text-align: center;">--}}
{{--            Besides Fecafoot Essinguili / Tel 69723544 / 696600897 / 697562497--}}
{{--        </p>--}}
{{--    </footer>--}}
<div style="width: 100%; position: fixed; right: 0; padding-bottom: 10px; text-align: right">
    @if(file_exists(public_path('public/profil/cachet-nominatif-'. $route .'.png')))
        <img
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-nominatif-'. $route .'.png'))) }}"
            alt="Signature"
            style="height: 60px; object-fit: contain; margin-right: 20px;"
        >
    @endif
    @if(file_exists(public_path('public/profil/cachet-'. $route .'.png')))
        <img
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-'. $route .'.png'))) }}"
            alt="Signature"
            style="height: 130px; object-fit: contain;"
        >
    @endif
</div>

{{--    @if(file_exists(public_path('public/profil/cachet-'. $route .'.png')))--}}
{{--        <footer style="position: fixed; bottom: 0; right: 0; width: 100%; padding-bottom: 10px; text-align: right;">--}}
{{--            <img--}}
{{--                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-'. $route .'.png'))) }}"--}}
{{--                alt="Signature"--}}
{{--                style="height: 60px; object-fit: contain; margin-right: 20px;"--}}
{{--            >--}}

{{--            @if(file_exists(public_path('public/profil/cachet-nominatif-'. $route .'.png')))--}}
{{--                <img--}}
{{--                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-nominatif-'. $route .'.png'))) }}"--}}
{{--                    alt="Signature"--}}
{{--                    style="height: 60px; object-fit: contain; margin-right: 20px;"--}}
{{--                >--}}
{{--            @endif--}}
{{--        </footer>--}}
{{--    @endif--}}

</body>
</html>
