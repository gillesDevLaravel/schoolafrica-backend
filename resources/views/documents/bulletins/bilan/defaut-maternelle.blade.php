<!-- Tableau de bilan -->
<div style="margin-top: {{ count($sequences) > 1 ? '80' : '5'}}px">
    <table style="width: 100%; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
        <tr bgcolor="#DBDBDB">
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bul_mat.res_travail') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bul_mat.visa_ens') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bul_mat.visa_dir') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bul_mat.visa_par') }}
                </p>
            </td>
        </tr>
        <tr>
            @php
                $moyenneTrimestreSur4 = (($eleve['bilan']['moyenne'] ?? null) !== null) ? ($eleve['bilan']['moyenne'] * 4) / 20 : null;


                $appreciation = getAppreciationStickerForMaternelle($moyenneTrimestreSur4, true);
                $couleurMoyenneTrimestre = getAppreciationColorForMaternelle($moyenneTrimestreSur4, true);

                if($moyenneTrimestreSur4 <= 1) {$appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                else if($moyenneTrimestreSur4 <= 2) {$appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                else if($moyenneTrimestreSur4 <= 3) {$appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                else if($moyenneTrimestreSur4 <= 4){$appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }
                else {$appreciation_txt = '-'; }
            @endphp
            <td style="width: 20%; @if($moyenneTrimestreSur4 === null || $eleve['bilan']['isValid'] === false)background-color: black; @endif" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$appreciation"))) }}">
                </p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
        </tr>
        <tr>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$couleurMoyenneTrimestre[0]]}}"> {{ $couleurMoyenneTrimestre[1] }}</p>
            </td>
        </tr>
    </table>
</div>
