<!-- Notes et statistiques d'évaluation -->
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr style="height: 16pt; background-color: #{{$codeCouleur[0]}};">
        <td style="height: 16pt; width: 50pt;border: 1pt solid #808080;" >
            <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                {{ __('bulletin_primaire.domain_subject') }}
            </p>
        </td>
        <td style="width: 5pt;border: 1pt solid #808080;" >
            <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                {{ __('bulletin_primaire.evaluations') }}
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
        <td style="width: 5pt;border: 1pt solid #808080;" >
            <p class="s10" style="font-weight:bold;padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                SCORE
            </p>
        </td>
        <td style="border: 1pt solid #808080" >
            <p class="s10" style="font-weight:bold;padding: 1pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                APP.
            </p>
        </td>
        <td style="width: 5pt;border: 1pt solid #808080;" >
            <p class="s10" style="font-weight:bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: white">
                {{ __('bulletin_primaire.gen_avg') }}
            </p>
        </td>
    </tr>

    @php $index_tr = 0; //index des balises tr du tableau @endphp
    @foreach($donneesMatieres as $groupeMatiere)
        <!-- Nom et description du groupe de matière -->
        @php
            $groupeMatiere0 = $evaluation['groupesMatieres'][$groupeMatiere['idGroupeMat']] ?? null;
            $colonnesAdditionnelles = count($trimestres) > 1 ? 9 + count($trimestres) : 9;
        @endphp

        @foreach($groupeMatiere['matieres'] as $matiere)
        <!-- Nom et description de la matière -->
            @php
                $matiere0 = $groupeMatiere0['matieres'][$matiere['idMatiere']] ?? null;
                $cles = array_keys($matiere['typeEvaluations'] ?? []);

                $noteMatiereSur4 = ($matiere0['totalNoteObtenus'] !== null && $matiere0['totalNoteMax'] != null)
                ? ($matiere0['totalNoteObtenus'] * 4) / $matiere0['totalNoteMax']
                : null;

                $moyenneGenMatiereSur4 = ($matiere['moyenneGenerale'] !== null)
                ? ($matiere['moyenneGenerale'] * 4) / 20
                : null;

                $stickerAppreciationMat = getAppreciationStickerForMaternelle($noteMatiereSur4, true);
                $stickerAppreciationGenMat = getAppreciationStickerForMaternelle($moyenneGenMatiereSur4, true);
            @endphp

            <tr style="height: 16pt;">
                <!-- Nom matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">{{ $matiere['nomMatiere'] }}</p>
                </td>

                <!-- Libellé type d'évaluation -->
                <td style="height:10pt;vertical-align: middle;border: 1pt solid #808080; padding: 0pt!important;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @if($key != array_key_last($matiere['typeEvaluations']))
                            <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEval'] ?? "-" }}</p>
                        @else
                            <p class="s14" style="vertical-align:middle; text-align:center; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEval'] ?? "-" }}</p>
                        @endif
                    @endforeach
                </td>

                    @foreach($trimestres as $trimestre)
                        <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">
                            @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                                @php
                                    $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                                    $idTrimestre = $trimestre['id'];
                                    $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0['trimestres']["trimestre$idTrimestre"], $typeEvaluation0['noteMaxTrim']["noteMaxTrim$idTrimestre"]);
                                @endphp

                                <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations'])) border-bottom: 1px solid black;@endif text-align: center;">
                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                                </p>
                            @endforeach
                        </td>
                    @endforeach


                <!-- Sommes des notes Trimestrielle -->
                <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;

                            if ($typeEvaluation0["totalNoteObtenu"] > 0 && $typeEvaluation0['noteMax'] > 0){
                                $totalNoteObtenu = ($typeEvaluation0["totalNoteObtenu"] * 4) / $typeEvaluation0['noteMax'];
                            }else{
                                $totalNoteObtenu = null;
                            }

                            $stickerAppreciation = getAppreciationStickerForMaternelle($totalNoteObtenu, true);

                            //$stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0["totalNoteObtenu"], $typeEvaluation0['noteMax']);
                        @endphp

                        <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations'])) border-bottom: 1px solid black;@endif text-align: center;">
                            <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                        </p>
                    @endforeach
                </td>

                <!-- Sommes des notes trimestrielle -->
                <td class="td_border" style="width: 20pt">
                    <p class="s14" style="text-align: center;">
                        <img class="appreciation_img" style="width: 50px; height: 50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciationMat"))) }}">
                    </p>
                </td>

                <!-- Moyenne generale de la classe sur la matiere -->
                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                    <p class="s14 he26" style=" font-weight: bold; @if($key != array_key_last($matiere['typeEvaluations']))border-bottom: 1pt solid #808080;@endif text-align: center;">
                        <img class="img_wh" style="width: 30px; height: 30px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciationGenMat"))) }}">
                    </p>
                </td>
            </tr>
        @endforeach
    @endforeach
</table>
