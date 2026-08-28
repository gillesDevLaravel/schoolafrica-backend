<div style="overflow-x: auto; max-width: 100%;">
    <table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11px; line-height: 1.4;">
        <thead>
        <tr style="background-color: #{{ $couleurs[0] ?? '1f497d' }}; color: white; font-weight: bold;">
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.disciplines')}}</strong></th>

            @if(!$trimestres || count($trimestres) <= 1)
                <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{ __('bulletin_secondaire.enseignants') }}</strong></th>
            @endif
            @if($trimestres)
                @foreach($trimestres as $trimestre)
                    <th style="border: 1px solid black; text-align: center; padding: 8px;">
                        {{ __('bulletin_secondaire.trim') . $trimestre['numbering'] }}
                    </th>
                @endforeach
                <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.moyenne')}}</strong></th>
            @else
                @foreach($sequences as $sequence)
                    @if($route === "afc")
                        <th style="border: 1px solid black; text-align: center; padding: 8px;">{{$sequence["name"]}}</th>
                    @else
                        <th style="border: 1px solid black; text-align: center; padding: 8px;">EVAL{{$sequence["name"]}}</th>
                    @endif
                @endforeach
                @if(count($sequences) > 1)
                    <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.moyenne')}}</strong></th>
                @endif
            @endif
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.coef')}}</strong></th>
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.note_coef')}}</strong></th>
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{strtoupper(__('bulletin_secondaire.rang'))}}</strong></th>
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.note_min_max')}}</strong></th>
            <th style="border: 1px solid black; text-align: center; padding: 8px;"><strong>{{__('bulletin_secondaire.appreciation')}}</strong></th>
        </tr>
        </thead>

        @php
            $num_periods = $trimestres ? count($trimestres) : count($sequences);
            $has_moyenne_col = $trimestres || count($sequences) > 1;
            $left_colspan = 1 + (!$trimestres || count($trimestres) <= 1 ? 1 : 0) + $num_periods + ($has_moyenne_col ? 1 : 0);
        @endphp

        {{$count = 0}}
        @foreach($groupeMatieres as $groupeMatiere)
            {{ $idGroupeMatiere = $groupeMatiere["idGroupMat"] }}
            <tbody>
            @foreach($matieres as $index => $matiere)
                @if($matiere["idGroupMat"] == $idGroupeMatiere)
                    @php
                        if (!isset($eleve[$idGroupeMatiere][$matiere['idMat']])) {
                            $infosMatiere = [
                                "idMatter" => 106,
                                "nomMatiere" => $matiere["nomMat"],
                                "idEvaluation" => 284,
                                "trimestre" => null,
                                "nbrSeqEval" => null,
                                "rang" => null,
                                "nomEnseignant" => $matiere["nomEnseignant"],
                                "coef" => null
                            ];
                        } else {
                            $infosMatiere = $eleve[$idGroupeMatiere][$matiere["idMat"]];
                            // La valeur 'trimestre' est déjà normalisée côté serveur (pondérée)
                            // Ne pas diviser par nbrSeqEval ici
                        }

                        // Note min-max classe (utilise moyenneMin et moyenneMax de la matière)
                        $moyenneMin = isset($matiere["moyenneMin"]) ? $matiere["moyenneMin"] : null;
                        $moyenneMax = isset($matiere["moyenneMax"]) ? $matiere["moyenneMax"] : null;
                        $noteMinMax = (!is_null($moyenneMin) && !is_null($moyenneMax)) ? $moyenneMin . '-' . $moyenneMax : '-';
                    @endphp

                    @if(($count % 2) == 0)
                        <tr style="background-color: #f9f9f9;">
                    @else
                        <tr style="background-color: white;">
                    @endif
                    {{$count++}}
                    <td style="border: 1px solid #999; padding: 5px; text-align: left; font-weight: bold;">
                        {{ $infosMatiere["nomMatiere"] }}
                    </td>

                    @if(!$trimestres || count($trimestres) <= 1)
                        <td style="border: 1px solid #999; padding: 5px; text-align: center; font-size: 10px;">
                            {{ \Illuminate\Support\Str::limit($infosMatiere['nomEnseignant'] ?? '', 22) }}
                        </td>
                    @endif

                    @if($trimestres)
                        @foreach($trimestres as $trimestre)
                            @php
                                $sequenceIds = \App\Models\AssessmentType::where('idTrimestre', $trimestre['id'])
                                    ->pluck('id')
                                    ->toArray();

                                // Récupérer les pourcentages pour les séquences de ce trimestre
                                $seqPcts = \App\Models\AssessmentType::whereIn('id', $sequenceIds)
                                    ->pluck('pourcentage', 'id')
                                    ->toArray();

                                // Construire la liste des notes présentes avec leur poids
                                $notesWithPcts = collect($sequenceIds)->map(function ($id) use ($infosMatiere, $seqPcts) {
                                    $val = \Illuminate\Support\Arr::get($infosMatiere, "sequence{$id}");
                                    return [
                                        'id' => $id,
                                        'val' => $val,
                                        'pct' => isset($seqPcts[$id]) ? $seqPcts[$id] : null,
                                    ];
                                })->filter(function ($item) {
                                    return !is_null($item['val']);
                                })->values();

                                if ($notesWithPcts->isEmpty()) {
                                    $noteTrimestre = null;
                                } else {
                                    $totalPctPresent = $notesWithPcts->reduce(function ($carry, $item) {
                                        return $carry + (isset($item['pct']) && $item['pct'] !== null ? (float) $item['pct'] : 0);
                                    }, 0);

                                    if ($totalPctPresent > 0) {
                                        $weightedSum = $notesWithPcts->reduce(function ($carry, $item) {
                                            return $carry + ($item['val'] * (isset($item['pct']) && $item['pct'] !== null ? (float) $item['pct'] : 0));
                                        }, 0);
                                        $noteTrimestre = $weightedSum / $totalPctPresent;
                                    } else {
                                        $noteTrimestre = $notesWithPcts->sum(function ($i) { return $i['val']; }) / $notesWithPcts->count();
                                    }
                                }
                            @endphp
                            <td style="border: 1px solid #999; text-align: center; font-weight: bold; color: {{ getAppreciation0($noteTrimestre, $isSimple)['couleur'] }};">
                                <strong>
                                    {{ !is_null($noteTrimestre) ? round($noteTrimestre, 2) : '-' }}
                                </strong>
                            </td>
                        @endforeach
                        <td style="border: 1px solid #999; text-align: center; font-weight: bold; color:{{getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur']}};">
                            <strong>
                                {{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"], 2) : '-' }}
                            </strong>
                        </td>
                    @else
                        @foreach($sequences as $sequence)
                            @if(!isset($infosMatiere["sequence{$sequence['id']}"]))
                                {{ $infosMatiere["sequence{$sequence['id']}"] = null }}
                            @endif
                            <td style="border: 1px solid #999; text-align: center; font-weight: bold; color: {{ getAppreciation0($infosMatiere["sequence{$sequence['id'] }"], $isSimple)['couleur'] }};">
                                <strong>
                                    {{ !is_null($infosMatiere["sequence{$sequence['id']}"]) ? round($infosMatiere["sequence{$sequence['id']}"], 2) : '-' }}
                                </strong>
                            </td>
                        @endforeach
                        @if(count($sequences) > 1)
                            <td style="border: 1px solid #999; background:#d9e1f2; text-align: center; font-weight: bold; color: {{ getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur'] }};">
                                <strong>
                                    {{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"], 2) : '-' }}
                                </strong>
                            </td>
                        @endif
                    @endif

                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">{{ !is_null($infosMatiere["coef"]) ? $infosMatiere["coef"] : '-'}}</td>
                    <td style="border: 1px solid #999; text-align: center; font-weight: bold;">{{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"] * $infosMatiere["coef"], 2) : '-' }}</td>
                    <td style="border: 1px solid #999; text-align: center; font-weight: bold; font-size: 10px;">{!! !is_null($infosMatiere["rang"]) ? getStudentRank($infosMatiere["rang"]) : '-' !!}</td>
                    <td style="border: 1px solid #999; text-align: center; background:#e6e6e6; font-weight: bold;">
                        {{ $noteMinMax }}
                    </td>
                    <td style="border: 1px solid #999; text-align: center; font-weight: bold; color:{{getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur']}};">
                        <strong>
                            {{ !is_null($infosMatiere["trimestre"]) ? getAppreciationAbrev($infosMatiere["trimestre"], $isSimple) : '-' }}
                        </strong>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>

            @if(count($groupeMatieres) > 1)
                <tfoot style="background-color: #{{ $couleurs[0] ?? '1f497d' }}; color: white; font-weight: bold;">
                <tr>
                    <td colspan="{{ $left_colspan }}" style="border: 1px solid black; text-align: left; padding: 10px;"><strong>{{__('bulletin_secondaire.total_matieres')}} {{ strtoupper($groupeMatiere["descGroupMat"]) }}</strong></td>
                    <td style="border: 1px solid black; text-align: center; padding: 10px;"><strong>
                            {{ !is_null($eleve[$idGroupeMatiere]["totalCoef"])? round($eleve[$idGroupeMatiere]["totalCoef"], 2) : '-' }}
                        </strong></td>
                    <td style="border: 1px solid black; text-align: center; padding: 10px;"><strong>
                            {{ !is_null($eleve[$idGroupeMatiere]["totalNoteCoef"])? round($eleve[$idGroupeMatiere]["totalNoteCoef"], 2) : '-' }}
                        </strong></td>
                    <td colspan="3" style="border: 1px solid black; text-align: center; padding: 10px; color: {{ $eleve[$idGroupeMatiere]['moyenne'] < 10 ? 'red' : getAppreciation0($eleve[$idGroupeMatiere]['moyenne'], $isSimple)['couleur'] }};">
                        <strong>
                            {{ !is_null($eleve[$idGroupeMatiere]['moyenne']) ? round($eleve[$idGroupeMatiere]['moyenne'], 2) : '-' }}
                        </strong>
                    </td>
                </tr>
                </tfoot>
            @endif
        @endforeach

        {{--        <tfoot style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }};background-color: #{{ $couleurs[0] ?? 'C8C8C8' }};">--}}
        {{--        <tr>--}}
        {{--            <td colspan="{{ $left_colspan }}" style="border: 1px solid #181A1B; text-align: left; padding: 4px;"><strong>{{__('bulletin_secondaire.total_matieres')}}</strong></td>--}}
        {{--            <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
        {{--                    {{ !is_null($eleve["totalCoef"])? round($eleve["totalCoef"], 2) : '-' }}--}}
        {{--                </strong></td>--}}
        {{--            <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
        {{--                    {{ !is_null($eleve["totalNoteCoef"])? round($eleve["totalNoteCoef"], 2) : '-' }}--}}
        {{--                </strong></td>--}}
        {{--            <td colspan="3" style="border: 1px solid #181A1B; text-align: center; padding: 4px; color: {{ $eleve['moyenne'] < 10 ? 'red' : 'inherit' }};">--}}
        {{--                <strong>--}}
        {{--                    {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'], 2) : '-' }}--}}
        {{--                </strong>--}}
        {{--            </td>--}}
        {{--        </tr>--}}
        {{--        </tfoot>--}}
    </table>
</div>
