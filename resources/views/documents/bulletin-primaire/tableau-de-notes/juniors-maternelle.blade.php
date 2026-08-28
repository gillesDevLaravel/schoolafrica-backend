<!-- Notes et statistiques d'évaluation -->
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr style="background-color: #{{couleurEnteteTableauBulletinJunior()['bg']}};">
        <td class="td_border"  style="width: 35%">
            <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; ">
                {{ __('bul_mat.dom') }}
            </p>
        </td>
        <td class="td_border" style="width: 35%">
            <p class="s10" style="font-weight: bold; padding: 2pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}; ">
                {{ __('bul_mat.acti') }}
            </p>
        </td>
        @if(count($sequences) > 1)
            @foreach($sequences as $sequence)
                <td class="td_border" style="width: 6%;" >
                    <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
                {{ strtoupper($sequence['name']) }}
                    </p>
                </td>
            @endforeach
        @endif
        <td class="td_border" style="width: 6%;" >
            <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">SCORE</p>
        </td>
        <td class="td_border" style="width: 12%;" >
            <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
                {{ __('bul_mat.appr') }}
            </p>
        </td>
        <td class="td_border" style="width: 13%;" >
            <p class="s10" style="font-weight: bold; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{couleurEnteteTableauBulletinJunior()['txt']}}">
                {{ __('bul_mat.remq') }}
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

                $stickerAppreciationMat = getAppreciationStickerWithNull($matiere0['totalNoteObtenus'], $matiere0['totalNoteMax']);
            @endphp

            <tr style="height: 16pt;">
                <!-- Nom matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">{{ $matiere['nomMatiere'] }}</p>
                </td>

                <!-- Libellé type d'évaluation -->
                <td style="padding-left:0pt!important; width: 100pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @if($key != array_key_last($matiere['typeEvaluations']))
                            <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEval'] ?? "-" }}</p>
                        @else
                            <p class="s14" style="vertical-align:middle; text-align:center; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEval'] ?? "-" }}</p>
                        @endif
                    @endforeach
                </td>

                @if(count($sequences) > 1)
                    @foreach($sequences as $sequence)
                        <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">
                            @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                                @php
                                    $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                                    $idSequence = $sequence['id'];
                                    $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0['sequences']["sequence$idSequence"], $typeEvaluation0['noteMaxSeq']["noteMaxSeq$idSequence"]);
                                @endphp

                                <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations'])) border-bottom: 1px solid black;@endif text-align: center;">
                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                                </p>
                            @endforeach
                        </td>                  
                    @endforeach
                @endif


                <!-- Sommes des notes sequentilles -->
                <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere['typeEvaluations'] ?? [] as $key => $typeEvaluation)
                        @php
                            $typeEvaluation0 = $matiere0['typesEvaluation'][$typeEvaluation['idTypeEval']] ?? null;
                            $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation0["totalNoteObtenu"], $typeEvaluation0['noteMax']);
                        @endphp

                        <p class="s14" style="@if($key != array_key_last($matiere['typeEvaluations'])) border-bottom: 1px solid black;@endif text-align: center;">
                            <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                        </p>
                    @endforeach
                </td>  
                
                <!-- Sommes des notes sequentilles -->
                <td class="td_border" style="width: 100px">
                    <p class="s14" style="text-align: center;">
                        <img class="appreciation_img" style="width: 50px; height: 50px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciationMat"))) }}">
                    </p>
                </td>

                <td style="padding-left:0pt!important; text-align:center; width: 10pt;border: 1pt solid #808080"></td> -->
            </tr>
        @endforeach
    @endforeach
</table>