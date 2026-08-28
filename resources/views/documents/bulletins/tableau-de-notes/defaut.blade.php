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
        @if(count($sequences) > 1)
            @foreach($sequences as $sequence)
                <td class="td_border" style="width: 6%; border-right-color: #ffffff;" >
                    <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                        EVAL {{ $sequence['name'][-1] }}
                    </p>
                </td>
            @endforeach
        @endif
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

    @php
        $idGroupeMatieres = array_filter(array_keys($statistiques), 'is_int');
    @endphp

    @foreach($statistiques as $idGroupeMatiere => $groupeMatiere)
        @if(!ctype_digit((string) $idGroupeMatiere))
            @continue
        @endif

        <!-- Nom et description du groupe de matière -->
        <tr style="height: 10pt;">
            <td colspan="{{ (count($sequences) > 1) ? 9 + count($sequences) : 9 }}"
                style="background-color: #bdb3b3; height:10pt; vertical-align: middle; border: 1pt solid #808080;">
                <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;">
                    <strong>{{ $groupeMatiere['name'] ?? '' }}
                        {{ !empty($groupeMatiere['description']) ? ' : ' . $groupeMatiere['description'] : "$idGroupeMatiere" }}
                    </strong>
                </p>
            </td>
        </tr>
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


            <tr style="height: 16pt;">


                <!-- Nom || Libelle matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">
                        {{ $matiere['matter_libelle'] ?? '-' }}
                    </p>
                </td>

                <!-- Libelle type d'évaluation -->
                <td style="padding-left:0pt!important; width: 10pt; border: 1pt solid #808080; vertical-align:middle;">
                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif
                        <p class="s14" style="vertical-align:middle; text-align:center; @if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif">
                            {{ $typeEvaluation['nomTypeEvaluation'] ?? '-' }}
                        </p>
                    @endforeach
                </td>

                <!-- Note max type d'evaluation -->
                <td style="padding-left:0pt!important; width: 10pt; border: 1pt solid #808080; vertical-align:middle;">
                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif
                        @php
                            $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation] ?? null;

//                            dd($typeEvaluation)
                        @endphp
                        <p class="s14" style="vertical-align:middle; text-align:center; @if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif">
                            {{ '/' . round($typeEvaluation['noteMaxTypeEvaluation']) ?? '-' }}
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
                                @endphp

                                @if($typeEvaluation !== null )

                                    <p class="s14" style="font-weight:bold;  @if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1pt solid #808080;@endif text-align: center; @if($typeEvaluation['noteTypeEvaluation'] < ($typeEvaluation['noteMaxTypeEvaluation'] / 2)) color: red @endif">
                                        {{ round($typeEvaluation['noteTypeEvaluation'], 2) }}
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
                            $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation];
                        @endphp

                        <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations))border-bottom: 1px solid #808080;@endif text-align: center;  @if($typeEvaluation["noteTypeEvaluation"] < ($typeEvaluation['noteMaxTypeEvaluation'] / 2)) color: red @endif; font-weight: bold;">
                            {{ (($typeEvaluation["noteTypeEvaluation"] ?? null) !== null) ? round($typeEvaluation["noteTypeEvaluation"], 2) : '-' }}
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
                            {!! ($typeEvaluation["noteTypeEvaluation"] !== null)
                                    ? getStudentRank((array_search($typeEvaluation["noteTypeEvaluation"], $notes)) + 1)
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
                            {{ (($typeEvaluation['success_rate'] ?? null) !== null)
                                ? @number_format_if_float($typeEvaluation['success_rate'], 1) . ''
                                : '-'
                            }}
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
                            {{ (($typeEvaluation['average'] ?? null) !== null) ? @number_format_if_float($typeEvaluation['average'], 2) : '-' }}
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
                            <span style="font-weight: bold; @if($matiere['noteMatiere'] < ($matiere['noteMaxMatiere']/2)) color: red @endif">{{ number_format_if_float($matiere['noteMatiere'], 1)." / ". round($matiere['noteMaxMatiere']) }}</span>
                            <br> {{ __('bulletin_primaire.rank') }} : {{ (array_search($matiere['noteMatiere'], $notes)) + 1 }}
                            <br> {{ number_format_if_float($pourcentage, 1) }}% S
                        @else
                            -
                        @endif
                    </p>
                </td>

                <!-- Appréciation obtenue sur la matière -->
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @php

                        if (($matiere['noteMatiere'] ?? null) !== null){
                            if($matiere['noteMatiere'] < $matiere['noteMaxMatiere']/2)
                            {
                                $grade = __('bulletin_primaire.appr_nye_classik');
                                $grade_color = "nye_color";
                            }
                            else if($matiere['noteMaxMatiere']/2 <= $matiere['noteMatiere'] && $matiere['noteMatiere'] < $matiere['noteMaxMatiere'] * (3/4)){
                                $grade = __('bulletin_primaire.appr_ae_classik');
                                $grade_color = "ae_color";
                            }
                            else if($matiere['noteMaxMatiere'] * (3/4) <= $matiere['noteMatiere'] && $matiere['noteMatiere'] < $matiere['noteMaxMatiere'] * (9/10)){
                                $grade = __('bulletin_primaire.appr_me_classik');
                                $grade_color = "me_color";
                            }else{
                                $grade = __('bulletin_primaire.appr_abe_classik');
                                $grade_color = "abe_color";
                            }
                        }
                        else{
                            $grade = __('bulletin_primaire.appr_abe_classik');
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
        @endforeach
    @endforeach
</table>
