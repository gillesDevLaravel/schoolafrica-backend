<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$eleve['name']}} - {{ $infosEvaluation->name }}</title>

    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.styles.juniors-maternelle')
        @php $legend_of_grade["ae_color"] = "ff8040"; @endphp
    @else
        @include('documents.bulletins.styles.defaut')
    @endif
</head>
<body>

<!-- Entete du bulletin -->
    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.entetes.juniors-maternelle')
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
            @include('documents.bulletins.tableau-de-notes.juniors-maternelle')
        @else
            @include('documents.bulletins.tableau-de-notes.defaut-maternelle')
        @endif
    </div>

    <br>

    <!-- Legende des appreciations et moyennes séquentielles-->
    <div style="width: 100%; display: flex; page-break-inside: avoid">

        @if(strpos($route, 'juniors') !== false)
            @include('documents.bulletin-primaire.appreciations.juniors-maternelle')
        @else
            @include('documents.bulletin-primaire.appreciations.defaut-maternelle')
        @endif

        @if(count($sequences) > 1)
        <table width="40%" style="float:right; border-collapse: collapse; margin-left: 0;">
            <tr>
                @foreach($sequences as $sequence)
                    <td style="vertical-align: middle" class="td_border" >
                        <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                            @if(strpos($route, 'juniors') !== false)
                                <strong>{{$sequence['name']}}</strong>
                            @else
                                <strong>EVAL {{$sequence['name'][-1]}}</strong>
                            @endif
                        </p>
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach($sequences as $sequence)
                    @php
                        $key = $type . $sequence['id'];
                        $key2 = ucfirst($type);
                        $moyenneSequence = $eleve[$key]["moyenne$key2"];

                        if(strpos($route, 'juniors') !== false){
                            $stickerAppreciation = getAppreciationStickerWithNull($moyenneSequence, 20);
                        }
                        else{
                            $moyenneSequence = ($moyenneSequence !== null) ? ($moyenneSequence * 4) / 20 : null;

                            $stickerAppreciation = getAppreciationStickerForMaternelle($moyenneSequence, true);
            }

                    @endphp

                    <td style="vertical-align: middle; @if($moyenneSequence === null || $eleve[$key]["isValid"] === false)background-color: black; @endif" class="td_border" >
                        <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                            <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                        </p>
                    </td>
                @endforeach
            </tr>
        </table>
        @endif
    </div>


    <!-- Tableau de bilan -->
    @if(strpos($route, 'juniors') !== false)
        @include('documents.bulletins.bilan.juniors-maternelle')
    @else
        @include('documents.bulletins.bilan.defaut-maternelle')
    @endif


</body>
</html>
