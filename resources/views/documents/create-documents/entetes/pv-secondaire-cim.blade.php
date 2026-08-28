<!-- Tableau d'en-tête invisible (3 colonnes : FR + Logo + EN) -->
<table style="width:100%; border:none; border-collapse:collapse; margin:0; padding:0;">
    <tr style="border:none;">
        <!-- Colonne 1 : Informations en français -->
        <td style="border:none; text-align:center; width:35%; font-size:9px; font-family:Arial, sans-serif; padding:0; vertical-align:middle;">
            MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES<br>
            <div style="margin-top:1pt;">**************</div>
            DÉLÉGATION RÉGIONALE DU LITTORAL<br>
            <div style="margin-top:1pt;">**************</div>
            DÉLÉGATION DÉPARTEMENTALE DU WOURI<br>
            <div style="margin-top:1pt;">**************</div>
            <strong>COLLEGE BILINGUE DE MONTREAL - CBM</strong><br>
            <div style="margin-top:1pt;">**************</div>
            Tél. : 676060926 / 692879372. B.P : 21105 Douala
        </td>

        <!-- Colonne 2 : Logo -->
        <td style="border:none; text-align:center; width:auto; padding:0; vertical-align:middle;">
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width:auto; height:130px; margin:0;"
                     src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/public/profil/'.$ecole->logo))) }}">
            @endif
        </td>

        <!-- Colonne 3 : Informations en anglais -->
        <td style="border:none; text-align:center; width:35%; font-size:9px; font-family:Arial, sans-serif; padding:0; vertical-align:middle;">
            MINISTRY OF SECONDARY EDUCATION<br>
            <div style="margin-top:1pt;">**************</div>
            REGIONAL DELEGATION OF LITTORAL<br>
            <div style="margin-top:1pt;">**************</div>
            DIVISIONAL DELEGATION OF WOURI<br>
            <div style="margin-top:1pt;">**************</div>
            <strong>MONTREAL BILINGUAL COLLEGE - MBC</strong><br>
            <div style="margin-top:1pt;">**************</div>
            Phone: 676060926 / 692879372. P.O. Box: 21105 Douala
        </td>
    </tr>
</table>
