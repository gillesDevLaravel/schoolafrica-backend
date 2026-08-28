<!-- Notes et statistiques d'évaluation -->
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr style="background-color: #{{$codeCouleur[0]}};">
        <td class="td_border"  style="width: 35%; border-right-color: #ffffff;">
            <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                {{ __('bulletin_primaire.domain_subject') }}
            </p>
        </td>
        <td class="td_border" style="width: 35%; border-right-color: #ffffff;">
            <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: white; ">
                {{ __('bul_mat.acti') }}
            </p>
        </td>
        <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>MKS</strong>
            </p>
        </td>
        {{ $trimCount = 0 }}
        @foreach($trimestres as $trimestre)
            {{ $trimCount ++ }}
            <td class="td_border" style="width: 60%;" >
                <p class="s10" style="font-weight: bold; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ strtoupper(__('bulletin_primaire.tirm') . $trimCount) }}
                </p>
            </td>
        @endforeach
        <td style="border-right: 1pt solid white; width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;" >
            <p class="s10" style="color: white; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                <strong>SCORE</strong>
            </p>
        </td>
        <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>{{ __('bulletin_primaire.rank') }}</strong>
                {{--                    <strong>{{ "POS." }}</strong>--}}
            </p>
        </td>
        <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>%S</strong>
            </p>
        </td>
        <td style="width: 5pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>{{ strtoupper(__('bulletin_primaire.gen_avg')) }}</strong>
            </p>
        </td>
        <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #ffffff;" >
            <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>SYN.</strong>
                {{--                    <strong>{!! __('bulletin_primaire.skill_synth') !!}</strong>--}}
            </p>
        </td>
        <td style="border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
            <p class="s10" style="padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                <strong>APP.</strong>
            </p>
        </td>
    </tr>

    @foreach($donneesMatieres as $groupeMatiere)
        <!-- Nom et description du groupe de matière -->
        @php
            $groupeMatiere0 = $evaluation['groupesMatieres'][$groupeMatiere['idGroupeMat']] ?? null;
            $colonnesAdditionnelles = count($trimestres) > 1 ? 9 + count($trimestres) : 9;
        @endphp
        <tr style="height: 10pt;">
            <td colspan="{{ $colonnesAdditionnelles }}" style="background-color: #bdb3b3; height:10pt; vertical-align: middle; border: 1pt solid #808080;">
                <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;">
                    <strong>{{ $groupeMatiere['nomGroupeMat'] ?? '' }} : {{ $groupeMatiere['description'] ?? '' }}</strong>
                </p>
            </td>
        </tr>

        @foreach($groupeMatiere['matieres'] as $matiere)
        <!-- Nom et description de la matière -->
            @php
                $matiere0 = $groupeMatiere0['matieres'][$matiere['idMatiere']] ?? null;
                $cles = array_keys($matiere['typeEvaluations'] ?? []);
            @endphp
            <tr style="height: 16pt;">

                <!-- Nom || Libelle matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">
                        {{ $matiere['libelleMatiere'] ?? '-' }}
                    </p>
                </td>

                <!-- Libelle type d'evaluation -->
                <td style="padding-left:0pt!important; width: 10pt; border: 1pt solid #808080; vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        <p class="s14" style="vertical-align:middle; text-align:center; @if($key != end($cles))border-bottom: 1pt solid #808080;@endif">
                            {{ $typeEvaluation['libelleTypeEval'] ?? '-' }}
                        </p>
                    @endforeach
                </td>
                <td style="padding-left:0pt!important; width: 10pt; border: 1pt solid #808080; vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                    <!-- Note max type d'evaluation -->
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                        @endphp
                        <p class="s14" style="vertical-align:middle; text-align:center; @if($key != end($cles))border-bottom: 1pt solid #808080;@endif">
                            @if($typeEvaluation0['noteMax'] !== null)
                                {{ '/'.round($typeEvaluation0['noteMax']) }}
                            @else
                                /-
                            @endif
                        </p>
                    @endforeach
                </td>

                    @foreach($trimestres as $trimestre)
                    <!-- Note obtenu par trimestre -->
                        <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">

                            @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                                @php
                                    $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                                    $idTrimestre = $trimestre['id'];
                                @endphp

                                @if($typeEvaluation0 !== null && isset($typeEvaluation0['trimestres']["trimestre$idTrimestre"]))

                                    <p class="s14" style="font-weight:bold;  @if($key != end($cles))border-bottom: 1pt solid #808080;@endif text-align: center; @if($typeEvaluation0['trimestres']["trimestre$idTrimestre"] < $typeEvaluation0['noteMax']/2) color: red @endif">
                                        {{ number_format_if_float($typeEvaluation0['trimestres']["trimestre$idTrimestre"], 2) }}
                                    </p>

                                @else
                                    @if($key != end($cles))
                                        <p class="s14" style=" border-bottom: 1pt solid #808080; text-align: center;">-</p>
                                    @else
                                        <p class="s14" style=" text-align: center;">-</p>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endforeach

                <!-- Sommes des notes Trimestrielles -->
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                        @endphp
                        <p class="s14" style="@if($key != end($cles))border-bottom: 1px solid #808080;@endif text-align: center;  @if($typeEvaluation0["totalNoteObtenu"] < $typeEvaluation0['noteMax']/2) color: red @endif; font-weight: bold;">
                            @if(!is_null($typeEvaluation0["totalNoteObtenu"]))
                                {{ number_format_if_float($typeEvaluation0["totalNoteObtenu"], 2) }}
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>

                <!-- Rang sur le type d'évaluation -->
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                        @endphp
                        <p class="s14" style="@if($key != end($cles))border-bottom: 1px solid #808080;@endif text-align: center;">
                            @if($typeEvaluation0["totalNoteObtenu"] !== null)
                                {!! getStudentRank((array_search($typeEvaluation0['totalNoteObtenu'], $typeEvaluation['notesObtenues'])) + 1) !!}
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>


                <!-- Pourcentage sur le type d'évaluation -->
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php $appreciation = getAppreciationGradeAndColor($typeEvaluation['pourcentageReussite'], 100); @endphp
                        <p class="s14" style="font-weight:bold;@if($key != end($cles))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                            @if($typeEvaluation['pourcentageReussite'] !== null && $typeEvaluation0["totalNoteObtenu"] !== null)
                                {{ @number_format_if_float($typeEvaluation['pourcentageReussite'], 1) }}%
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>

                <!-- Moyenne générale sur le type d'évaluation -->
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php $appreciation = getAppreciationGradeAndColor($typeEvaluation['moyenneGenerale'], $typeEvaluation['noteMaxgenerale']); @endphp
                        <p class="s14" style="font-weight: bold;@if($key != end($cles))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{$legend_of_grade[$appreciation[1]]}}">
                            @if($typeEvaluation['moyenneGenerale'] !== null && $typeEvaluation0["totalNoteObtenu"] !== null)
                                {{ @number_format_if_float($typeEvaluation['moyenneGenerale'], 2) ?? '-' }}
                            @else
                                -
                            @endif
                        </p>
                    @endforeach
                </td>

                <!-- Total, rang, pourcentage de réussite matière -->
                <td style="vertical-align: middle;width: 25pt; padding-left: 5pt; border: 1pt solid #808080">
                    <p style="text-indent: 0pt; text-align: center;">
                        @if($matiere0['totalNoteObtenus'] !== null)
                            <span style="font-weight: bold; @if($matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax']/2) color: red @endif">{{ number_format_if_float($matiere0['totalNoteObtenus'], 1)." / ". number_format_if_float($matiere0['totalNoteMax']) }}</span>
                            <br> {{ __('bulletin_primaire.rank') }}: {{ (array_search($matiere0['totalNoteObtenus'], $matiere['notesObtenues'])) + 1 }}
                            <br> {{ number_format_if_float($matiere['pourcentageReussite'], 1) }}% S
                        @else
                            <span style="font-weight: bold; @if($matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax']/2) color: red @endif">-</span>
                            <br> {{ __('bulletin_primaire.rank') }}
                            <br> % S
                        @endif
                    </p>
                </td>

                <!-- Appréciation obtenue sur la matière -->
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @php

                        if($matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax']/2)
                        {
                            $grade = __('bulletin_primaire.appr_nye_classik');
                            $grade_color = "nye_color";
                        }
                        else if($matiere0['totalNoteMax']/2 <= $matiere0['totalNoteObtenus'] && $matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax'] * (3/4)){
                            $grade = __('bulletin_primaire.appr_ae_classik');
                            $grade_color = "ae_color";
                        }
                        else if($matiere0['totalNoteMax'] * (3/4) <= $matiere0['totalNoteObtenus'] && $matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax'] * (9/10)){
                            $grade = __('bulletin_primaire.appr_me_classik');
                            $grade_color = "me_color";
                        }else{
                            $grade = __('bulletin_primaire.appr_abe_classik');
                            $grade_color = "abe_color";
                        }
                    @endphp

                    <p class="s13" style="text-indent: 0pt; text-align: center; color: #{{$legend_of_grade[$grade_color]}}; font-weight: bold">
                        @if($matiere0['totalNoteObtenus'] !== null)
                            {{ $grade }}
                        @else
                            -
                        @endif
                    </p>
                </td>
            </tr>
        @endforeach
    @endforeach

</table>
