<table style="width: 100%; border-collapse: collapse; font-size: 9px; font-family: Arial, sans-serif;">
    <tr>
        <!-- Colonne 1 : Informations en français -->
        <td style="text-align: center; width: 35%; font-size: 9px; font-family: Arial, sans-serif;">
            REPUBLIQUE DU CAMEROUN<br>
            <strong><i>Paix - Travail - Patrie</i></strong><br>
            <div style="margin-top: 1pt;">**************</div>
            MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES<br>
            <div style="margin-top: 1pt;">**************</div>
            DÉLÉGATION RÉGIONALE POUR LE SUD<br>
            <div style="margin-top: 1pt;">**************</div>
            DÉLÉGATION DÉPARTEMENTALE DE LA MVILA<br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($ecole["name"]) }}<br>
            <div style="margin-top: 1pt;">**************</div>
            ANNEE SCOLAIRE {{ $academic_year }}<br>
        </td>

        <!-- Colonne 2 : Logo (largeur dynamique) -->
        <td style="text-align: center; width: auto; padding: 0;">
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width: auto; height: 130px; margin-right:10px; margin-top:-10px !important;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @endif
        </td>

        <!-- Colonne 3 : Informations en anglais -->
        <td style="text-align: center; width: 35%; font-size: 9px; font-family: Arial, sans-serif;">
            REPUBLIC OF CAMEROON<br>
            <strong><i>Peace - Work - Fatherland</i></strong><br>
            <div style="margin-top: 1pt;">**************</div>
            MINISTRY OF SECONDARY EDUCATION<br>
            <div style="margin-top: 1pt;">**************</div>
            REGIONAL DELEGATION FOR THE SOUTH<br>
            <div style="margin-top: 1pt;">**************</div>
            DIVISIONAL DELEGATION OF MVILA<br>
            <div style="margin-top: 1pt;">**************</div>
            {{ strtoupper($ecole["name"]) }}<br>
            <div style="margin-top: 1pt;">**************</div>
            SCHOOL YEAR {{ $academic_year }}<br>
        </td>
    </tr>
</table>

