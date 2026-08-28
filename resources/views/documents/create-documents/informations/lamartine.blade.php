{{--<<<<<<< HEAD--}}
{{--<!-- Informations sur l'élève et la classe -->--}}
{{--@php $sexe = str::startsWith(strtolower($eleve["sexe"]), 'f')? 0 : 1 @endphp--}}
{{--<div class="student-info">--}}
{{--    <div class="student-photo-container">--}}
{{--        <img class="student-photo" src="../../public/images/logos/cfao_academy.png" alt="CFAO Academy Logo" class="logo-img">--}}
{{--    </div>--}}
{{--    <table class="student-table">--}}
{{--        <tr>--}}
{{--            <td><strong style="font-size: 14px;">{{__('bulletin_secondaire.nom_et_prenom')}} :</strong></td>--}}
{{--            <td>{{strtoupper($eleve["nom"])}}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Né le</td>--}}
{{--            <td>12 décembre 2012 à DOUALA</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Classe</td>--}}
{{--            <td>6<sup>ème</sup></td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td rowspan="2">Informations sur le parent</td>--}}
{{--            <td>Nom : [Nom du parent]</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Contact : [Téléphone / Email]</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Sexe</td>--}}
{{--            <td>Masculin</td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</div>--}}
{{--=======--}}
@php
    // <-- garde ton code PHP original inchangé -->
    $sexe = Str::startsWith(Str::lower($eleve["sexe"] ?? ''), 'f') ? 0 : 1;
    $situation = '-';
    if (!is_null($eleve["situation"] ?? null)) {
        if (($eleve["situation"] ?? '') == "new") {
            $situation = ($sexe == 0) ? __('bulletin_secondaire.nouvelle') : __('bulletin_secondaire.nouveau');
        } else {
            $situation = ($sexe == 0) ? __('bulletin_secondaire.ancienne') : __('bulletin_secondaire.ancien');
        }
    }
@endphp

    <!-- Informations de l'élève et de la classe -->
<table width="100%" style="border-collapse: collapse; margin-left: 0; font-family: Arial, sans-serif; font-size: 11px;">
    <tr>
        <!-- Colonne image fusionnée sur 6 lignes -->
        <td rowspan="6" style="width: 100px; vertical-align: top;">
            @if(file_exists(public_path("/public/profil/{$eleve['photo']}")))
                <img style="width: 130px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$eleve['photo']}"))) }}">
            @else
                <img style="width: 130px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
            @endif
        </td>

        <!-- Première ligne du contenu -->
        <td style="border: 1px solid #000; padding: 3px; text-align: left; width: 55%;">
            <strong>{{ __('bulletin_secondaire.nom_et_prenom') }} :</strong> {{ strtoupper($eleve["nom"]) }}
        </td>
        <td style="border: 1px solid #000; padding: 3px; text-align: right; width: 35%;">
            <strong>{{ __('bulletin_secondaire.classe') }} :</strong> {{ strtoupper($eleve["nomClasse"] ?? '-') }}
        </td>
    </tr>

    <tr>
        <!-- L'image est déjà gérée par le rowspan -->
        <td style="border: 1px solid #000; padding: 3px; text-align: left;">
            <strong>{{ __('bulletin_secondaire.ne_le') }} :</strong> {{ $eleve["dateNaiss"] ?? '-' }}
            <strong>{{ __('bulletin_secondaire.a') }} :</strong> {{ $eleve["lieuNaiss"] ?? '-' }}
        </td>
        <td style="border: 1px solid #000; padding: 3px; text-align: right;">
            <strong>{{ __('bulletin_secondaire.sexe') }} :</strong> {{ ($sexe == 0) ? __('bulletin_secondaire.fille') : __('bulletin_secondaire.garcon') }}
        </td>
    </tr>

    <tr>
        <td style="border: 1px solid #000; padding: 3px; text-align: left;">
            <strong>{{ __('bulletin_secondaire.matricule') }} :</strong> {{ $eleve["matricule"] ?? '-' }}
        </td>
        <td style="border: 1px solid #000; padding: 3px; text-align: right;">
            <strong>{{ __('bulletin_secondaire.redoublant') }} :</strong> {{ ($eleve["redoublan"] == 0) ? __('bulletin_secondaire.non') : __('bulletin_secondaire.oui') }}
        </td>
    </tr>

    <tr>
        <td style="border: 1px solid #000; padding: 3px; text-align: left;" rowspan="2">
            <strong>{{ __('bulletin_secondaire.nom_parent') }} :</strong> {{ $parent["nom"] ?? '-' }}<br>
            <strong>Tél :</strong> {{ $parent["telephone"] ?? '-' }}<br>
            <strong>E-mail :</strong> {{ $parent["email"] ?? '-' }}
        </td>
        <td style="border: 1px solid #000; padding: 3px; text-align: right;">
            <strong>{{ __('bulletin_secondaire.effectif') }} :</strong> {{ (is_array($moyennes) ? count($moyennes) : 0) + (is_array($moyNonEval) ? count($moyNonEval) : 0) }}
        </td>
    </tr>

    <tr>
        <!-- La cellule de gauche est fusionnée avec la ligne au-dessus -->
        <td style="border: 1px solid #000; padding: 3px; text-align: right;">
            <strong>{{ __('bulletin_secondaire.main_teacher') }} :</strong> {{ $enseignantPrincipal["nom"] ?? '-' }}
        </td>
    </tr>

    <tr>
        <td style="border: 1px solid #000; padding: 3px; text-align: left;">
            <strong>{{ __('bulletin_secondaire.professeur_titulaire') }} :</strong> {{ $enseignantPrincipal["nom"] ?? '-' }}
        </td>
        <td style="border: 1px solid #000; padding: 3px; text-align: right;">
            <strong>{{ __('bulletin_secondaire.matieres_validées') }} :</strong> {{ ($eleve["redoublan"] == 0) ? __('bulletin_secondaire.non') : __('bulletin_secondaire.oui') }}
        </td>
    </tr>
</table>
<br>
{{-->>>>>>> 46e8752970a30250571be8ea0f71864e784d84cc--}}
