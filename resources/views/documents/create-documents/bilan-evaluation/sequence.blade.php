@if(isset($route) && $route == "lamartine")
    @php
        $totalCoefForFooter = 0;
        $totalNoteCoef = 0;

        foreach($groupeMatieres as $groupe) {
            $idGroupe = $groupe['idGroupMat'];

            foreach($matieres as $matiere) {
                if($matiere['idGroupMat'] != $idGroupe) continue;

                $info = $eleve[$idGroupe][$matiere['idMat']] ?? null;

                if (!$info) {
                    $info = [
                        'nomMatiere' => $matiere['nomMat'],
                        'nomEnseignant' => $matiere['nomEnseignant'] ?? '',
                        'coef' => $matiere['coef'] ?? 0,
                        'trimestre' => null,
                        'rang' => null,
                    ];
                    foreach($sequences as $s) $info["sequence{$s['id']}"] = null;
                }

                // Calcul de la note à utiliser pour le total (trimestre ou fallback séquence)
                $note = $info['trimestre'] ?? null;
                if($note === null) {
                    foreach($sequences as $s) {
                        if(isset($info["sequence{$s['id']}"])) {
                            $note = $info["sequence{$s['id']}"];
                            break;
                        }
                    }
                }

                if($note !== null && isset($info['coef'])) {
                    $totalCoefForFooter += $info['coef'];
                    $totalNoteCoef += $note * $info['coef'];
                }
            }
        }
    @endphp
    <table style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:12px; table-layout:fixed; margin-top:10px;">
        <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ !empty($couleurs) ? $couleurs[0] : '181A1B' }};">
        <tr>
            <th colspan="4" style="border:1px solid #000; padding:4px; text-align:center;">Discipline</th>
            <th colspan="4" style="border:1px solid #000; padding:4px; text-align:center;">Travail de l'élève</th>
            <th colspan="2" style="border:1px solid #000; padding:4px; text-align:center;">Profil de la classe</th>
        </tr>
        </thead>

        <tbody>
        <!-- Ligne 1 -->
        <tr>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Absence non justifiée (h) : <strong>{{ isset($absences['unjustified']) ? $absences['unjustified'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Avertissement conduite : <strong>{{ isset($eleve['avertissement_conduite']) ? $eleve['avertissement_conduite'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px; text-align:center;">
                Total notes : <strong>{{ $totalNoteCoef !== 0 ? number_format($totalNoteCoef, 2) : '-' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px; text-align:center;">
                Remarque
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Moyenne classe : <strong>{{ !is_null($moyenneClasse) ? round($moyenneClasse,2) : '-' }}</strong>
            </td>
        </tr>

        <!-- Ligne 2 -->
        <tr>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Absence justifiée (h) : <strong>{{ isset($absences['justified']) ? $absences['justified'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Blâme conduite : <strong>{{ isset($eleve['blame_conduite']) ? $eleve['blame_conduite'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px; text-align:center;">
                Total coefficient : <strong>{{ $totalCoefForFooter !== 0 ? number_format($totalCoefForFooter, 1) : '-' }}</strong>
            </td>

            <!-- Colonne Profil de la classe : rowspan 2 -->
            <td colspan="2" rowspan="3" style="border:1px solid #212628; padding:4px; text-align:center;">
                CTBA<br>
                CBA : 2 (6.25%)<br>
                CA :<br>
                CMA :<br>
                CNA :
            </td>

            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Min - Max : <strong>
                    {{ count($moyennes) > 0 ? round(min($moyennes),2).' - '.round(max($moyennes),2) : '-' }}
                </strong>
            </td>
        </tr>

        <!-- Ligne 3 -->
        <tr>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Retard (fois) : <strong>{{ isset($eleve['retards']) ? $eleve['retards'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Exclusion temporaire (j) : <strong>{{ isset($eleve['exclusion_temporaire']) ? $eleve['exclusion_temporaire'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px; text-align:center;">
                Moyenne obtenue : <strong>{{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'],2) : '-' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Nombre admis : <strong>
                    {{ count(array_filter($moyennes, function($v){ return $v >= 10; })) }} / {{ count($moyennes) }}
                </strong>
            </td>
        </tr>

        <!-- Ligne 4 -->
        <tr>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Consigne (h) : <strong>{{ isset($eleve['consigne']) ? $eleve['consigne'] : '/' }}</strong>
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Exclusion définitive : <strong>{{ isset($eleve['exclusion_definitive']) ? $eleve['exclusion_definitive'] : '/' }}</strong>
            </td>
            <td style="border:1px solid #212628; padding:4px; text-align:center;">
                {!! $eleve['isEvalue'] ? getStudentRank(array_search($eleve['moyenne'],$moyennes)+1) : '-' !!} / {{ count($moyennes) }}
            </td>
            <td style="border:1px solid #212628; padding:4px; text-align:center;">
                {{ !is_null($eleve['moyenne']) ? getAppreciation0($eleve['moyenne'], true, $isSimple)['appreciation'] : '-' }}
            </td>
            <td colspan="2" style="border:1px solid #212628; padding:4px;">
                Taux de réussite : <strong>
                    {{ count($moyennes) > 0 ? round(100 * count(array_filter($moyennes, function($v){ return $v >= 10; })) / count($moyennes)) . '%' : '-' }}
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
    <table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-family: Arial, sans-serif; table-layout: fixed; font-size: 12px;">
        <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ !empty($couleurs) ? $couleurs[0] : '181A1B' }};">
        <tr>
            <th style="width: 40%; font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px; vertical-align: middle;">Appréciation du travail de l'élève<br>(points forts et points à améliorer)</th>
            <th style="width: 20%; font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px; vertical-align: middle;">Visa du parent / tuteur</th>
            <th style="width: 20%; font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px; vertical-align: middle;">Professeur principal</th>
            <th style="width: 20%; font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px; vertical-align: middle;">Chef d'établissement</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border:1px solid #212628; text-align:center; padding:4px; vertical-align: top;"><br><br><br><br></td>
            <td style="border:1px solid #212628; text-align:center; padding:4px; vertical-align: top;"></td>
            <td style="border:1px solid #212628; text-align:center; padding:4px; vertical-align: top;"></td>
            <td style="border:1px solid #212628; text-align:center; padding:4px; vertical-align: top;"></td>
        </tr>
        </tbody>
    </table>



@else



    <table style="width: 100%; margin-top: 2px; border-collapse: collapse; font-family: Arial, sans-serif; table-layout: fixed; font-size: 12px;">

        {{-- --- Absences / Sanctions / Commentaires --- --}}
        <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ !empty($couleurs) ? $couleurs[0] : '181A1B' }};">
        <tr>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.total_abs') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.abs_non_justifiees') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.sanctions') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;"
                @if(count($trimestres) == 1)
                    colspan="{{ count($sequences) }}"
                @endif
            >{{ __('bulletin_secondaire.conseil_de_discipline') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;"
            @if(count($trimestres) == 0) @endif>{{ __('bulletin_secondaire.commentaire') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">{{ isset($absences['total']) ? $absences['total'] : 0 }}</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">{{ isset($absences['unjustified']) ? $absences['unjustified'] : 0 }}</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">/</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;"
                @if(count($trimestres) == 1) colspan="{{ count($sequences) }}" @endif>/</td>
            @if(count($trimestres) == 1)
                <td style="border:1px solid #212628; text-align:center; padding:4px;" rowspan="5">
                    @if(isset($route) && $route == "afc")
                        @include('documents.create-documents.exceptions.conseil-de-classe')
                    @else
                        @php
                            $status = $eleve['moyenne'] >= 10 ? __('bulletin_secondaire.passed') : __('bulletin_secondaire.failed');
                            $color = $eleve['moyenne'] >= 10 ? 'blue' : 'red';
                        @endphp
                        <strong style="font-size:12px; color: {{ $color }};">
                            {{ $status }}
                        </strong>
                    @endif
                </td>
            @else
                <td style="border:1px solid #212628;text-align:center; padding:4px;" rowspan="5">
                    @php
                        $status = $eleve['moyenne'] >= 10 ? __('bulletin_secondaire.passed') : __('bulletin_secondaire.failed');
                        $color = $eleve['moyenne'] >= 10 ? 'blue' : 'red';
                    @endphp
                    <strong style="font-size:12px; color: {{ $color }};">
                        {{ $status }}
                    </strong>
                </td>
            @endif
        </tr>
        </tbody>

        {{-- --- Moyennes / Rang / Appréciation --- --}}
        <thead style="background-color: rgba(200,200,200,1);">
        <tr>
            @if(count($trimestres) == 0)
                <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.moy_eleve') }}</th>
                <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.rang') }}</th>
                <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.appreciation') }}</th>
                <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.commentaire') }}</th>
            @else
                @foreach($sequences as $sequence)
                    <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">
                        {{ $sequence['name'] }}
                    </th>
                @endforeach
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ __('bulletin_secondaire.trim') }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ __('bulletin_secondaire.rang') }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">APP.</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            @if(count($trimestres) == 0)
                {{-- Séquentiel --}}
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px; background-color: {{ $eleve['moyenne'] < 10 ? '#ff0000' : (!empty($couleurs) ? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                    {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'],2) : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px;">
                        <?php
                        if ($eleve["isEvalue"]) {

                            $note = $eleve["trimestre"];
                            $rank = array_search($note, $moyennes) + 1;

                            // Vérifie s'il y a des ex-æquo
                            $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                            echo getStudentRank($rank) . $ex . ' / ' . (count($moyennes) + count($moyNonEval));

                        } else {
                            echo '-';
                        }
                        ?>
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px; color: {{ getAppreciation0($eleve['moyenne'], true, $isSimple)['couleur'] }};">
                    {{ !is_null($eleve['moyenne']) ? getAppreciation0($eleve['moyenne'], true, $isSimple)['appreciation'] : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px;">/</td>
            @else
                {{-- Trimestriel --}}
                @foreach($sequences as $sequence)
                        <?php $moySeq = isset($eleve['moyenneSeq'.$sequence['id']]) ? $eleve['moyenneSeq'.$sequence['id']] : null; ?>
                    <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($moySeq, $isSimple)['couleur'] }};">
                        {{ !is_null($moySeq) ? round($moySeq,2) : '-' }}
                    </td>
                @endforeach
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; background-color: {{ $eleve['trimestre'] < 10 ? '#ff0000' : (!empty($couleurs)? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                    {{ !is_null($eleve['trimestre']) ? round($eleve['trimestre'],2) : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px;">
                        <?php
                        if ($eleve["isEvalue"]) {

                            $note = $eleve["trimestre"];
                            $rank = array_search($note, $moyennes) + 1;

                            // Vérifie s'il y a des ex-æquo
                            $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                            echo getStudentRank($rank) . $ex . ' / ' . (count($moyennes) + count($moyNonEval));

                        } else {
                            echo '-';
                        }
                        ?>
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($eleve['trimestre'], $isSimple)['couleur'] }};">
                    {{ !is_null($eleve['trimestre']) ? getAppreciation0($eleve['trimestre'], $isSimple)['appreciation'] : '-' }}
                </td>
            @endif
        </tr>
        </tbody>

        {{-- --- Moyenne classe / premier / dernier / taux de réussite --- --}}
        <thead style="background-color: rgba(200,200,200,1);">
        <tr>
            <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.moy_classe') }}</th>
            <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.moy_premier') }}</th>
            <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.moy_dernier') }}</th>
            <th style="font-size:12px; border:1px solid #181A1B; text-align:center; padding:4px;"
                @if(count($trimestres) == 1) colspan="{{ count($sequences) }}" @endif>{{ __('bulletin_secondaire.taux_de_reussite') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            {{-- Moyenne classe --}}
            <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px;
                   background-color: {{ $moyenneClasse < 10 ? '#ff0000' : (!empty($couleurs)? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                {{ !is_null($moyenneClasse) ? round($moyenneClasse,2) : '-' }}
            </td>

            {{-- Moyenne du premier --}}
            <td style="border:1px solid #212628; text-align:center; font-weight:bold; font-size:14px;
                   color: {{ reset($moyennes) < 10 ? '#ff0000' : '#0000FF' }};">
                {{ reset($moyennes) !== false ? round(reset($moyennes),2) : '-' }}
            </td>

            {{-- Moyenne du dernier --}}
            <td style="border:1px solid #212628; text-align:center; font-weight:bold; font-size:14px;
                   color: {{ end($moyennes) < 10 ? '#ff0000' : '#0000FF' }};">
                {{ end($moyennes) !== false ? round(end($moyennes),2) : '-' }}
            </td>

            {{-- Taux de réussite --}}
            <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:4px;"
                @if(count($trimestres) == 1) colspan="{{ count($sequences) }}" @endif>
                    <?php
                    $total = count($moyennes);
                    $reussite = count(array_filter($moyennes, function($valeur) { return $valeur >= 10; }));
                    $taux = $total > 0 ? round(100*$reussite/$total).'%' : '-';
                    echo $taux;
                    ?>
            </td>
        </tr>
        </tbody>

    </table>
@endif
