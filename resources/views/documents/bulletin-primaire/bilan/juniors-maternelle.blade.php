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
                $moyenneTrimestre = $evaluation['moyenneGenerale'] ?? null;
                $appreciation = getAppreciationStickerWithNull($moyenneTrimestre, 20);
                $couleurMoyenneTrimestre = getAppreciationGradeAndColor($moyenneTrimestre, 20);

                if($moyenneTrimestre < 10) {$appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                else if($moyenneTrimestre < 15) {$appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                else if($moyenneTrimestre < 18) {$appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                else {$appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }
            @endphp
            <td style="width: 20%; @if($moyenneTrimestre === null || $evaluation['isEvalue'] === false)background-color: black; @endif" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    @if($appreciation && file_exists(public_path("/public/profil/$appreciation")))
                        <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$appreciation"))) }}">
                    @else
                        <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation0.png"))) }}">
                    @endif
                </p>
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                @if(file_exists(public_path('public/profil/'. $infosClasse['signatureEnseignant'])))
                    <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/'. $infosClasse['signatureEnseignant']))) }}"
                        alt="Signature"
                        style="height: 60px; object-fit: contain;"
                    >
                @endif
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                @if(file_exists(public_path('public/profil/'. $ecole->principal->signature)))
                    <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/'. $ecole->principal->signature))) }}"
                        alt="Signature"
                        style="height: 60px; object-fit: contain;"
                    >
                @endif
            </td>
            <td rowspan="2" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;"></p>
            </td>
        </tr>
        <tr>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$couleurMoyenneTrimestre[1]]}}"> {{ $couleurMoyenneTrimestre[2] }}</p>
            </td>
        </tr>
    </table>
</div>
