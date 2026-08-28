<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr style="font-size: 12px;">
        {{-- Logo gauche - Université de Douala --}}
        <td style="text-align: center; width: 20%; vertical-align: middle; padding: 0;">
                       {{-- République du Cameroun --}}
            <div style="font-size: 10px; font-weight: bold; margin-bottom: 2px;">
                REPUBLIQUE DU CAMEROUN<br>
                <span style="font-size: 8px; font-weight: normal;">PAIX-TRAVAIL-PATRIE</span>
            </div>

            {{-- Université de Douala --}}
            <div style="font-size: 9px; margin-bottom: 5px;">UNIVERSITE DE DOUALA</div>
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width: 80px; height: auto;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @else
                <div style="width: 80px; height: 80px; border: 1px solid #ccc; text-align: center; line-height: 80px; font-size: 10px;">Logo</div>
            @endif
        </td>

        {{-- Contenu central --}}
        <td style="text-align: center; width: 60%; vertical-align: top; padding: 0 10px;">
 

            {{-- La Salle Douala-EST --}}
            <div style="margin: 5px 0;">
                <span style="color: #0056b3; font-size: 36px; font-weight: bold;">La</span>
                <span style="font-family: Arial, sans-serif; color: #f2c200; font-size: 28px;">&#9733;</span>
                <span style="color: #0056b3; font-size: 36px; font-weight: bold;">Salle</span><br>
                <span style="color: #e74c3c; font-size: 12px; font-weight: bold;">Douala-EST</span>
                <div style="font-size: 8px; color: #666;"><table style="width: 25%;border-collapse:collapse; margin-left:auto; margin-right:auto;"><tr><td style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #fff; text-align: center; padding: 1px; font-weight: bold; font-size: 8px; font-family: Arial, sans-serif;">Ecole Supérieure Technique</td></tr></table></div>
            </div>

            {{-- ÉCOLE SUPÉRIEURE TECHNIQUE LA SALLE --}}
            <div style="font-size: 12px; font-weight: bold; color: #0056b3; margin: 3px 0;">
                ECOLE SUPERIEURE TECHNIQUE LA SALLE
            </div>

            {{-- Adresse et contacts --}}
            <div style="font-size: 12px; line-height: 1.3; margin: 3px 0; font-weight: bold;">
                B.P. 5377 DOUALA - CAMEROUN&nbsp;&nbsp;Tél.: (+237) 243457137 - 650 006 084 - 6123 406 864<br>
                www.lasalle-douala.org&nbsp;&nbsp;&nbsp;&nbsp;email : info@lasalle-douala.org
            </div>

            {{-- Ligne de tutelle --}}
            <div style="font-size: 10px; font-weight: bold; margin-top: 3px; padding-top: 3px;">
                SOUS LA TUTELLE ACADEMIQUE DE L'ECOLE NATIONALE SUPERIEURE POLYTECHNIQUE DE DOUALA
            </div>
        </td>

        {{-- Logo droite - Polytechnique --}}
        <td style="text-align: center; width: 20%; vertical-align: middle; padding: 0;">
                       {{-- République du Cameroun --}}
            <div style="font-size: 10px; font-weight: bold; margin-bottom: 2px;">
                REPUBLIC OF CAMEROON<br>
                <span style="font-size: 8px; font-weight: normal;">PEACE-WORK-FATHERLAND</span>
            </div>

            {{-- Université de Douala --}}
            <div style="font-size: 9px; margin-bottom: 5px;">UNIVERSITY OF DOUALA</div>
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width: 80px; height: auto;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @else
                <div style="width: 80px; height: 80px; border: 1px solid #ccc; text-align: center; line-height: 80px; font-size: 10px;">Logo</div>
            @endif
        </td>
    </tr>
</table>

{{-- Ligne de séparation --}}
<div style="height: 3px; background: linear-gradient(to right, #0056b3, #f2c200, #0056b3); width: 100%; margin: 8px 0;"></div>
