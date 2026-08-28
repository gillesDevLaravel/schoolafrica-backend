<table style="width: 100%; border-collapse: collapse; font-size: 9px; font-family: Arial, sans-serif">
    <tr>
        <!-- Colonne 1 : Image -->
        <td style="text-align: center; padding: 10px; border: none;">
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="max-width: 100px; height: auto; margin: 0;" 
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @else
                <div style="font-size: 10px; font-weight: bold; color: #c2c4c4;">
                    Logo non disponible
                </div>
            @endif
        </td>

        <!-- Colonne 2 : Texte -->
        <td style="text-align: center; padding: 10px; border: none; font-size: 10px; position: relative;">
            <div style="display: inline-block; width: 100%; padding-bottom: 10px; border-bottom: 3px solid #{{ $couleurs[0] ?? '181A1B' }};;">
                <strong style="font-size: 30px; display: block; margin-bottom: 2px;">AKOUMA BILINGUAL HIGH SCHOOL</strong>
                <div style="margin-bottom: 2px;">Located before the First Entrance to the Military Base Simbock</div>
                <div style="margin-bottom: 2px;"><strong>Motto: To honour the Lord is to hate evil!</strong></div>
                <div style="margin-bottom: 0;">P.O. Box 5610 Nlongkak Yaounde Tél: 676 59 02 71 - 677 82 58 06 – 222 31 70 55</div>
            </div>
        </td>
    </tr>
</table>
