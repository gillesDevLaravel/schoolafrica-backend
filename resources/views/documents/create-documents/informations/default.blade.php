<!-- Informations sur l'élève et la classe -->
@php $sexe = str::startsWith(strtolower($eleve["sexe"]), 'f')? 0 : 1 @endphp
<table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; line-height: 7.5px;">
    <tr>
        <td style="font-size : 12px ;width: 75%; text-align: left; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.nom_et_prenom')}} :</strong> {{mb_strtoupper($eleve["nom"])}}
        </td>
        <td style="font-size : 14px ;width: auto; text-align: right; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.classe')}} :</strong> {{mb_strtoupper($eleve["nomClasse"])}}
        </td>
    </tr>
    <tr>
        <td style="font-size : 14px ;text-align: left; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.sexe')}} :</strong> {{($sexe == 0)? __('bulletin_secondaire.fille') : __('bulletin_secondaire.garcon')}}
        </td>
        <td style="font-size : 14px ;text-align: right; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{($sexe == 0) ? __('bulletin_secondaire.redoublante') : __('bulletin_secondaire.redoublant')}} :</strong> {{($eleve["redoublan"] == 0)? __('bulletin_secondaire.non') : __('bulletin_secondaire.oui')}}
        </td>
    </tr>
    <tr>
        <td style="font-size : 14px ;text-align: left; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.matricule')}} :</strong> {{(!is_null($eleve["matricule"]))? $eleve["matricule"] : '-'}}
        </td>
        <td style="font-size : 14px ;text-align: right; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.effectif')}} :</strong> {{count($moyennes) + count($moyNonEval)}}
        </td>
    </tr>
    <tr>
        <td style="font-size : 14px ;text-align: left; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.ne_le')}} :</strong> {{(!is_null($eleve["dateNaiss"]))? $eleve["dateNaiss"] : '-'}}
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.a')}} :</strong> {{(!is_null($eleve["lieuNaiss"]))? $eleve["lieuNaiss"] : '-'}}
        </td>
        <td style="font-size : 14px ;text-align: right; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.situation')}} :</strong>
            @php
                if ($eleve["situation"] == "new") {
                    $situation = ($sexe == 0) ? __('bulletin_secondaire.nouvelle') : __('bulletin_secondaire.nouveau');
                } else {
                    $situation = ($sexe == 0) ? __('bulletin_secondaire.ancienne') : __('bulletin_secondaire.ancien');
                }
            @endphp

            {{ $situation }}

        </td>
    </tr>
    <tr>
        <td style="font-size : 14px ;text-align: left; padding: 5px; border: none;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.annee_scolaire')}} :</strong> {{ $academic_year }}
        </td>
        <td style="font-size : 12px ;text-align: right; padding: 5px; border: none; width: 50%;">
            <strong style="font-size: 14px;">{{__('bulletin_secondaire.professeur_titulaire')}} :</strong>
            {{(isset($enseignantPrincipal["nom"]) && $enseignantPrincipal["nom"] != null)? $enseignantPrincipal["nom"] : '-'}}
        </td>
    </tr>
</table>
