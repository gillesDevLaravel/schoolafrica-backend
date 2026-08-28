<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <tr>
        <td style="text-align: center; width: auto; padding: 0;">
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width: auto; height: 80px; margin-right:10px; margin-top:-10px !important;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @endif
        </td>
    </tr>
    <tr>
        <td style="text-align: center; vertical-align: top;">
            <div style="font-size: 14px; line-height: 1.2;">
                <div style="margin-top: 2px; font-size: 14px;">Établissement Inter-États d’Enseignement Supérieur</div>
                <div style="margin-top: 2px; font-size: 14px;">Représentation du Cameroun</div>
                <div style="margin-top: 2px; font-weight: bold; font-size: 14px;">
                    CENTRE D’EXCELLENCE TECHNOLOGIQUE PAUL BIYA
                </div>
                <div style="margin-top: 2px; font-size: 14px;">
                    BP 13 719 Yaoundé (Cameroun)  Tél. (237) 242 72 99 57 / 242 72 99 58 / 691 902 120
                </div>
                <div style="font-size: 14px;">
                    Site web: www.iaicameroun.com &nbsp;&nbsp; E-mail: contact@iaicameroun.com
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 6px;">
            <div style="height: 2px; background-color: #7a704788; width: 100%;"></div>
        </td>
    </tr>
 
</table>
