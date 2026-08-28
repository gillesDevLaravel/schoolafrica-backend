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

        @if(count($sequences) > 1)
            @foreach($sequences as $sequence)
                <td style="height:10pt;vertical-align: middle;border: 1pt solid #808080;">
                    <p class="s14" style="color:white; font-weight:bold; text-align: center; padding: 2pt;">
                        EVAL{{ strtoupper($sequence['name'])[-1] }}
                    </p>
                </td>
            @endforeach
        @endif
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

            <!-- Nom et description de la matière -->
            @php
                $noteMatiereSur4 = ($eleve['bilan'][$idMatiere]['noteMatiere'] ?? null) !== null
                    ? ($eleve['bilan'][$idMatiere]['noteMatiere'] * 4) / $eleve['bilan'][$idMatiere]['noteMaxMatiere']
                    : null;

                $noteGeneraleMatiereSur4 = ($matiere['average'] * 4) / 20;

                $stickerAppreciationMat = getAppreciationStickerForMaternelle($noteMatiereSur4, true);
                $stickerAppreciationGenMat = getAppreciationStickerForMaternelle($noteGeneraleMatiereSur4, true);
            @endphp
{{--        <!-- Nom et description de la matière -->--}}
{{--            @php--}}
{{--                $matiere0 = $groupeMatiere0['matieres'][$matiere['idMatiere']] ?? null;--}}
{{--                $cles = array_keys($matiere['typeEvaluations'] ?? []);--}}

{{--                $noteMatiereSur4 = ($matiere0['totalNoteObtenus'] !== null && $matiere0['totalNoteMax'] != null)--}}
{{--                ? ($matiere0['totalNoteObtenus'] * 4) / $matiere0['totalNoteMax']--}}
{{--                : null;--}}

{{--                $moyenneGenMatiereSur4 = ($matiere['moyenneGenerale'] !== null)--}}
{{--                ? ($matiere['moyenneGenerale'] * 4) / 20--}}
{{--                : null;--}}

{{--                $stickerAppreciationMat = getAppreciationStickerForMaternelle($noteMatiereSur4, true);--}}
{{--                $stickerAppreciationGenMat = getAppreciationStickerForMaternelle($moyenneGenMatiereSur4, true);--}}
{{--            @endphp--}}

            <tr style="height: 16pt;">
                <!-- Nom matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">{{ $matiere['matter_name'] }}</p>
                </td>

                <!-- Libellé type d'évaluation -->
                <td style="height:10pt;vertical-align: middle;border: 1pt solid #808080; padding: 0pt!important;">
                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif

                        @if($idTypeEvaluation != end($idTypeEvaluations))
                                <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;; padding: 2px 0; height: 20px;">
                                {{ $typeEvaluation['nomTypeEvaluation'] ?? "-" }}
                            </p>
                        @else
                                <p class="s14" style="vertical-align:middle; text-align:center; padding: 2px 0; height: 20px;">
                                {{ $typeEvaluation['nomTypeEvaluation'] ?? "-" }}
                            </p>
                        @endif
                    @endforeach
                </td>

                @if(count($sequences) > 1)
                    @foreach($sequences as $sequence)
                        <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">

                            @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                                @if(!ctype_digit((string) $idTypeEvaluation))
                                    @continue
                                @endif

                                @php
                                    $idSequence = $sequence['id'];
                                    $typeEvaluation = $eleve["sequence$idSequence"][$idMatiere][$idTypeEvaluation] ?? null;
                                    $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation['noteTypeEvaluation'] ?? null, $typeEvaluation['noteMaxTypeEvaluation']);
                                @endphp

                                <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations)) border-bottom: 1px solid black;@endif text-align: center;">
                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                                </p>
                            @endforeach
                        </td>
                    @endforeach
                @endif

{{--                @if(count($sequences) > 1)--}}
{{--                    @foreach($sequences as $sequence)--}}
{{--                        <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">--}}
{{--                            @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)--}}
{{--                                @php--}}
{{--                                    $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;--}}
{{--                                    $idSequence = $sequence['id'];--}}
{{--                                    $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0['sequences']["sequence$idSequence"], $typeEvaluation0['noteMaxSeq']["noteMaxSeq$idSequence"]);--}}
{{--                                @endphp--}}

{{--                                <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations'])) border-bottom: 1px solid black;@endif text-align: center;">--}}
{{--                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">--}}
{{--                                </p>--}}
{{--                            @endforeach--}}
{{--                        </td>--}}
{{--                    @endforeach--}}
{{--                @endif--}}


{{--                <!-- Sommes des notes sequentilles -->--}}
{{--                <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">--}}

{{--                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)--}}
{{--                        @if(!ctype_digit((string) $idTypeEvaluation))--}}
{{--                            @continue--}}
{{--                        @endif--}}

{{--                        @php--}}
{{--                            $idSequence = $sequence['id'];--}}
{{--                            $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation] ?? null;--}}

{{--                            $noteTypeEvaluationSur4 = (($typeEvaluation['noteTypeEvaluation'] ?? null) > 0) ? ($typeEvaluation['noteTypeEvaluation'] * 4) / 20 : null;--}}

{{--                            $stickerAppreciation = getAppreciationStickerForMaternelle($noteTypeEvaluationSur4, true);--}}
{{--                        @endphp--}}

{{--                        <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations)) border-bottom: 1px solid black;@endif text-align: center;">--}}
{{--                            <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">--}}
{{--                        </p>--}}
{{--                    @endforeach--}}
{{--                </td>--}}


                <!-- Sommes des notes sequentilles -->
                <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif

                        @php
                            $typeEvaluation = $eleve['bilan'][$idMatiere][$idTypeEvaluation] ?? null;

                            if ($typeEvaluation['noteTypeEvaluation'] > 0 && $typeEvaluation['noteMaxTypeEvaluation'] > 0){
                                $totalNoteObtenu = ($typeEvaluation['noteTypeEvaluation'] * 4) / $typeEvaluation['noteMaxTypeEvaluation'];
                            }else{
                                $totalNoteObtenu = null;
                            }

                            $stickerAppreciation = getAppreciationStickerForMaternelle($totalNoteObtenu, true);

                            //$stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0["totalNoteObtenu"], $typeEvaluation0['noteMax']);
                        @endphp

                        <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations)) border-bottom: 1px solid black;@endif text-align: center;">
                            <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                        </p>
                    @endforeach
                </td>

                <!-- Sommes des notes sequentilles -->
                <td class="td_border" style="width: 20pt">
                    <p class="s14" style="text-align: center;">
                        <img class="appreciation_img" style="width: 50px; height: 50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciationMat"))) }}">
                    </p>
                </td>

                <!-- Moyenne generale de la classe sur la matiere -->
                <td style="padding-left:0pt!important; width: 5pt;border: 1pt solid #808080;">
                    <p class="s14 he26" style=" font-weight: bold;  text-align: center;">
                        <img class="img_wh" style="width: 30px; height: 30px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciationGenMat"))) }}">
                    </p>
                </td>
            </tr>
        @endforeach
    @endforeach
</table>
