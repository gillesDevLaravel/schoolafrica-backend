<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$eleve['name']}} - {{ $infosEvaluation->name }}</title>

    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.styles.juniors')
        @php $legend_of_grade["ae_color"] = "ff8040"; @endphp
    @else
        @include('documents.bulletins.styles.defaut')
    @endif
</head>
<body>

<!-- Entete du bulletin -->
    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.entetes.juniors')
    @else
        @include('documents.bulletins.entetes.defaut')
    @endif


<!-- Informations de l'élève et de la classe -->
    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.informations.juniors')
    @else
        @include('documents.bulletins.informations.defaut')
    @endif


    <!-- Logo en filligrane -->
    <div
        @if(file_exists(public_path("/public/profil/{$ecole['logo']}")))
            style="background-image:url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole['logo']}"))) }}');
                background-repeat: no-repeat; background-position: center; z-index: -1; opacity: 0.10; background-size: 80%"
        @endif
    >

    <!-- Notes et statistiques d'évaluation -->
        @if(strpos($route, 'juniors') !== false)
            @if(empty($trimestres))
                @include('documents.bulletins.tableau-de-notes.juniors')
            @else
                @include('documents.bulletins.tableau-de-notes-annuel.juniors')
            @endif

        @else
            @if(empty($trimestres))
                @include('documents.bulletins.tableau-de-notes.defaut')
            @else
                @include('documents.bulletins.tableau-de-notes-annuel.defaut')
            @endif
        @endif

    </div>

    <br>

    <!-- Legende des appreciations et moyennes séquentielles/Trimestrielle-->
    <div style="width: 100%; display: flex; page-break-inside: avoid; margin-bottom: {{ count($sequences) > 1 ? '57' : '5' }}px">

        @if(strpos($route, 'juniors') !== false)
            @include('documents.bulletins.appreciations.juniors')
        @else
            @include('documents.bulletins.appreciations.defaut')
        @endif

        @if(count($sequences) > 1)
            <table width="30%" style="float:right; border-collapse: collapse; margin-left: 0;">
                <tr bgcolor="#DBDBDB">
                    @foreach($sequences as $sequence)
                        <td style="vertical-align: middle" class="td_border" >
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                                <strong>EVAL {{ $sequence['name'][-1] }}</strong>
                            </p>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach($sequences as $sequence)
                        @php
                            $idSequence = $sequence["id"];
                        @endphp
                        <td style="vertical-align: middle; @if($eleve["sequence$idSequence"]["moyenneSequence"] === null || !$eleve["sequence$idSequence"]['isValid'])background-color: black; @endif" class="td_border">
                            <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold; color:#{{$legend_of_grade[getAppreciationGradeAndColor($eleve["sequence$idSequence"]['moyenneSequence'], 20)[1]]}}; ">
                                @if($eleve["sequence$idSequence"]["moyenneSequence"] !== null)
                                    {{ number_format_if_float($eleve["sequence$idSequence"]["moyenneSequence"], 2) }}
                                @else
                                    -
                                @endif
                            </p>
                        </td>
                    @endforeach
                </tr>
            </table>
        @endif
    </div>


    <!-- Tableau de bilan -->
    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.bilan.juniors')
    @else
        @include('documents.bulletins.bilan.defaut')
    @endif


</body>
</html>
