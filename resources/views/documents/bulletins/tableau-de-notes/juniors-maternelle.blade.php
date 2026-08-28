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
                $stickerAppreciationMat = getAppreciationStickerWithNull($eleve['bilan'][$idMatiere]['noteMatiere'], $eleve['bilan'][$idMatiere]['noteMaxMatiere']);
            @endphp

            <tr style="height: 16pt;">
                <!-- Nom matière -->
                <td style="width: 100pt; border: 1pt solid #808080; vertical-align: middle;">
                    <p class="s13" style="text-align: center; margin: 0; font-weight: bold">{{ $matiere['matter_name'] }}</p>
                </td>

                <!-- Libellé type d'évaluation -->
                <td style="padding-left:0pt!important; width: 100pt;border: 1pt solid #808080;vertical-align:middle;">
                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif

                        @if($idTypeEvaluation != end($idTypeEvaluations))
                            <p class="s14" style="vertical-align:middle; text-align:center;border-bottom: 1pt solid #808080;; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEvaluation'] ?? "-" }}</p>
                        @else
                            <p class="s14" style="vertical-align:middle; text-align:center; padding: 2px 0; height: 20px;">{{ $typeEvaluation['libelleTypeEvaluation'] ?? "-" }}</p>
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
                                    $key = $type . $sequence['id'];
                                    $typeEvaluation = $eleve[$key][$idMatiere][$idTypeEvaluation] ?? null;
                                    $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation['noteTypeEvaluation'], $typeEvaluation['noteMaxTypeEvaluation']);
                                @endphp

                                <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations)) border-bottom: 1px solid black;@endif text-align: center;">
                                    <img style="text-align: center; width: 20px; height: 20px; padding: 2px" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$stickerAppreciation"))) }}">
                                </p>
                            @endforeach
                        </td>
                    @endforeach
                @endif


                <!-- Sommes des notes sequentilles -->
                <td style="padding-left:0pt!important; width: 10px;border: 1pt solid #808080;vertical-align:middle;">

                    @foreach($matiere as $idTypeEvaluation => $typeEvaluation)
                        @if(!ctype_digit((string) $idTypeEvaluation))
                            @continue
                        @endif

                        @php
                            $typeEvaluation = $eleve["bilan"][$idMatiere][$idTypeEvaluation] ?? null;
                            $stickerAppreciation = getAppreciationStickerWithNull($typeEvaluation['noteTypeEvaluation'], $typeEvaluation['noteMaxTypeEvaluation']);
                        @endphp

                        <p class="s14" style="@if($idTypeEvaluation != end($idTypeEvaluations)) border-bottom: 1px solid black;@endif text-align: center;">
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
