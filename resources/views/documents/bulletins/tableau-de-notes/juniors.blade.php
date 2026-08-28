<!-- Notes et statistiques d'évaluation -->
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
        <td style="width: 50pt;border: 1pt solid #808080; ">
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                {{ strtoupper(__('bulletin_primaire.domain_subject')) }}
            </p>
        </td>
        <td style="width: 90pt;border: 1pt solid #808080; ">
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                {{ strtoupper(__('bulletin_primaire.description')) }}
            </p>
        </td>
        <td style=" width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                {{ strtoupper(__('bulletin_primaire.evaluations')) }}
            </p>
        </td>
        <td style=" width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; text-align: center; font-weight: bold">
                MKS
            </p>
        </td>
        @if(count($sequences) > 1)
            @foreach($sequences as $sequence)
                <td class="td_border" style="width: 60%;" >
                    <p class="s10" style="font-weight: bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                        {{ strtoupper($sequence['name']) }}
                    </p>
                </td>
            @endforeach
        @endif
        <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>SCORE</strong>
            </p>
        </td>
        <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                {{ strtoupper(__('bulletin_primaire.rank')) }}
            </p>
        </td>
        <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; font-weight: bold">
                %S
            </p>
        </td>
        <td style="border-right: none; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ strtoupper(__('bulletin_primaire.gen_avg')) }}
            </p>
        </td>
        <td style="border-right: none; border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {!! strtoupper(__('bulletin_primaire.skill_synth')) !!}
            </p>
        </td>
        <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
            <p class="s10" style="font-weight:bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                {{ strtoupper('App.') }}
            </p>
        </td>
    </tr>

    @php $index_tr = 0; //index des balises tr du tableau @endphp

    @php
        $idGroupeMatieres = array_filter(array_keys($statistiques), 'is_int');
    @endphp

    @foreach($statistiques as $idGroupeMatiere => $groupeMatiere)
        @if(!ctype_digit((string) $idGroupeMatiere))
            @continue
        @endif

            @php
                $idMatieres = array_filter(array_keys($groupeMatiere), 'is_int');
            @endphp
            @foreach($groupeMatiere as $idMatiere => $matiere)
                @if(!ctype_digit((string) $idMatiere))
                    @continue
                @else
                    @php
                        $idTypeEvaluations = array_filter(array_keys($matiere), 'is_int');
                    @endphp
                @endif

