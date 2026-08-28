<div style="overflow-x: auto; max-width: 100%;">
    <table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11px; line-height: 1.4;">
        @php
            // Mode annuel : on affiche les colonnes par TRIMESTRE (et non par séquence)
            $isAnnuel = (($typeBulletin ?? '') === 'annuel') && !empty($trimestres);
            // Écoles fonctionnant par semestre : l'annuel est ventilé par SEMESTRE
            $isAnnuelSemestre = $isAnnuel && !empty($semestres ?? []);
        @endphp

        <thead>
        <tr style="background-color: #{{ $couleurs[0] ?? '1f497d' }}; color: white; font-weight: bold;">
            <th style="border: 1px solid black; padding: 8px; text-align: center;">{{ __('bulletin_secondaire.disciplines') }}</th>

            @if(!$trimestres || count($trimestres) <= 1)
                <th style="border: 1px solid black; padding: 8px; text-align: center;">{{ __('bulletin_secondaire.enseignants') }}</th>
            @endif

            @if($isAnnuelSemestre)
                @foreach($semestres as $semestre)
                    <th style="border: 1px solid black; padding: 8px; text-align: center; white-space: nowrap; font-size: 10px;">
                        {{ strtoupper($semestre['name'] ?? 'SEM') }}
                    </th>
                @endforeach
                <th style="border: 1px solid black; padding: 8px; text-align: center;">
                    {{ __('bulletin_secondaire.annual') }}
                </th>
            @elseif($isAnnuel)
                @foreach($trimestres as $trimestre)
                    <th style="border: 1px solid black; padding: 8px; text-align: center; white-space: nowrap; font-size: 10px;">
                        {{ strtoupper(substr($trimestre['name'] ?? 'TRIM', 0, 6)) }}
                    </th>
                @endforeach
                <th style="border: 1px solid black; padding: 8px; text-align: center;">
                    {{ __('bulletin_secondaire.annual') }}
                </th>
            @else
                @foreach($sequences as $sequence)
                    <th style="border: 1px solid black; padding: 8px; text-align: center; white-space: nowrap; font-size: 10px;">
                        {{ $sequence['name'] }}
                        @if($route === 'cim' && !empty($sequence['pourcentage'])) ({{ $sequence['pourcentage'] }}%) @endif
                    </th>
                @endforeach

                @if(count($sequences) > 1)
                    <th style="border: 1px solid black; padding: 8px; text-align: center;">
                        {{ strtoupper(substr($trimestres[0]['name'] ?? 'TRIM', 0, 4)) }}
                    </th>
                @endif
            @endif

            <th style="border: 1px solid black; padding: 8px;">CF</th>
            <th style="border: 1px solid black; padding: 8px;">TOTAL</th>
            <th style="border: 1px solid black; padding: 8px;">R</th>
            <th style="border: 1px solid black; padding: 8px;">MG</th>
            <th style="border: 1px solid black; padding: 8px;">%S</th>
            <th style="border: 1px solid black; padding: 8px;">APP</th>
            <th style="border: 1px solid black; padding: 8px;">VISA</th>
        </tr>
        </thead>

        <tbody>
        @php
            $ligne = 0;
            $totalCoefForFooter = 0;
            $totalNoteCoef = 0;
        @endphp

        @foreach($groupeMatieres as $groupe)
            @php $idGroupe = $groupe['idGroupMat']; @endphp

            @foreach($matieres as $matiere)
                @if($matiere['idGroupMat'] != $idGroupe) @continue @endif

                @php
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

                    $totalNoteCoefMatiere = $note !== null ? $note * ($info['coef'] ?? 0) : null;
                    $hasSequenceNote = false;
                    foreach($sequences as $s) {
                        if(($info["sequence{$s['id']}"] ?? null) !== null) {
                            $hasSequenceNote = true;
                            break;
                        }
                    }

                    if($note !== null && isset($info['coef'])) {
                        $totalCoefForFooter += $info['coef'];
                        $totalNoteCoef += $totalNoteCoefMatiere;
                    }

                    $hasTrimestreNote = ($info['trimestre'] ?? null) !== null;
                    $moyenneMatiere = $hasTrimestreNote ? floatval($info['trimestre']) : $note;
                @endphp

                <tr style="background-color: {{ $ligne++ % 2 == 0 ? '#f9f9f9' : 'white' }};">
                    <td style="border: 1px solid #999; padding: 5px; text-align: left; font-weight: bold;">
                        {{ $info['nomMatiere'] }}
                        @if($trimestres && count($trimestres) > 1)
                            <br><small style="color:#555;">{{ $info['nomEnseignant'] }}</small>
                        @endif
                    </td>

                    @if(!$trimestres || count($trimestres) <= 1)
                        <td style="border: 1px solid #999; padding: 5px; text-align: center; font-size: 10px;">
                            {{ \Illuminate\Support\Str::limit($info['nomEnseignant'] ?? '', 22) }}
                        </td>
                    @endif

                    @if($isAnnuelSemestre)
                        @foreach($semestres as $semestre)
                            @php
                                // Moyenne de la matière sur le semestre = moyenne des moyennes
                                // trimestrielles du semestre (somme des trimestres / nombre de
                                // trimestres evalues), chaque trimestre etant lui-meme la moyenne
                                // ponderee (par pourcentage) de ses sequences.
                                $trimIdsSem = $semestre['trimestreIds'] ?? [];
                                $totalTrim = 0; $nbTrim = 0;
                                foreach($trimIdsSem as $tid) {
                                    $sommeT = 0; $poidsT = 0; $hasT = false;
                                    foreach($sequences as $s) {
                                        if(($s['idTrimestre'] ?? null) == $tid) {
                                            $vSeq = $info["sequence{$s['id']}"] ?? null;
                                            if($vSeq !== null) {
                                                $w = $s['pourcentage'] ?? 0;
                                                $w = $w > 1 ? $w / 100 : $w;
                                                $sommeT += $vSeq * $w;
                                                $poidsT += $w;
                                                $hasT = true;
                                            }
                                        }
                                    }
                                    if($hasT && $poidsT > 0) { $totalTrim += $sommeT / $poidsT; $nbTrim++; }
                                }
                                $moySem = $nbTrim > 0 ? $totalTrim / $nbTrim : null;
                            @endphp
                            <td style="border: 1px solid #999; text-align: center; font-weight: bold; color: {{ getAppreciation0($moySem, $isSimple)['couleur'] }};">
                                {{ $moySem !== null ? number_format($moySem, 2) : '-' }}
                            </td>
                        @endforeach

                        <td style="border: 1px solid #999; background:#d9e1f2; text-align: center; font-weight: bold; color: {{ getAppreciation0($info['trimestre'] ?? $note, $isSimple)['couleur'] }};">
                            {{ $moyenneMatiere !== null ? number_format($moyenneMatiere, 2) : '-' }}
                        </td>
                    @elseif($isAnnuel)
                        @foreach($trimestres as $trimestre)
                            @php
                                // Moyenne de la matière sur le trimestre = moyenne pondérée
                                // (par pourcentage) de ses séquences appartenant à ce trimestre.
                                $trimId = $trimestre['id'];
                                $sommeTrim = 0; $poidsTrim = 0; $aNoteTrim = false;
                                foreach($sequences as $s) {
                                    if(($s['idTrimestre'] ?? null) == $trimId) {
                                        $vSeq = $info["sequence{$s['id']}"] ?? null;
                                        if($vSeq !== null) {
                                            $w = $s['pourcentage'] ?? 0;
                                            $w = $w > 1 ? $w / 100 : $w;
                                            $sommeTrim += $vSeq * $w;
                                            $poidsTrim += $w;
                                            $aNoteTrim = true;
                                        }
                                    }
                                }
                                $moyTrim = $poidsTrim > 0 ? $sommeTrim / $poidsTrim : null;
                            @endphp
                            <td style="border: 1px solid #999; text-align: center; font-weight: bold; color: {{ getAppreciation0($moyTrim, $isSimple)['couleur'] }};">
                                {{ $moyTrim !== null ? number_format($moyTrim, 2) : '-' }}
                            </td>
                        @endforeach

                        <td style="border: 1px solid #999; background:#d9e1f2; text-align: center; font-weight: bold; color: {{ getAppreciation0($info['trimestre'] ?? $note, $isSimple)['couleur'] }};">
                            {{ $moyenneMatiere !== null ? number_format($moyenneMatiere, 2) : '-' }}
                        </td>
                    @else
                        @foreach($sequences as $seq)
                            @php $val = $info["sequence{$seq['id']}"] ?? null; @endphp
                            <td style="border: 1px solid #999; text-align: center; font-weight: bold; color: {{ getAppreciation0($val, $isSimple)['couleur'] }};">
                                {{ $val !== null ? number_format($val, 2) : '-' }}
                            </td>
                        @endforeach

                        @if(count($sequences) > 1)
                            <td style="border: 1px solid #999; background:#d9e1f2; text-align: center; font-weight: bold; color: {{ getAppreciation0($info['trimestre'] ?? $note, $isSimple)['couleur'] }};">
                                {{ $moyenneMatiere !== null ? number_format($moyenneMatiere, 2) : '-' }}
                            </td>
                        @endif
                    @endif

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">
                        {{ $hasSequenceNote ? ($info['coef'] !== null ? $info['coef'] : '-') : '-' }}
                    </td>

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">
                        {{ $totalNoteCoefMatiere !== null ? number_format($totalNoteCoefMatiere, 2) : '-' }}
                    </td>

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold; font-size: 10px;">
                        {!! $info['rang'] !== null ? getStudentRank($info['rang']) : '-' !!}
                    </td>

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">
                        {{ isset($matiere['moyenneGenerale']) ? number_format($matiere['moyenneGenerale'], 2) : '-' }}
                    </td>

                    <td style="border: 1px solid #999; text-align: center; background:#e6e6e6; font-weight: bold;">
                        {{ isset($matiere['pourcentageReussite']) ? round($matiere['pourcentageReussite']) . '%' : '-' }}
                    </td>

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">
                        {{ $moyenneMatiere !== null ? getAppreciationAbrev($moyenneMatiere, $isSimple) : '-' }}
                    </td>

                    <td style="border: 1px solid #999;"></td>
                </tr>
            @endforeach
        @endforeach
        </tbody>

        <tfoot>
        <tr style="background-color: #{{ $couleurs[0] ?? '1f497d' }}; color: white; font-weight: bold; font-size: 14px;">
            @php
                $colspanGauche = 1 +
                                 (!$trimestres || count($trimestres) <= 1 ? 1 : 0) +
                                 ($isAnnuelSemestre
                                     ? count($semestres) + 1
                                     : ($isAnnuel
                                         ? count($trimestres) + 1
                                         : count($sequences) + (count($sequences) > 1 ? 1 : 0)));

                $moyenneEleve = $eleve['moyenne'] ?? $eleve['trimestre'] ?? null;
            @endphp

            <td colspan="{{ $colspanGauche }}" style="padding:10px; text-align:left; border:1px solid #000;">
                {{ __('bulletin_secondaire.total_matieres') }}
            </td>

            <td style="text-align:center; padding:10px; border:1px solid #000;">
                {{ $totalCoefForFooter !== 0 ? number_format($totalCoefForFooter, 1) : '-' }}
            </td>

            <td style="text-align:center; padding:10px; border:1px solid #000;">
                {{ $totalNoteCoef !== 0 ? number_format($totalNoteCoef, 2) : '-' }}
            </td>

            <td colspan="4" style="text-align:center; padding:10px; border:1px solid #000;">{{ __('bulletin_secondaire.moyenne') }}</td>

            <td style="text-align:center; padding:10px; border:1px solid #000; font-size:18px;">
                {{ $moyenneEleve !== null ? number_format($moyenneEleve, 2) : '-' }}
            </td>
        </tr>
        </tfoot>
    </table>
</div>
