
@php
    $trimestresList = $trimestres ?? [];
    $sequencesList = $sequences ?? [];

    $sequencesByTrimestre = [];
    foreach ($sequencesList as $seq) {
        $tId = $seq['idTrimestre'] ?? null;
        if ($tId === null) {
            continue;
        }
        if (!isset($sequencesByTrimestre[$tId])) {
            $sequencesByTrimestre[$tId] = [];
        }
        $sequencesByTrimestre[$tId][] = $seq;
    }

    $formatNote = function ($val) {
        return $val === null ? '-' : number_format((float) $val, 2);
    };

    $formatCoef = function ($val) {
        return $val === null ? '-' : number_format((float) $val, 0);
    };

    $formatCredits = function ($val) {
        return $val === null ? '-' : number_format((float) $val, 0);
    };

    $computeNoteTrimestre = function ($info, $trimSeqs) {
        if (!$info || empty($trimSeqs)) {
            return null;
        }

        $notesWithPct = collect($trimSeqs)->map(function ($seq) use ($info) {
            $id = $seq['id'] ?? null;
            $pct = $seq['pourcentage'] ?? null;
            $val = null;
            if ($id !== null) {
                $key = "sequence{$id}";
                $val = isset($info[$key]) ? $info[$key] : null;
            }
            return [
                'val' => $val,
                'pct' => $pct,
            ];
        })->filter(function ($x) {
            return $x['val'] !== null;
        })->values();

        if ($notesWithPct->isEmpty()) {
            return null;
        }

        $totalPct = $notesWithPct->reduce(function ($carry, $x) {
            $pct = $x['pct'];
            if ($pct === null) {
                return $carry;
            }
            return $carry + (float) $pct;
        }, 0);

        if ($totalPct > 0) {
            $weightedSum = $notesWithPct->reduce(function ($carry, $x) {
                $pct = $x['pct'];
                $w = $pct === null ? 0 : (float) $pct;
                return $carry + ($x['val'] * $w);
            }, 0);

            return $weightedSum / $totalPct;
        }

        return $notesWithPct->sum(function ($x) { return $x['val']; }) / $notesWithPct->count();
    };

    $headerBg = '#2f9ea0';

    $globalTotalCoef = 0;
    $globalTotalNoteCoef = 0;
    $globalCreditsObtained = 0;
@endphp