{{--        @foreach($groupeMatiere['matieres'] as $matiere)--}}
                <!-- Nom et description de la matière -->
{{--            @php--}}
{{--                $matiere0 = $groupeMatiere0['matieres'][$matiere['idMatiere']] ?? null;--}}
{{--                $cles = array_keys($matiere['typeEvaluations'] ?? []);--}}
{{--            @endphp--}}

                <tr style="height: 16pt; @if($index_tr % 2 == 1) background-color: #e8e7e7; @endif ">
                    <!-- Code matière -->
                    <td style="width: 30pt;vertical-align: middle;border: 1pt solid #808080">
                        <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;font-weight: bold">{{ "(". $matiere['matter_code'] .") ". $matiere['matter_name'] }}</p>
                    </td>

                    <!-- Nom || Libelle matière -->
                    <td style="width: 40pt; border: 1px solid #808080; vertical-align: middle;">
                        <p class="s14" style="text-align: center; margin: 0;font-size: 9px">{{ $matiere['matter_libelle'] }}</p>
                    </td>

                    <!-- Nom type d'evaluation -->
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @if($idTypeEvaluation != end($idTypeEvaluations))
                                <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;">{{ $typeEvaluation['nomTypeEvaluation'] ?? "-" }}</p>
                            @else
                                <p class="s14" style="vertical-align:middle; text-align:center;">{{ $typeEvaluation['nomTypeEvaluation'] ?? "-" }}</p>
                            @endif
                        @endforeach
                    </td>

                    <!-- Note max type d'evaluation -->
                    <td style="padding-left:0pt!important; width: 3pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @php
                                $typeEvaluation = $eleve['bilan'][$idMatiere][$idTypeEvaluation] ?? null;
                            @endphp

                            <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1px solid #808080;@endif text-align: center;">
                                {{
                                    (($typeEvaluation['noteMaxTypeEvaluation'] ?? null) !== null)
                                    ? '/' . number_format_if_float($typeEvaluation['noteMaxTypeEvaluation'])
                                    : '/-'
                                }}
                            </p>
                        @endforeach
                    </td>

                    @if(count($sequences) > 1)
                        @foreach($sequences as $sequence)
                            <!-- Note obtenu par sequence -->
                            <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">

                                @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                                    @if(!ctype_digit((string) $idTypeEvaluation))
                                        @continue
                                    @endif

                                    @php
                                        $idSequence = $sequence['id'];
                                        $typeEvaluation = $eleve["sequence$idSequence"][$idMatiere][$idTypeEvaluation] ?? null;
                                        $couleurSequence = getAppreciationGradeAndColor($typeEvaluation['noteTypeEvaluation'], $typeEvaluation['noteMaxTypeEvaluation']);
                                    @endphp

                                    @if($typeEvaluation !== null && isset($typeEvaluation['noteTypeEvaluation']))
                                        <p class="s14" style="font-weight:bold;  @if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{ $legend_of_grade[$couleurSequence[1]] }};">
                                            {{ number_format_if_float($typeEvaluation['noteTypeEvaluation'], 1) }}
                                        </p>
                                    @else
                                        @if($idTypeEvaluation != end($idTypeEvaluations))
                                            <p class="s14" style=" border-bottom: 1pt solid #808080; text-align: center;">-</p>
                                        @else
                                            <p class="s14" style=" text-align: center;">-</p>
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                    @endif

                    <!-- Sommes des notes sequentilles -->
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @php
                                $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation] ?? null;
                                $couleurBilan = getAppreciationGradeAndColor($typeEvaluation['noteTypeEvaluation'], $typeEvaluation['noteMaxTypeEvaluation']);
                            @endphp

                            <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1px solid #808080;@endif text-align: center; color: #{{ $legend_of_grade[$couleurBilan[1]] }}; font-weight: bold;">
                                {{
                                    ($typeEvaluation["noteTypeEvaluation"] ?? null)
                                    ? number_format_if_float($typeEvaluation["noteTypeEvaluation"], 2)
                                    : '-'
                                }}
                            </p>
                        @endforeach
                    </td>

                    <!-- Rang sur le type d'évaluation -->
                    <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @php
                                $notes = $typeEvaluation['notes'];
                                $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation];
                            @endphp

                            <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1px solid #808080;@endif text-align: center;">
                                {!!
                                    ($typeEvaluation["noteTypeEvaluation"] ?? null)
                                    ? getStudentRank((array_search($typeEvaluation['noteTypeEvaluation'], $notes)) + 1)
                                    : '-'
                                !!}
                            </p>
                        @endforeach
                    </td>

                    <!-- Pourcentage sur le type d'évaluation -->
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @php $appreciation = getAppreciationGradeAndColor($typeEvaluation['success_rate'], 100); @endphp

                            <p class="s14" style="font-weight:bold;@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                {{ ($typeEvaluation['success_rate'] !== null) ? @number_format_if_float($typeEvaluation['success_rate'], 2) . '%' : '-' }}
                            </p>
                        @endforeach
                    </td>

                    <!-- Moyenne générale sur le type d'évaluation -->
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                            @if(!ctype_digit((string) $idTypeEvaluation))
                                @continue
                            @endif

                            @php $appreciation = getAppreciationGradeAndColor($typeEvaluation['average'], 20); @endphp

                            <p class="s14" style="font-weight: bold;@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                                    {{ ($typeEvaluation['average'] !== null) ? @number_format_if_float($typeEvaluation['average'], 2) : '-' }}
                            </p>
                        @endforeach
                    </td>

                    <!-- Total, rang, pourcentage de réussite matière -->
                    <td style="vertical-align: middle;width: 25pt; padding-left: 5pt; border: 1pt solid #808080">
                        <p style="text-indent: 0pt; text-align: center;">
                            @php
                                $notes = $matiere['notes'];
                                $pourcentage = $matiere['success_rate'];
                                $matiere = $eleve['bilan'][$idMatiere];
                            @endphp

                            @if(($matiere['noteMatiere'] ?? null) !== null)
                                <span style="color: #{{ $legend_of_grade[getAppreciationGradeAndColor($matiere['noteMatiere'], $matiere['noteMaxMatiere'])[1]] }}; @if($matiere['noteMatiere'] < $matiere['noteMaxMatiere']/2) color: red @endif">
                                    {{ number_format_if_float($matiere['noteMatiere'], 1) }}
                                </span>/{{ number_format_if_float($matiere['noteMaxMatiere']) }}
                                <br> {{ __('bulletin_primaire.rank') }}: {{ (array_search($matiere['noteMatiere'], $notes)) + 1 }}
                                <br> {{ number_format_if_float($pourcentage, 1) }}% S
                            @else
                                -
                            @endif
                        </p>
                    </td>

                    <!-- Appréciation obtenue sur la matière -->
                    <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                        @php
                            if (isset($matiere['noteMatiere'])){
                                if($matiere['noteMatiere'] < $matiere['noteMaxMatiere']/2)
                                {
                                    $grade = __('bulletin_primaire.appr_nye');
                                    $grade_color = "nye_color";
                                }
                                else if($matiere['noteMaxMatiere']/2 <= $matiere['noteMatiere'] && $matiere['noteMatiere'] < $matiere['noteMaxMatiere'] * (3/4)){
                                    $grade = __('bulletin_primaire.appr_ae');
                                    $grade_color = "ae_color";
                                }
                                else if($matiere['noteMaxMatiere'] * (3/4) <= $matiere['noteMatiere'] && $matiere['noteMatiere'] < $matiere['noteMaxMatiere'] * (9/10)){
                                    $grade = __('bulletin_primaire.appr_me');
                                    $grade_color = "me_color";
                                }
                                else{
                                    $grade = __('bulletin_primaire.appr_abe');
                                    $grade_color = "abe_color";
                                }
                            }
                            else{
                                $grade = __('bulletin_primaire.appr_abe');
                                $grade_color = "abe_color";
                            }
                        @endphp

                        <p class="s13" style="text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}; font-weight: bold">
                            @if(($matiere['noteMatiere'] ?? null) !== null)
                                {{ $grade }}
                            @else
                                -
                            @endif
                        </p>
                    </td>
                </tr>
            @php $index_tr++; @endphp
        @endforeach
    @endforeach
</table>
