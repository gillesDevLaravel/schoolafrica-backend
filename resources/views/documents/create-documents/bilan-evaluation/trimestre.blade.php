@if(isset($route) && $route == "iai")
{{-- Bilan IAI avec fond couleur BD - identique à l'image --}}
<table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11px; line-height: 1.4;">
    <tbody style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #ffffffff;">
        {{-- Ligne 1: Note de stage | Absences | Retards --}}
        <tr>
            <td style="padding: 4px 8px; width: 2%;"><strong></strong></td>
            <td style="padding: 4px 8px; width: 20%;"><strong>Note de stage:</strong></td>
            <td style="padding: 4px 8px; width: 15%; text-align: right;">{{ $eleve['note_stage'] ?? '17,00' }}</td>
            <td style="padding: 4px 8px; width: 5%;">/20</td>
            <td style="padding: 4px 8px; width: 15%;"><strong>Absences:</strong></td>
            <td style="padding: 4px 8px; width: 10%; text-align: center;">{{ $absences['total'] ?? '58' }}</td>
            <td style="padding: 4px 8px; width: 15%;"><strong>Retards:</strong></td>
            <td style="padding: 4px 8px; width: 10%; text-align: center;">{{ $eleve['retards'] ?? '0' }}</td>
        </tr>

        {{-- Ligne 2: Moyenne finale | Maximum | Minimum --}}
        <tr>
            <td style="padding: 4px 8px;"><strong></strong></td>            
            <td style="padding: 4px 8px;"><strong>Moyenne finale :</strong></td>
            <td style="padding: 4px 8px; text-align: right;">{{ !is_null($eleve['moyenne']) ? number_format($eleve['moyenne'], 2, ',', '') : '14,00' }}</td>
            <td style="padding: 4px 8px;">/20</td>
            <td style="padding: 4px 8px;"><strong>Maximum:</strong></td>
            <td style="padding: 4px 8px; text-align: center;">{{ !is_null(reset($moyennes)) ? number_format(reset($moyennes), 2, ',', '') : '17,32' }}</td>
            <td style="padding: 4px 8px;"><strong>Minimum:</strong></td>
            <td style="padding: 4px 8px; text-align: center;">{{ !is_null(end($moyennes)) ? number_format(end($moyennes), 2, ',', '') : '0,00' }}</td>
        </tr>

        {{-- Ligne 3: Rang annuel | Crédits cycle --}}
        <tr>
            <td style="padding: 4px 8px;"><strong></strong></td>
            <td style="padding: 4px 8px;"><strong>Rang annuel de l'étudiant:</strong></td>
            <td style="padding: 4px 8px; text-align: right;">
                @if($eleve["isEvalue"])
                    {{ array_search($eleve["moyenne"], $moyennes) + 1 }}
                @else
                    63
                @endif
            </td>
            <td style="padding: 4px 8px;">
                @if($eleve["isEvalue"])
                    sur {{ count($moyennes) + (isset($moyNonEval) ? count($moyNonEval) : 0) }}
                @else
                    sur 101
                @endif
            </td>
            <td style="padding: 4px 8px;"><strong>Crédits cycle:</strong></td>
            <td style="padding: 4px 8px; text-align: center;">{{ $eleve['credits_cycle'] ?? '180' }}</td>
            <td style="padding: 4px 8px;"></td>
            <td style="padding: 4px 8px;"></td>
        </tr>

        {{-- Ligne 4: Moyenne générale classe | Discipline --}}
        <tr>
            <td style="padding: 4px 8px;"><strong></strong></td>
            <td style="padding: 4px 8px;"><strong>Moyenne générale de la classe :</strong></td>
            <td style="padding: 4px 8px; text-align: right;">{{ !is_null($moyenneClasse) ? number_format($moyenneClasse, 2, ',', '') : '13,38' }}</td>
            <td style="padding: 4px 8px;">/20</td>
            <td colspan="2" style="padding: 4px 8px;"><strong>Discipline: {{ $eleve['discipline'] ?? '8 jours d\'exclusion' }}</strong></td>
            <td style="padding: 4px 8px;"></td>
            <td style="padding: 4px 8px;"></td>
        </tr>
    </tbody>
</table>
@elseif (isset($route) && $route == "ests")
@elseif(isset($route) && $route == "lamartine")
    <table border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin-top: 20px;">
        <thead style="text-align: center;">
        <tr>
            <th colspan="4">Discipline</th>
            <th colspan="4">Travail de l'élève</th>
            <th colspan="2">Profil de la classe</th>
        </tr>
        </thead>
        <tbody style="text-align: left;">
        <!-- Ligne 3 -->
        <tr>
            <td colspan="2" >abscence non justifiée (heure)</td>
            <td colspan="2" >Avertissement conduite</td>
            <td colspan="2" >Total note</td>
            <td colspan="2" >7-8-17-18</td> <!-- nouvelle fusion -->
            <td colspan="2">Moyenne classe : {{ !is_null($moyenneClasse)? round($moyenneClasse, 2): '-' }}</td>
        </tr>
        <!-- Ligne 5 -->
        <tr>
            <td colspan="2" rowspan="2">abscence justifiée (heure) : {{ $eleve['absences_justifiees'] ?? '/' }}</td>
            <td colspan="2" rowspan="2">Blâme conduite : {{ $eleve['blame_conduite'] ?? '/' }}</td>
            <td colspan="2" rowspan="2">Total coefficient : {{ !is_null($eleve["totalCoef"])? round($eleve["totalCoef"], 2) : '-' }}</td>
            <td colspan="2">Remarques</td>
            <td colspan="2" rowspan="2">Min-Max : {{ !is_null(end($moyennes)) && !is_null(reset($moyennes)) ? round(end($moyennes), 2) . '-' . round(reset($moyennes), 2) : '-' }}</td>
        </tr>
        <!-- Ligne 6 -->
        <tr>
            <!-- cellules fusionnées déjà en place -->
            <td colspan="2" rowspan="3">CTBA <br> CBA : 2 (6.25%)<br>CA : <br>CMA : <br>CNA : </td>
        </tr>
        <!-- Ligne 7 -->
        <tr>
            <td colspan="2">Retard (nombre de fois) : {{ $eleve['retards'] ?? '/' }}</td>
            <td colspan="2">Exclusion temporaire (jour) : {{ $eleve['exclusion_temporaire'] ?? '/' }}</td>
            <td colspan="2">Moyenne obtenue : {{!is_null($eleve["moyenne"])? round($eleve["moyenne"], 2) : '-'}}</td>
            <td colspan="2">Nombre admis : {{ (count($moyennes) > 0)? count(array_filter($moyennes, function ($valeur){ return $valeur >= 10; })) : 0 }} / {{ count($moyennes) }}</td>
        </tr>
        <!-- Ligne 8 -->
        {{--    <tr>--}}
        {{--        <td colspan="2">59</td>--}}
        {{--    </tr>--}}
        <!-- Ligne 9 -->
        <tr>
            <td colspan="2" >Consigne (heure) : {{ $eleve['consigne'] ?? '/' }}</td>
            <td colspan="2" >Exclusion definitive : {{ $eleve['exclusion_definitive'] ?? '/' }}</td>
            <td >{!! $eleve["isEvalue"] ? getStudentRank((array_search($eleve["moyenne"], $moyennes) + 1)) . (count(array_filter($moyennes, function($m) use ($eleve) { return $m === $eleve["moyenne"]; })) > 1 ? ' ex' : '') : '-' !!} / {{ count($moyennes) }}</td>
            <td >{{ !is_null($eleve["moyenne"])? getAppreciation0($eleve["moyenne"], true, $isSimple)["appreciation"] : '-' }}</td>
            <td colspan="2" >taux réussite : {{ (count($moyennes) > 0)? round(100 * count(array_filter($moyennes, function ($valeur){ return $valeur >= 10; })) / count($moyennes)) . '%' : "-" }}</td>
        </tr>
        <!-- Ligne 10 -->
        {{--    <tr>--}}
        {{--        <!-- cellules fusionnées déjà en place -->--}}
        {{--        <td colspan="2">79</td>--}}
        {{--    </tr>--}}
        </tbody>
    </table>
    <table border="1" style="border-collapse: collapse; width: 100%; text-align: left; font-family: Arial, sans-serif; table-layout: fixed; margin-top: 20px;">
        <thead>
        <tr style="height: 40px;">
            <th style="width: 40%; vertical-align: middle; padding: 8px;">Appréciation du travail de l'élève<br>(points forts et points à améliorer)</th>
            <th style="width: 20%; vertical-align: middle; padding: 8px;">Visa du parent / tuteur</th>
            <th style="width: 20%; vertical-align: middle; padding: 8px;">Professeur principal</th>
            <th style="width: 20%; vertical-align: middle; padding: 8px;">Chef d'établissement</th>
        </tr>
        </thead>
        <tbody>
        <tr style="height: 200px;">
            <td style="vertical-align: top; padding: 8px;"><br><br><br><br></td>
            <td style="vertical-align: top; padding: 8px;"></td>
            <td style="vertical-align: top; padding: 8px;"></td>
            <td style="vertical-align: top; padding: 8px;"></td>
        </tr>
        </tbody>
    </table>



@else

    @php
        // Annuel des ecoles par semestre : le bilan se ventile par SEMESTRE (comme la table de notes).
        $bilanUseSemestres = (($typeBulletin ?? '') === 'annuel') && !empty($semestres ?? []);
        // Nombre de colonnes "periode" affichees (semestres ou trimestres selon le cas).
        $nbBilanCols = $bilanUseSemestres ? count($semestres) : count($trimestres);
        // Periodes a afficher en entete (semestres ou trimestres).
        $bilanPeriodes = $bilanUseSemestres ? $semestres : ($trimestres ?? []);
    @endphp

    <table style="width: 100%; margin-top: 2px; border-collapse: collapse; font-family: Arial, sans-serif; table-layout: fixed; font-size: 12px;">

        {{-- --- Absences / Sanctions / Commentaires --- --}}
        <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ !empty($couleurs) ? $couleurs[0] : '181A1B' }};">
        <tr>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.total_abs') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.abs_non_justifiees') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.sanctions') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;"
                @if($nbBilanCols > 0)
                    colspan="{{ $nbBilanCols }}"
                @endif
            >{{ __('bulletin_secondaire.conseil_de_discipline') }}</th>
            <th style="font-size: 12px; border:1px solid #181A1B; text-align:center; padding:4px;">{{ __('bulletin_secondaire.commentaire') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">{{ $absences['total'] ?? 0 }}</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">{{ $absences['unjustified'] ?? 0 }}</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;">/</td>
            <td style="border:1px solid #212628; text-align:center; padding:4px;"
                @if($nbBilanCols > 0) colspan="{{ $nbBilanCols }}" @endif>/</td>
            <td style="border:1px solid #212628;text-align:center; padding:4px;" rowspan="5">
                @if(isset($route) && $route == "afc")
                    @include('documents.create-documents.exceptions.conseil-de-classe')
                @elseif(isset($typeBulletin) && $typeBulletin == 'annuel' && count($trimestres) > 1)
                    <strong style="font-size: 12px;">{{ $decisionAnnuelle ?? '-' }}</strong>
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
@elseif(isset($typeBulletin) && $typeBulletin == 'semestre')
                @foreach($trimestres as $trimestre)
                    <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">
                        {{ $trimestre['name'] }}
                    </th>
                @endforeach
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ $evaluation->name }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ __('bulletin_secondaire.rang') }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">APP.</th>
@elseif($typeBulletin == 'annuel')
                @foreach($bilanPeriodes as $periode)
                    <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">
                        {{ $periode['name'] }}
                    </th>
                @endforeach
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ $evaluation->name }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">{{ __('bulletin_secondaire.rang') }}</th>
                <th style="font-size:11px; border:1px solid #181A1B; text-align:center; padding:2px; white-space:nowrap;">APP.</th>
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
            @elseif(isset($typeBulletin) && $typeBulletin == 'semestre')
                {{-- Semestriel --}}
                @foreach($trimestres as $trimestre)
                        <?php $moyTrim = isset($eleve['moyenne_trimestre_'.$trimestre['id']]) ? $eleve['moyenne_trimestre_'.$trimestre['id']] : null; ?>
                    <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($moyTrim, $isSimple)['couleur'] }};">
                        {{ !is_null($moyTrim) ? round($moyTrim,2) : '-' }}
                    </td>
                @endforeach
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; background-color: {{ $eleve['moyenne'] < 10 ? '#ff0000' : (!empty($couleurs)? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                    {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'],2) : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px;">
                        <?php
                        if ($eleve["isEvalue"]) {

                            $note = $eleve["moyenne"];
                            $rank = array_search($note, $moyennes) + 1;

                            // Vérifie s'il y a des ex-æquo
                            $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                            echo getStudentRank($rank) . $ex . ' / ' . (count($moyennes) + count($moyNonEval));

                        } else {
                            echo '-';
                        }
                        ?>
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($eleve['moyenne'], $isSimple)['couleur'] }};">
                    {{ !is_null($eleve['moyenne']) ? getAppreciation0($eleve['moyenne'], $isSimple)['appreciation'] : '-' }}
                </td>
@elseif(count($trimestres) > 0 && $typeBulletin == 'annuel')
                {{-- Annuel : affichage des moyennes par periode (semestre ou trimestre) --}}
                @if($bilanUseSemestres)
                    @foreach($semestres as $semestre)
                        <?php
                            // Moyenne du semestre = moyenne des moyennes trimestrielles du semestre.
                            $totSem = 0; $nbSem = 0;
                            foreach($semestre['trimestreIds'] ?? [] as $tid) {
                                $mt = $eleve['moyenne_trimestre_'.$tid] ?? null;
                                if(!is_null($mt)) { $totSem += $mt; $nbSem++; }
                            }
                            $moySem = $nbSem > 0 ? $totSem / $nbSem : null;
                        ?>
                        <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($moySem, $isSimple)['couleur'] }};">
                            {{ !is_null($moySem) ? round($moySem,2) : '-' }}
                        </td>
                    @endforeach
                @else
                    @foreach($trimestres as $trimestre)
                        <?php $moyTrim = isset($eleve['moyenne_trimestre_'.$trimestre['id']]) ? $eleve['moyenne_trimestre_'.$trimestre['id']] : null; ?>
                        <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($moyTrim, $isSimple)['couleur'] }};">
                            {{ !is_null($moyTrim) ? round($moyTrim,2) : '-' }}
                        </td>
                    @endforeach
                @endif
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; background-color: {{ $eleve['moyenne'] < 10 ? '#ff0000' : (!empty($couleurs)? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                    {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'],2) : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px;">
                    <?php
                    if ($eleve["isEvalue"]) {

                        $note = $eleve["moyenne"];
                        $rank = array_search($note, $moyennes) + 1;

                        // Vérifie s'il y a des ex-æquo
                        $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                        echo getStudentRank($rank) . $ex . ' / ' . (count($moyennes) + count($moyNonEval));

                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($eleve['moyenne'], $isSimple)['couleur'] }};">
                    {{ !is_null($eleve['moyenne']) ? getAppreciation0($eleve['moyenne'], $isSimple)['appreciation'] : '-' }}
                </td>
@elseif(isset($typeBulletin) && $typeBulletin == 'semestre')
                {{-- Semestriel --}}
                @foreach($trimestres as $trimestre)
                        <?php $moyTrim = isset($eleve['moyenne_trimestre_'.$trimestre['id']]) ? $eleve['moyenne_trimestre_'.$trimestre['id']] : null; ?>
                    <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($moyTrim, $isSimple)['couleur'] }};">
                        {{ !is_null($moyTrim) ? round($moyTrim,2) : '-' }}
                    </td>
                @endforeach
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; background-color: {{ $eleve['moyenne'] < 10 ? '#ff0000' : (!empty($couleurs)? '#'.$couleurs[0] : '#C8C8C8') }}; color:white;">
                    {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'],2) : '-' }}
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px;">
                    <?php
                    if ($eleve["isEvalue"]) {

                        $note = $eleve["moyenne"];
                        $rank = array_search($note, $moyennes) + 1;

                        // Vérifie s'il y a des ex-æquo
                        $ex = count(array_keys($moyennes, $note, true)) > 1 ? ' ex' : '';

                        echo getStudentRank($rank) . $ex . ' / ' . (count($moyennes) + count($moyNonEval));

                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td style="border:1px solid #212628; text-align:center; font-weight:bold; padding:2px; color: {{ getAppreciation0($eleve['moyenne'], $isSimple)['couleur'] }};">
                    {{ !is_null($eleve['moyenne']) ? getAppreciation0($eleve['moyenne'], $isSimple)['appreciation'] : '-' }}
                </td>
@else
                {{-- Séquentiel --}}
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
                @if($nbBilanCols > 0)
                    colspan="{{ $nbBilanCols }}"
                @endif
            >{{ __('bulletin_secondaire.taux_de_reussite') }}</th>
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
                @if($nbBilanCols > 0) colspan="{{ $nbBilanCols }}" @endif>
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
