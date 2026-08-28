<!-- Informations sur l'élève et la classe -->
@php
    use Carbon\Carbon;
    $isFille = !empty($eleve['sexe']) && str_starts_with(strtolower($eleve['sexe']), 'f');

    $dateNaiss = (!empty($eleve['dateNaiss']))
        ? Carbon::parse($eleve['dateNaiss'])->format('d-m-Y')
        : '-';

    $situation = ($eleve['situation'] ?? '') === 'new'
        ? ($isFille ? __('bulletin_secondaire.nouvelle') : __('bulletin_secondaire.nouveau'))
        : ($isFille ? __('bulletin_secondaire.ancienne') : __('bulletin_secondaire.ancien'));

    $mergedRight = '<strong>Classe :</strong> ' . mb_strtoupper($eleve['nomClasse'] ?? '') . '<br>' .
        '<strong>' . ($isFille ? __('bulletin_secondaire.redoublante') : __('bulletin_secondaire.redoublant')) . ' :</strong> ' .
        ((!empty($eleve['redoublan'])) ? ($isFille ? __('bulletin_secondaire.redoublante') : __('bulletin_secondaire.redoublant')) : __('bulletin_secondaire.non')) . '<br>' .
        '<strong>Effectif :</strong> ' . (count($moyennes ?? []) + count($moyNonEval ?? [])) . '<br>' .
        '<strong>Situation :</strong> ' . $situation . '<br>' .
        '<strong>Professeur titulaire :</strong> ' . ($enseignantPrincipal['nom'] ?? '-');
@endphp

<table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; line-height: 7.5px;">
    <tr>
        <td style="font-size:12px;width:40%;text-align:left;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.nom_et_prenom')}} :</strong> {{mb_strtoupper($eleve['nom'] ?? '')}}
        </td>
        <td rowspan="5" style="font-size:14px;width:30%;text-align:left;padding:0 5px;border:none;">
            @if(file_exists(public_path("/public/profil/{$eleve['photo']}")))
                <img style="width: 120px; height: 100px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$eleve['photo']}"))) }}">
            @else
                <img style="width: 120px; height: 100px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
            @endif
        </td>
        <td style="font-size:14px;width:30%;text-align:right;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.classe')}} :</strong> {{mb_strtoupper($eleve['nomClasse'] ?? '')}}
        </td>
    </tr>
    <tr>
        <td style="font-size:14px;width:40%;text-align:left;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.sexe')}} :</strong> {{$isFille ? __('bulletin_secondaire.fille') : __('bulletin_secondaire.garcon')}}
        </td>
        <td style="font-size:14px;width:30%;text-align:right;padding:5px;border:none;">
            <strong style="font-size:14px;">{{$isFille ? __('bulletin_secondaire.redoublante') : __('bulletin_secondaire.redoublant')}} :</strong>
            {{(!empty($eleve['redoublan'])) ? ($isFille ? __('bulletin_secondaire.redoublante') : __('bulletin_secondaire.redoublant')) : __('bulletin_secondaire.non')}}
        </td>
    </tr>
    <tr>
        <td style="font-size:14px;width:40%;text-align:left;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.matricule')}} :</strong> {{$eleve['matricule'] ?? '-'}}
        </td>
        <td style="font-size:14px;width:30%;text-align:right;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.effectif')}} :</strong> {{count($moyennes ?? []) + count($moyNonEval ?? [])}}
        </td>
    </tr>
    <tr>
        <td style="font-size:14px;width:40%;text-align:left;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.ne_le')}} :</strong> {{$dateNaiss}}
            <strong style="font-size:14px;"> {{__('bulletin_secondaire.a')}} :</strong> {{$eleve['lieuNaiss'] ?? '-'}}
        </td>
        <td style="font-size:14px;width:30%;text-align:right;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.situation')}} :</strong> {{$situation}}
        </td>
    </tr>
    <tr>
        <td style="font-size:14px;width:40%;text-align:left;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.annee_scolaire')}} :</strong> {{$academic_year}}
        </td>
        <td style="font-size:12px;width:30%;text-align:right;padding:5px;border:none;">
            <strong style="font-size:14px;">{{__('bulletin_secondaire.professeur_titulaire')}} :</strong>
            {{ $enseignantPrincipal['nom'] ?? '-' }}
        </td>
    </tr>
</table>
