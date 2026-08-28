@php
    $trimestresList = $trimestres ?? [];
    $sequencesList = $sequences ?? [];

    $sequencesByTrimestre = [];
    foreach ($sequencesList as $seq) {
        $tId = $seq['idTrimestre'] ?? null;
        if ($tId === null) continue;
        if (!isset($sequencesByTrimestre[$tId])) $sequencesByTrimestre[$tId] = [];
        $sequencesByTrimestre[$tId][] = $seq;
    }

    $formatNote = function($val) { return $val === null ? '-' : number_format((float)$val, 2); };
    $formatCredits = function($val) { return $val === null ? '-' : number_format((float)$val, 0); };

    $getGrade = function($note) {
        if ($note === null) return '-';
        if ($note >= 16) return 'A';
        if ($note >= 14) return 'B+';
        if ($note >= 12) return 'B';
        if ($note >= 10) return 'C+';
        if ($note >= 8) return 'C';
        if ($note >= 6) return 'D';
        return 'E';
    };

    $getDecision = function($note) { return $note === null ? '-' : ($note >= 10 ? 'Acquis' : 'Non acquis'); };

    $getMention = function($note) {
        if ($note === null) return '-';
        if ($note >= 16) return 'Très bien';
        if ($note >= 14) return 'Bien';
        if ($note >= 12) return 'Assez bien';
        if ($note >= 10) return 'Passable';
        return 'Insuffisant';
    };

    $computeNoteTrimestre = function($info, $trimSeqs) {
        if (!$info || empty($trimSeqs)) return null;
        $notes = collect($trimSeqs)->map(function($seq) use ($info) {
            return [
                'val' => $info["sequence{$seq['id']}"] ?? null,
                'pct' => $seq['pourcentage'] ?? null
            ];
        })->filter(function($x) { return $x['val'] !== null; });
        
        if ($notes->isEmpty()) return null;
        
        $totalPct = $notes->sum(function($x) { return (float)($x['pct'] ?? 0); });
        if ($totalPct > 0) {
            return $notes->sum(function($x) { return $x['val'] * (float)($x['pct'] ?? 0); }) / $totalPct;
        }
        return $notes->avg(function($x) { return $x['val']; });
    };

    $globalTotalCoef = 0;
    $globalTotalNoteCoef = 0;
    $globalCreditsObtained = 0;
@endphp

<table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; line-height: 1.3;">
    <thead>
        <tr style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #fff; font-weight: bold;">
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 12%;">Code<br>Code</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 30%;">Intitulé de l'unité d'enseignement<br>Course Title</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">Notes/20<br>Marks/20</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 10%;">Moyenne<br>Course&nbsp;Average</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 12%;">Notation<br>Notation</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">Crédits<br>Credits</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 8%;">Grade<br>Grade</th>
            <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 12%;">Décision<br>Decision</th>
        </tr>
    </thead>

    <tbody>
    @foreach($trimestresList as $semIndex => $trimestre)
        @php
            $semesterNumber = $semIndex + 1;
            $trimId = $trimestre['id'] ?? null;
            $trimSeqs = $trimId !== null && isset($sequencesByTrimestre[$trimId]) ? $sequencesByTrimestre[$trimId] : [];
            
            $semTotalCoef = 0;
            $semTotalNoteCoef = 0;
            $semCreditsTotal = 0;
            $semCreditsObtained = 0;
        @endphp

        {{-- Ligne d'en-tête SEMESTRE --}}
        <tr style="background-color: #E7E6E6; font-weight: bold;">
            <td colspan="8" style="border: 1px solid #000; padding: 6px; text-align: center; font-size: 12px;">
                SEMESTRE {{ $semesterNumber }}
            </td>
        </tr>

        @foreach($groupeMatieres as $groupe)
            @php
                $idGroupe = $groupe['idGroupMat'] ?? null;
                if ($idGroupe === null) continue;

                $ueCode = $groupe['nomGroupMat'] ?? ($groupe['descGroupMat'] ?? '-');
                $ueMatieres = array_filter($matieres, function($m) use ($idGroupe) { 
                    return ($m['idGroupMat'] ?? null) == $idGroupe; 
                });
                $ueMatieres = array_values($ueMatieres);
                $ueRowspan = count($ueMatieres);
                if ($ueRowspan <= 0) continue;

                $ueCredits = 0;
                $ueNotesSum = 0;
                $ueNotesCount = 0;

                foreach ($ueMatieres as $m) {
                    $coef = $m['coef'] ?? null;
                    if ($coef !== null) $ueCredits += $coef;
                    
                    $info = $eleve[$idGroupe][$m['idMat']] ?? null;
                    $note = $computeNoteTrimestre($info, $trimSeqs);
                    if ($note !== null) {
                        $ueNotesSum += $note;
                        $ueNotesCount++;
                    }
                }

                $ueMoy = $ueNotesCount > 0 ? ($ueNotesSum / $ueNotesCount) : null;
                $ueGrade = $getGrade($ueMoy);
                $ueDecision = $getDecision($ueMoy);
                $ueMention = $getMention($ueMoy);
                $semCreditsTotal += $ueCredits;
                if ($ueMoy !== null && $ueMoy >= 10) $semCreditsObtained += $ueCredits;
            @endphp

            {{-- Lignes des matières --}}
            @foreach($ueMatieres as $idx => $matiere)
                @php
                    $info = $eleve[$idGroupe][$matiere['idMat']] ?? null;
                    $note = $computeNoteTrimestre($info, $trimSeqs);
                @endphp

                <tr>
                    <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">
                        @if($idx === 0)
                            {{ $ueCode }}
                        @else
                            +++++++++
                        @endif
                    </td>
                    
                    <td style="border: 1px solid #000; padding: 4px 6px; text-align: left;">
                        {{ $info['nomMatiere'] ?? ($matiere['nomMat'] ?? '-') }}
                    </td>

                    <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                        {{ $formatNote($note) }}
                    </td>

                    @if($idx === 0)
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
                            {{ $formatNote($ueMoy) }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
                            {{ $ueMention }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
                            {{ $formatCredits($ueCredits) }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
                            {{ $ueGrade }}
                        </td>
                        <td rowspan="{{ $ueRowspan }}" style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
                            {{ $ueDecision }}
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


    @endforeach

    @php
        $globalMoy = $globalTotalCoef > 0 ? ($globalTotalNoteCoef / $globalTotalCoef) : null;
    @endphp

    {{-- Ligne de récapitulatif --}}
    <tr style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #fff; font-weight: bold;">
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Bilan</td>
        <td colspan="2" style="border: 1px solid #000; padding: 4px; text-align: center;">Total général crédits</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Grade</td>
        
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Moyenne générale</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Grade point</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Mention</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Decision du jury</td>
    </tr>
        <tr style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #fff; font-weight: bold;">
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">Bilan</td>
        <td colspan="2" style="border: 1px solid #000; padding: 4px; text-align: center;">MOYENNE GENERALE</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $formatNote($globalMoy) }}</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">-</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $formatCredits($globalCreditsObtained) }}</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $getGrade($globalMoy) }}</td>
        <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $getDecision($globalMoy) }}</td>
    </tr>
    </tbody>
</table>