<table style="width: 100%; margin-top: 10px; table-layout:fixed; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px; line-height: 1.2;">
    <thead>
        <tr style="background-color: #{{ $couleurs[0] ?? '1f497d' }}; color: #ffffff; font-weight: bold; font-size:13px;">
            <th style="border: 1px solid #000; padding: 0px; text-align: center; width: 1%;"></th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 10%;">Code UE</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 28%;">Matières</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 7%;">Notes</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 6%;">Coef</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 8%;">Total</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 7%;">Moy. UE</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 7%;">Rang</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 10%;">Mention</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 10%;">Session</th>
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 6%;">Crédits</th>
        </tr>
    </thead>

    <tbody>
    @foreach($trimestresList as $semIndex => $trimestre)
        @php
            $semesterNumber = $semIndex + 1;
            $trimId = $trimestre['id'] ?? null;

            $trimSeqs = $trimId !== null && isset($sequencesByTrimestre[$trimId]) ? $sequencesByTrimestre[$trimId] : [];
            if (!empty($trimSeqs)) {
                usort($trimSeqs, function ($a, $b) {
                    return ($a['id'] ?? 0) <=> ($b['id'] ?? 0);
                });
            }

            $semTotalCoef = 0;
            $semTotalNoteCoef = 0;
            $semCreditsTotal = 0;
            $semCreditsObtained = 0;

            // Calculer le rowspan du bloc semestre (toutes les lignes UE + 1 ligne résultats)
            $semRows = 0;
            foreach ($groupeMatieres as $g) {
                $gId = $g['idGroupMat'] ?? null;
                if ($gId === null) {
                    continue;
                }
                $cnt = 0;
                foreach ($matieres as $m) {
                    if (($m['idGroupMat'] ?? null) == $gId) {
                        $cnt++;
                    }
                }
                if ($cnt > 0) {
                    $semRows += $cnt;
                }
            }
            $semRows = $semRows + 1;

            $printedSemestreCell = false;
        @endphp

        @foreach($groupeMatieres as $groupe)
            @php
                $idGroupe = $groupe['idGroupMat'] ?? null;
                if ($idGroupe === null) {
                    continue;
                }

                $ueCode = $groupe['nomGroupMat'] ?? ($groupe['descGroupMat'] ?? '-');

                $ueMatieres = [];
                foreach ($matieres as $m) {
                    if (($m['idGroupMat'] ?? null) == $idGroupe) {
                        $ueMatieres[] = $m;
                    }
                }
                $ueRowspan = count($ueMatieres);
                if ($ueRowspan <= 0) {
                    continue;
                }

                $ueTotalCoef = 0;
                $ueTotalNoteCoef = 0;
                $ueCredits = 0;
                $ueHasAnyNote = false;
                $ueNotesSum = 0;
                $ueNotesCount = 0;

                foreach ($ueMatieres as $m) {
                    $coef = isset($m['coef']) ? $m['coef'] : null;
                    if ($coef !== null) {
                        $ueCredits += $coef;
                    }

                    $info = (isset($eleve[$idGroupe]) && isset($eleve[$idGroupe][$m['idMat']])) ? $eleve[$idGroupe][$m['idMat']] : null;
                    $note = $computeNoteTrimestre($info, $trimSeqs);
                    if ($note !== null) {
                        $ueHasAnyNote = true;
                        $ueNotesSum += $note;
                        $ueNotesCount++;
                        if ($coef !== null) {
                            $ueTotalCoef += $coef;
                            $ueTotalNoteCoef += ($note * $coef);
                        }
                    }
                }

                $ueMoy = $ueNotesCount > 0 ? ($ueNotesSum / $ueNotesCount) : null;
                $ueMention = ($ueMoy !== null && $ueMoy >= 10) ? 'VALIDEE' : 'NON VALIDEE';
                $ueSession = ($ueMoy !== null && $ueMoy >= 10) ? 'Normale' : 'Rattrapage';
                $ueCreditsObtained = ($ueMoy !== null && $ueMoy >= 10) ? $ueCredits : 0;
                $ueRang = (isset($eleve[$idGroupe]) && isset($eleve[$idGroupe]['rang'])) ? $eleve[$idGroupe]['rang'] : null;

                $semCreditsTotal += $ueCredits;
                $semCreditsObtained += $ueCreditsObtained;
                if ($ueHasAnyNote) {
                    $semTotalCoef += $ueTotalCoef;
                    $semTotalNoteCoef += $ueTotalNoteCoef;
                }
            @endphp

            @foreach($ueMatieres as $idx => $matiere)
                @php
                    $info = (isset($eleve[$idGroupe]) && isset($eleve[$idGroupe][$matiere['idMat']])) ? $eleve[$idGroupe][$matiere['idMat']] : null;
                    $note = $computeNoteTrimestre($info, $trimSeqs);
                    $coef = isset($matiere['coef']) ? $matiere['coef'] : null;
                    $total = ($note !== null && $coef !== null) ? ($note * $coef) : null;
                    // Récupérer le rang par matière
                    $matiereRang = (isset($info) && isset($info['rang'])) ? $info['rang'] : null;
                @endphp

                <tr>
                    @if(!$printedSemestreCell)
                        @php $printedSemestreCell = true; @endphp
                        <td rowspan="{{ $semRows }}" style="border: 1px solid #000; padding: 0px; text-align: center; vertical-align: middle; font-weight: bold;">
                           <span style="display: inline-block; transform: rotate(-90deg);">SEMESTRE&nbsp;{{ $semesterNumber }}</span>
                        </td>
                    @endif

                    @if($idx === 0)
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">
                            {{ $ueCode }}
                        </td>
                    @endif

                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: left;">
                        {{ $info['nomMatiere'] ?? ($matiere['nomMat'] ?? '-') }}
                    </td>

                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: center;">
                        {{ $formatNote($note) }}
                    </td>

                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: center;">
                        {{ $formatCoef($coef) }}
                    </td>

                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: center;">
                        {{ $total === null ? '-' : number_format((float) $total, 2) }}
                    </td>



                    @if($idx === 0)
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">
                            {{ $formatNote($ueMoy) }}
                        </td>
                    @endif

                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: center;">
                        {!! $matiereRang !== null ? getStudentRank($matiereRang) : '-' !!}
                    </td>

                    @if($idx === 0)
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">
                            {{ $ueMention }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">
                            {{ $ueSession }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">
                            {{ $formatCredits($ueCredits) }}
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach

        @php
            $semMoy = $semTotalCoef > 0 ? ($semTotalNoteCoef / $semTotalCoef) : null;
            $globalTotalCoef += $semTotalCoef;
            $globalTotalNoteCoef += $semTotalNoteCoef;
            $globalCreditsObtained += $semCreditsObtained;
        @endphp

        <tr>
            <td colspan="3" style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold; background: #efefef;">
                RESULTATS SEMESTRE {{ $semesterNumber }}
            </td>

            <td style="font-weight: bold; border: 1px solid #000; padding: 6px; text-align: center;">{{ $semTotalCoef > 0 ? number_format((float) $semTotalCoef, 0) : '-' }}</td>
            <td style="font-weight: bold; border: 1px solid #000; padding: 6px; text-align: center;">{{ $semTotalCoef > 0 ? number_format((float) $semTotalNoteCoef, 2) : '-' }}</td>
            <td style="font-weight: bold; border: 1px solid #000; padding: 6px; text-align: center;">{{ $formatNote($semMoy) }}</td>
            <td style="font-weight: bold; border: 1px solid #000; padding: 6px; text-align: center;">
               <?php
                   if ($eleve["isEvalue"]) {

                         $note = $eleve["trimestre"];
                         $rank = array_search($note, $moyennes) + 1;

                         $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                         echo getStudentRank($rank);

                   } else {
                         echo '-';
                   }
                ?>
    </td>
            <td colspan="2" style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">Total Crédits Semestre {{ $semesterNumber }}</td>
            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $formatCredits($semCreditsTotal) }}</td>
        </tr>
    @endforeach

    @php
        $globalMoy = $globalTotalCoef > 0 ? ($globalTotalNoteCoef / $globalTotalCoef) : null;
    @endphp

        <tr style="font-size: 13px;">
            <th style="border: 1px solid #000; padding: 6px; text-align: center; width: 3%;"></th>
            <td colspan="3" style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold; background: #efefef;">RECAPITULATIF (S1&S2)</td>
            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $globalTotalCoef > 0 ? number_format((float) $globalTotalCoef, 0) : '-' }}</td>
            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $globalTotalCoef > 0 ? number_format((float) $globalTotalNoteCoef, 2) : '-' }}</td>
            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $formatNote($globalMoy) }}</td>
            <td colspan="3" style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;"><strong>Crédits annuels obtenus</strong></td>
            <td style="border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold;">{{ $formatCredits($globalCreditsObtained) }}</td>
        </tr>
    </tbody>
</table>
