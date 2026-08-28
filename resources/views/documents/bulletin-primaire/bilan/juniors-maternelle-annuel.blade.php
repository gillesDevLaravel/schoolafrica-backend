<!-- Tableau de bilan -->
<div style="margin-top: {{ count($sequences) > 1 ? '80' : '5'}}px">
    <table style="width: 100%; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
        <tr bgcolor="#DBDBDB" style="height: 20px;">
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                    {{ __('bul_mat.res_travail') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                    {{ __('bul_mat.visa_dir') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                    {{ __('bul_mat.visa_ens') }}
                </p>
            </td>
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                    {{ __('bul_mat.visa_par') }}
                </p>
            </td>
        </tr>
        <tr style="height: 20px;">
            @php
                $moyenne = $evaluation['moyenneGenerale'] ?? null;
                $moyenneTrimestre = $moyenne;
                $appreciation = getAppreciationStickerWithNull($moyenneTrimestre, 20);
                $couleurMoyenneTrimestre = getAppreciationGradeAndColor($moyenneTrimestre, 20);

                if($moyenneTrimestre < 10) {$appreciation_txt = __('bulletin_primaire.appr_nye_txt'); }
                else if($moyenneTrimestre < 15) {$appreciation_txt = __('bulletin_primaire.appr_ae_txt'); }
                else if($moyenneTrimestre < 18) {$appreciation_txt = __('bulletin_primaire.appr_me_txt'); }
                else {$appreciation_txt = __('bulletin_primaire.appr_abe_txt'); }
            @endphp
            <td style="width: 20%; @if($moyenneTrimestre === null || $evaluation['isEvalue'] === false)background-color: black; @endif" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                    @if($appreciation && file_exists(public_path("public/profil/$appreciation")))
                        <img style="text-align: center; margin-top: 2px; width: 30px; height: 30px; margin-right:10px; border-radius: 50%" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("public/profil/$appreciation"))) }}">
                    @endif
                </p>
            </td>
            <td rowspan="3" style="width: 20%;" class="td_border" >
                @if(file_exists(public_path('public/profil/'. $ecole->principal->signature)))
                    <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                        <img
                            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/'. $ecole->principal->signature))) }}"
                            alt="Signature"
                            style="height: 60px; object-fit: contain;"
                        >
                    </p>
                @endif
            </td>
            <td rowspan="3" style="width: 20%;" class="td_border" >
                @if(file_exists(public_path('public/profil/'. $infosClasse['signatureEnseignant'])))
                    <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;">
                        <img
                            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/'. $infosClasse['signatureEnseignant']))) }}"
                            alt="Signature"
                            style="height: 60px; object-fit: contain;"
                        >
                    </p>
                @endif
            </td>
            <td rowspan="3" style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center;"></p>
            </td>
        </tr>
        <tr style="height: 20px;">
            <td style="width: 20%;" class="td_border" >
                <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center; color: #{{$legend_of_grade[$couleurMoyenneTrimestre[1]]}}"> {{ $couleurMoyenneTrimestre[2] }}</p>
            </td>
        </tr>

        @if(count($trimestres) > 1)
            <tr style="height: 20px;">
                <td style="width: 20%;" class="td_border" >
                    <p class="s10" style="padding: 2.5pt; text-indent: 0pt; line-height: 15pt; text-align: center; color: #{{$legend_of_grade[$couleurMoyenneTrimestre[1]]}}"> {{ $decisionAnnuelle ?? '-' }} </p>
                </td>
            </tr>
        @endif
    </table>
</div>
