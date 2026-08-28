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
    @foreach($donneesMatieres as $groupeMatiere)
        <!-- Nom et description du groupe de matière -->
        @php
            $groupeMatiere0 = $evaluation['groupesMatieres'][$groupeMatiere['idGroupeMat']] ?? null;
            $colonnesAdditionnelles = count($sequences) > 1 ? 9 + count($sequences) : 9;
        @endphp

        @foreach($groupeMatiere['matieres'] as $matiere)
        <!-- Nom et description de la matière -->
            @php
                $matiere0 = $groupeMatiere0['matieres'][$matiere['idMatiere']] ?? null;
                $cles = array_keys($matiere['typeEvaluations'] ?? []);
            @endphp

            <tr style="height: 16pt; @if($index_tr % 2 == 1) background-color: #e8e7e7; @endif "">
                <!-- Code matière -->
                <td style="width: 30pt;vertical-align: middle;border: 1pt solid #808080">
                    <p class="s13" style="line-height: 109%; text-align: center; margin-left: 1pt;font-weight: bold">{{ "(". $matiere['codeMatiere'] .") ". $matiere['nomMatiere'] }}</p>
                </td>

                <!-- Nom || Libelle matière -->
                <td style="width: 40pt; border: 1px solid #808080; vertical-align: middle;">
                    <p class="s14" style="text-align: center; margin: 0;font-size: 9px">{{ $matiere['libelleMatiere'] }}</p>
                </td>

                <!-- Nom type d'evaluation -->
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @if($key != array_key_last($matiere['typeEvaluations']))
                            <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;">{{ $typeEvaluation['nomTypeEval'] ?? "-" }}</p>
                        @else
                            <p class="s14" style="vertical-align:middle; text-align:center;">{{ $typeEvaluation['nomTypeEval'] ?? "-" }}</p>
                        @endif
                    @endforeach
                </td>

                <!-- Note max type d'evaluation -->
                <td style="padding-left:0pt!important; width: 3pt;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                        @endphp
                        <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations']))border-bottom: 1px solid #808080;@endif text-align: center;">
                            
                            @if($typeEvaluation0['noteMax'] !== null)
                                {{ '/'.number_format_if_float($typeEvaluation0['noteMax']) }}
                            @else
                                /-
                            @endif
                        </p>
                    @endforeach
                </td>

        @if(count($sequences) > 1)
            @foreach($sequences as $sequence)
                <!-- Note obtenu par sequence -->
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">

                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                            $idSequence = $sequence['id'];
                            $couleurSequence = getAppreciationGradeAndColor($typeEvaluation0['sequences']["sequence$idSequence"], $typeEvaluation0['noteMaxSeq']["noteMaxSeq$idSequence"]);
                        @endphp

                        @if($typeEvaluation0 !== null && isset($typeEvaluation0['sequences']["sequence$idSequence"]))

                            <p class="s14" style="font-weight:bold;  @if($key != end($cles))border-bottom: 1pt solid #808080;@endif text-align: center; color: #{{ $legend_of_grade[$couleurSequence[1]] }};">
                                {{ number_format_if_float($typeEvaluation0['sequences']["sequence$idSequence"], 1) }}
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
        @endif

                <!-- Sommes des notes sequentilles -->
                <td style="padding-left:0pt!important; width: 10pt;border: 1pt solid #808080">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                            $couleurTrimestre = getAppreciationGradeAndColor($typeEvaluation0["totalNoteObtenu"], $typeEvaluation0['noteMax']);
                        @endphp
                        <p class="s14" style="@if($key != end($cles))border-bottom: 1px solid #808080;@endif text-align: center; color: #{{ $legend_of_grade[$couleurTrimestre[1]] }}; font-weight: bold;">
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
                            @if($typeEvaluation['pourcentageReussite'] !== null)
                                {{ @number_format_if_float($typeEvaluation['pourcentageReussite'], 2) }}%
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
                            @if($typeEvaluation['moyenneGenerale'] !== null)
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
                            <span style="color: #{{ $legend_of_grade[getAppreciationGradeAndColor($matiere0['totalNoteObtenus'], $matiere0['totalNoteMax'])[1]] }}; @if($matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax']/2) color: red @endif">
                                {{ number_format_if_float($matiere0['totalNoteObtenus'], 1) }}
                            </span>/{{ number_format_if_float($matiere0['totalNoteMax']) }}
                            <br> {{ __('bulletin_primaire.rank') }}: {{ (array_search($matiere0['totalNoteObtenus'], $matiere['notesObtenues'])) + 1 }}
                            <br> {{ number_format_if_float($matiere['pourcentageReussite'], 1) }}% S
                        @else
                            -
                        @endif
                    </p>
                </td>

                <!-- Appréciation obtenue sur la matière -->
                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080">
                    @php

                        if($matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax']/2)
                        {
                            $grade = __('bulletin_primaire.appr_nye');
                            $grade_color = "nye_color";
                        }
                        else if($matiere0['totalNoteMax']/2 <= $matiere0['totalNoteObtenus'] && $matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax'] * (3/4)){
                            $grade = __('bulletin_primaire.appr_ae');
                            $grade_color = "ae_color";
                        }
                        else if($matiere0['totalNoteMax'] * (3/4) <= $matiere0['totalNoteObtenus'] && $matiere0['totalNoteObtenus'] < $matiere0['totalNoteMax'] * (9/10)){
                            $grade = __('bulletin_primaire.appr_me');
                            $grade_color = "me_color";
                        }else{
                            $grade = __('bulletin_primaire.appr_abe');
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
            @php $index_tr++; @endphp
        @endforeach
    @endforeach
</table>