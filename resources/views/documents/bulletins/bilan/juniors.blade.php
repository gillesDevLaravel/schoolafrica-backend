<!-- Tableau de bilan -->
<div style="width: 100%;">
    <table style="width: 100%; border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
        <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
            <td colspan="4" style="width: 80px;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ count($sequences) > 1 ? __('bulletin_primaire.res_analys_trim') : __('bulletin_primaire.res_analys') }}</strong>
                </p>
            </td>
            <td colspan="2" style="border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bul_mat.visa_ens') }}</strong>
                </p>
            </td>
            <td colspan="2" style="border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bul_mat.visa_dir') }}</strong>
                </p>
            </td>
            <td colspan="2" style="border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{{ __('bul_mat.visa_par') }}</strong>
                </p>
            </td>
        </tr>

        <tr>
            @php
                $appreciation = getAppreciationGradeAndColor($eleve['bilan']['moyenne'], 20);

                if(count($statistiques['class_averages']) > 0)
                {
                    $bestMoyenne = $statistiques['class_averages'][0];
                    $gradeBestMoyenne = getAppreciationGradeAndColor($bestMoyenne, 20);


                    $worstMoyenne = end($statistiques['class_averages']);
                    $gradeWorstMoyenne = getAppreciationGradeAndColor($worstMoyenne, 20);
                }
                else{
                    $bestMoyenne = null;
                    $gradeBestMoyenne = getAppreciationGradeAndColor(0, 20);

                    $worstMoyenne = null;
                    $gradeWorstMoyenne = getAppreciationGradeAndColor(0, 20);
                }
            @endphp

            <td colspan="2" style="width: 27px;border: 1pt solid #808080">
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">

                    @php $appreciation = getAppreciationGradeAndColor($eleve['bilan']['moyenne'], 20); @endphp
                    TOTAL:
                    <span style="color: #{{$legend_of_grade[$appreciation[1]]}}">
                        @if(count($sequences) > 1)
                            {{ number_format_if_float($eleve['bilan']['note'], 2) }}
                        @else
                            {{ number_format_if_float($eleve['bilan']['note'], 1) }}
                        @endif

                        /{{ number_format_if_float($eleve['bilan']['noteMax']) }}
                    </span>
                </p>
            </td>

            <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px; border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.high_av') }}
                </p>
            </td>

            <td style="width: 27px; border: 1pt solid #808080" >

                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeBestMoyenne[1]]}}">
                    @if(count($sequences) > 1)
                        {{ number_format_if_float($bestMoyenne, 1) }}/20
                    @else
                        {{ number_format_if_float($bestMoyenne, 2) }}/20
                    @endif
                </p>
            </td>

            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080; text-align: center; vertical-align: middle;">
                @if(file_exists(public_path('public/profil/sign-enseignant-'. $classe['name'] .'.png')))
                    <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/sign-enseignant-'. $classe['name'] .'.png'))) }}"
                        alt="Signature"
                        style="height: 60px; object-fit: contain;"
                    >
                @endif
            </td>

            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080; text-align: center; vertical-align: middle">
                @if(file_exists(public_path('public/profil/sign-directeur-'. $route .'.png')))
                    <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/sign-directeur-'. $route .'.png'))) }}"
                        alt="Signature"
                        style="height: 60px; object-fit: contain;"
                    >
                @endif
            </td>

            <td colspan="2" rowspan="4" style="width: 20%;border: 1pt solid #808080"></td>
        </tr>

        <tr>
            <td colspan="2" rowspan="2" style="border: 1pt solid #808080; color: white; background-color: #{{ $eleve['bilan']['isValid']? $legend_of_grade[$appreciation[1]] : '000000'}}; white-space: nowrap; padding: 2pt;">
                <p class="s10" style="text-indent: 0pt; line-height: 10pt; text-align: center; color: white; margin: 0;">
                    <strong>{{ __('bulletin_primaire.avg') }}</strong>:
                    <span style="font-weight: bold; font-size: 20px;">
                        @if(count($sequences) > 1)
                            {{ number_format_if_float($eleve['bilan']['moyenne'], 1) }}
                        @else
                            {{ number_format_if_float($eleve['bilan']['moyenne'], 2) }}
                        @endif
                    </span>
                    <strong>/20</strong>
                </p>
            </td>


            <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.low_avg') }}
                </p>
            </td>

            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$gradeWorstMoyenne[1]]}}">
                    @if(count($sequences) > 1)
                        {{ number_format_if_float($worstMoyenne, 1) }}/20
                    @else
                        {{ number_format_if_float($worstMoyenne, 2) }}/20
                    @endif
                </p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 27px;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.class_avg') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                @php
                    $classAvgColor = getAppreciationGradeAndColor($statistiques['general_average'], 20);
                @endphp
                <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$classAvgColor[1]]}}">
                    @if(count($sequences) > 1)
                        {{ number_format_if_float($statistiques['general_average'], 1) }}/20
                    @else
                        {{ number_format_if_float($statistiques['general_average'], 2) }}/20
                    @endif
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="width: 27px;border: 1pt solid #808080; ">
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                    <strong>{{ $appreciation[2] }}</strong>
                </p>
            </td>

            <td style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}}; width: 59px;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    % {{ __('bulletin_primaire.success') }}
                </p>
            </td>
            <td style="width: 20%;border: 1pt solid #808080" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    @php $classSuccessPercentageColor = getAppreciationGradeAndColor($statistiques['general_success_rate'], 100); @endphp
                    <strong style="color: #{{$legend_of_grade[$classSuccessPercentageColor[1]]}}">
                        {{ number_format_if_float($statistiques['general_success_rate'], 2) }}%
                    </strong>
                </p>
            </td>
        </tr>
    </table>
</div>
