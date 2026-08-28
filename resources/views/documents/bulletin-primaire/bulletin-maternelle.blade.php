<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$infosEleve->name}} - {{ $infosEvaluation->name }}</title>

    @if(str_contains($route, "juniors"))
        @include('documents.bulletin-primaire.styles.juniors-maternelle')
        @php $legend_of_grade["ae_color"] = "ff8040"; @endphp
    @else
        @include('documents.bulletin-primaire.styles.defaut')
    @endif
</head>
<body>

<!-- Entete du bulletin -->
@if(str_contains($route, "juniors"))
    @include('documents.bulletin-primaire.entetes.juniors-maternelle')
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
            @include('documents.bulletin-primaire.tableau-de-notes.juniors-maternelle')
        @else
            @include('documents.bulletin-primaire.tableau-de-notes-annuel.juniors-maternelle')
        @endif

    @else
        @if(count($trimestres) <= 1)
            @include('documents.bulletin-primaire.tableau-de-notes.defaut-maternelle')
        @else
            @include('documents.bulletin-primaire.tableau-de-notes-annuel.defaut-maternelle')
        @endif
    @endif
</div>

<br>

<!-- Legende des appreciations et moyennes séquentielles-->
<div style="width: 100%; display: flex; page-break-inside: avoid">

    @if(str_contains($route, "juniors"))
        @include('documents.bulletin-primaire.appreciations.juniors-maternelle')
    @else
        @include('documents.bulletin-primaire.appreciations.defaut-maternelle')
    @endif

    @if(count($sequences) > 1)
        <table width="40%" style="float:right; border-collapse: collapse; margin-left: 0;">
            <tr>
                @if(count($trimestres) <= 1)
                    @foreach($sequences as $sequence)
                        <td style="vertical-align: middle" class="td_border" >
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                                @if(str_contains($route, "juniors"))
                                    <strong>{{$sequence['name']}}</strong>
                                @else
                                    <strong>EVAL {{$sequence['name'][-1]}}</strong>
                                @endif
                            </p>
                        </td>
                    @endforeach
                @else
                    {{ $trimCount = 0 }}
                    @foreach($trimestres as $trimestre)
                        {{ $trimCount ++ }}
                        <td style="vertical-align: middle" class="td_border" >
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                                <strong>
                                    {{ strtoupper($trimestre['name']) }}
                                </strong>
                            </p>
                        </td>
                    @endforeach
                @endif

            </tr>
            <tr>
                @if(count($trimestres) <= 1)
                    @foreach($sequences as $sequence)
                        @php
                            $idSequence = $sequence["id"];

                            if (str_contains($route, "juniors")){
                                $moyenneSequence = $evaluation['moyennesSeq']["moySeq$idSequence"] !== null ? $evaluation['moyennesSeq']["moySeq$idSequence"] : null;
                                $stickerAppreciation = getAppreciationStickerWithNull($moyenneSequence, 20);
                            }
                            else{
                                $moyenneSequence = ($evaluation['moyennesSeq']["moySeq$idSequence"] !== null) ? ($evaluation['moyennesSeq']["moySeq$idSequence"] / 5) : null;
                                $stickerAppreciation = getAppreciationStickerForMaternelle($moyenneSequence, true);
                            }

                        @endphp

                        <td style="vertical-align: middle; @if($moyenneSequence === null || $evaluation['isEvalueSeq']["isEvalueSeq$idSequence"] === false)background-color: black; @endif" class="td_border" >
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                                <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                            </p>
                        </td>
                    @endforeach
                @else
                    @foreach($trimestres as $trimestre)
                        @php
                            $idTrimestre = $trimestre["id"];
                            $moyenneTrimestre = ($evaluation['trimestres']["trimestre$idTrimestre"] !== null && $evaluation['noteMaxTrim']["noteMaxTrim$idTrimestre"] != null) ? ($evaluation['trimestres']["trimestre$idTrimestre"] * 4) / $evaluation['noteMaxTrim']["noteMaxTrim$idTrimestre"] : null;

                            $stickerAppreciation = getAppreciationStickerForMaternelle($moyenneTrimestre, true);

                        @endphp

                        <td style="vertical-align: middle; @if($moyenneTrimestre === null || $evaluation['isEvalueTrim']["isEvalueTrim$idTrimestre"] === false)background-color: black; @endif" class="td_border" >
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                                <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                            </p>
                        </td>
                    @endforeach
                @endif
            </tr>
        </table>
    @endif
</div>


<!-- Tableau de bilan -->
@if(str_contains($route, "juniors"))
    @if(count($trimestres) <= 1)
        @include('documents.bulletin-primaire.bilan.juniors-maternelle')
    @else
        @include('documents.bulletin-primaire.bilan.juniors-maternelle-annuel')
    @endif
@else
    @include('documents.bulletin-primaire.bilan.defaut-maternelle')
@endif

@php
    $normalizedRoute = str_contains($route, "juniors") ? "juniors" : $route;
@endphp

<div style="width: 100%; position: fixed; right: 0; padding-bottom: 10px; text-align: right">
    @if(file_exists(public_path('public/profil/cachet-nominatif-'. $normalizedRoute .'.png')))
        <img
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-nominatif-'. $normalizedRoute .'.png'))) }}"
            alt="Signature"
            style="height: 60px; object-fit: contain; margin-right: 20px;"
        >
    @endif
    @if(file_exists(public_path('public/profil/cachet-'. $normalizedRoute .'.png')))
        <img
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/cachet-'. $normalizedRoute .'.png'))) }}"
            alt="Signature"
            style="height: 130px; object-fit: contain;"
        >
    @endif
</div>

</body>
</html>
