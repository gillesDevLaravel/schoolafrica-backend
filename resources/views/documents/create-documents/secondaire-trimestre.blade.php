<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin Secondaire trimestre</title>
    <style type="text/css">
        body {
            padding: 15px 15px;
            /* La police est commentée, mais vous pouvez l'activer si nécessaire */
            /* font-family: Arial, sans-serif; */
        }

        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            font-size: 11px;
        }

    </style>
</head>
<body>


<!-- Filifranne -->
<div
    @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
        style="background-image: url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}');
               background-repeat: no-repeat;
               background-position: center;
               background-size: 80%;
               opacity: 0.1;
               position: absolute;
               top: 0;
               left: 0;
               width: 100%;
               height: 100%;
               z-index: -1;"
    @endif
>
    <!-- Contenu de la page -->
</div>

 <!-- Inlcusion des entetes de bulletin en fonction de l'établissement -->
     @if(isset($route) && $route == "abiscoms")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-abiscom')
     @elseif(isset($route) && $route == "afc")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-afc')
     @elseif(isset($route) && $route == "lamartine")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-lamartine')
     @elseif(isset($route) && $route == "cim")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-montreal')
     @elseif(isset($route) && $route == "iai")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-iai')
     @elseif(isset($route) && $route == "ests")
         @include('documents.create-documents.entetes.entete-bulletin-secondaire-ests')
     @else
         @include('documents.create-documents.entetes.entete-bulletin-secondaire')
     @endif
    
    @if(isset($route) && $route == "iai")
        <table style="width: 100%; margin: 10px 10px; border-collapse: collapse; font-family: Arial, sans-serif;">
            <tr>
                <td style="text-align: left; font-size: 10pt;">
                    BN_____/IAI/RRC/DAF/DAA/SDSR/{{ $academic_year }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 16pt; font-weight: bold;">
                    BULLETIN DE NOTES DE FIN D'ANNEE
                </td>
            </tr>
        </table>
    @elseif(isset($route) && $route == "ests")

    @else
    <table style="text-align: center; width: 100%; margin: 10px 10px;">
        <tr>
            <td><strong style="text-align: center; font-size: 16pt;">
                {{__('bulletin_secondaire.bulletin_de_note')}} / {{ strtoupper($evaluation->name) }}
             </strong></td>
        </tr>
    </table>
    @endif
    <!-- Informations sur l'élève et la classe -->
    @if(isset($route) && $route == "abiscoms")
        @include('documents.create-documents.informations.default')
{{--<<<<<<< HEAD--}}
{{--    @elseif(isset($route) && $route == "afc")--}}
{{--        @include('documents.create-documents.informations.default')--}}
{{--    @elseif(isset($route) && $route == "lamartine")--}}
{{--        @include('documents.create-documents.informations.lamartine')--}}
{{--    @else--}}
{{--        @include('documents.create-documents.informations.default')--}}
{{--    @endif--}}

{{--    <div style="overflow-x: auto; max-width: 100%;">--}}
{{--        <table style="width: 100%; margin-top: 5px; border-collapse: collapse; font-family: Arial, sans-serif; line-height: 20px;">--}}
{{--            <thead style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }}; background-color: #{{ $couleurs[0] ?? 'C8C8C8' }};">--}}
{{--                        <th style="width: 20%; border: 1px solid #181A1B; text-align: center; padding: 4px;">{{__('bulletin_secondaire.disciplines')}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{__('bulletin_secondaire.enseignants')}}</th>--}}
{{--                    @if($trimestres)--}}
{{--                        @foreach($trimestres as $trimestre)--}}
{{--                            <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">--}}
{{--                                {{ __('bulletin_secondaire.trim') . $trimestre['numbering'] }}--}}
{{--                            </th>--}}
{{--                        @endforeach--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px; ">{{__('bulletin_secondaire.annual')}}</th>--}}
{{--                    @else--}}
{{--                        @foreach($sequences as $sequence)--}}
{{--                            @if($route === "afc")--}}
{{--                                <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{$sequence["name"]}}</th>--}}
{{--                            @else--}}
{{--                                <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">EVAL{{$sequence["name"]}}</th>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                        @if(count($sequences) > 1)--}}
{{--                            <th style="border: 1px solid #181A1B; text-align: center; padding: 4px; ">{{__('bulletin_secondaire.trim')}}</th>--}}
{{--                        @endif--}}
{{--                    @endif--}}

{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{__('bulletin_secondaire.coef')}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 2px;">{{__('bulletin_secondaire.total')}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 2px;">{{__('bulletin_secondaire.moyenne_generale')}}</th>--}}
{{--                        <th style="width:25px; border: 1px solid #181A1B; text-align: center; padding: 4px;">{{strtoupper(__('bulletin_secondaire.rang'))}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{strtoupper(__('bulletin_secondaire.pourcentage_de_reussite'))}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{__('bulletin_secondaire.mentions')}}</th>--}}
{{--                        <th style="border: 1px solid #181A1B; text-align: center; padding: 4px;">{{__('bulletin_secondaire.visa')}}</th>--}}
{{--                    </tr>--}}
{{--                </thead>--}}

{{--                {{$count = 0}}--}}
{{--            @foreach($groupeMatieres as $groupeMatiere)--}}
{{--                {{ $idGroupeMatiere = $groupeMatiere["idGroupMat"] }}--}}
{{--                <tbody>--}}

{{--                @foreach($matieres as $index => $matiere)--}}

{{--                    @if($matiere["idGroupMat"] == $idGroupeMatiere)--}}

{{--                        @php--}}
{{--                            if (!isset($eleve[$idGroupeMatiere][$matiere['idMat']])) {--}}
{{--                                $infosMatiere = [--}}
{{--                                    "idMatter" => 106,--}}
{{--                                    "nomMatiere" => $matiere["nomMat"],--}}
{{--                                    "idEvaluation" => 284,--}}
{{--                                    "trimestre" => null,--}}
{{--                                    "nbrSeqEval" => null,--}}
{{--                                    "rang" => null,--}}
{{--                                    "nomEnseignant" => $matiere["nomEnseignant"],--}}
{{--                                    "coef" => null--}}
{{--                                ];--}}
{{--                            } else {--}}
{{--                                $infosMatiere = $eleve[$idGroupeMatiere][$matiere["idMat"]];--}}
{{--                                $infosMatiere["trimestre"] = $infosMatiere["trimestre"] / $infosMatiere["nbrSeqEval"];--}}
{{--                            }--}}
{{--                        @endphp--}}

{{--                        @if($count % 2) == 1)--}}
{{--                            <tr style="background-color: rgba(200, 200, 200, 0.5)">--}}
{{--                        @else--}}
{{--                            <tr style="background-color: rgba(200, 200, 200, 0.1)">--}}
{{--                        @endif--}}
{{--                        {{$count++}}--}}

{{--                        <td style="border: 1px solid #212628; text-align: left; padding: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">--}}
{{--                            <strong>--}}
{{--                                {{ strlen($infosMatiere["nomMatiere"]) > 15 ? substr($infosMatiere["nomMatiere"], 0, 15) . '...' : $infosMatiere["nomMatiere"] }}--}}
{{--                            </strong>--}}
{{--                        </td>--}}
{{--                            <td style="border: 1px solid #212628; text-align: center;--}}
{{--                                    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;--}}
{{--                                    max-width: 150px;">--}}
{{--                                {{ strlen($infosMatiere["nomEnseignant"]) > 17 ? substr($infosMatiere["nomEnseignant"], 0, 17) . '...' : $infosMatiere["nomEnseignant"] }}--}}
{{--                            </td>--}}

{{--                                @if($trimestres)--}}
{{--                                    @foreach(array_column($trimestres, 'id') as $trimestreId)--}}
{{--                                        @php--}}
{{--                                            $sequenceIds = \App\Models\AssessmentType::where('idTrimestre', $trimestreId)--}}
{{--                                                ->pluck('id')--}}
{{--                                                ->toArray();--}}

{{--                                            $noteMatiereTrimestre = collect($sequenceIds)->map(function ($id) use ($infosMatiere){--}}
{{--                                                return \Illuminate\Support\Arr::get($infosMatiere, "sequence{$id}");--}}
{{--                                            })->filter(function ($value){--}}
{{--                                                return !is_null($value);--}}
{{--                                            });--}}

{{--                                            $noteTrimestre = $noteMatiereTrimestre->isEmpty() ? null : $noteMatiereTrimestre->sum() / $noteMatiereTrimestre->count();--}}
{{--                                        @endphp--}}

{{--                                        <td style="border: 1px solid #212628; text-align: center; font-weight: bold; padding: 4px; color: {{ getAppreciation0($noteTrimestre, $isSimple)['couleur'] }};">--}}
{{--                                            <strong>--}}
{{--                                                {{ !is_null($noteTrimestre) ? round($noteTrimestre, 2) : '-' }}--}}
{{--                                            </strong>--}}
{{--                                        </td>--}}
{{--                                    @endforeach--}}

{{--                                        @php--}}
{{--                                            $noteMatiereAnnuelle= collect(array_column($sequences, "id"))->map(function ($id) use ($infosMatiere){--}}
{{--                                                return \Illuminate\Support\Arr::get($infosMatiere, "sequence{$id}");--}}
{{--                                            })->filter(function ($value){--}}
{{--                                                return !is_null($value);--}}
{{--                                            });--}}

{{--                                            $noteAnnuelle = $noteMatiereAnnuelle->isEmpty() ? null : $noteMatiereAnnuelle->sum() / $noteMatiereAnnuelle->count();--}}
{{--                                        @endphp--}}
{{--                                        <td style="background-color: rgba(200, 200, 200, 1); border: 1px solid #212628; text-align: center; padding: 4px; color:{{getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur']}};">--}}
{{--                                            <strong>--}}
{{--                                                {{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"], 2) : '-' }}--}}
{{--                                            </strong>--}}
{{--                                        </td>--}}
{{--                                @else--}}
{{--                                    @foreach(array_column($sequences, "id") as $sequence)--}}
{{--                                        @if(!isset($infosMatiere["sequence$sequence"]))--}}
{{--                                            {{ $infosMatiere["sequence$sequence"] = null }}--}}
{{--                                        @endif--}}

{{--                                        <td style="border: 1px solid #212628; text-align: center; font-weight: bold; padding: 4px; color: {{ getAppreciation0($infosMatiere["sequence$sequence"], $isSimple)['couleur'] }};">--}}
{{--                                            <strong>--}}
{{--                                                {{ !is_null($infosMatiere["sequence$sequence"]) ? round($infosMatiere["sequence$sequence"], 2) : '-' }}--}}
{{--                                            </strong>--}}
{{--                                        </td>--}}
{{--                                    @endforeach--}}

{{--                                    @if(count($sequences) > 1)--}}
{{--                                        <td style="background-color: rgba(200, 200, 200, 1); border: 1px solid #212628; text-align: center; padding: 4px; color:{{getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur']}};">--}}
{{--                                            <strong>--}}
{{--                                                {{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"], 2) : '-' }}--}}
{{--                                            </strong>--}}
{{--                                        </td>--}}
{{--                                    @endif--}}
{{--                                @endif--}}


{{--                            <td style="border: 1px solid #212628; text-align: center; padding: 4px; font-weight: bold;">{{ !is_null($infosMatiere["coef"]) ? $infosMatiere["coef"] : '-'}}</td>--}}
{{--                            <td style="border: 1px solid #212628; text-align: center; padding: 4px; font-weight: bold;">{{ !is_null($infosMatiere["trimestre"]) ? round($infosMatiere["trimestre"] * $infosMatiere["coef"], 2) : '-' }}</td>--}}
{{--                            <td style="border: 1px solid #212628; text-align: center; padding: 4px; font-weight: bold;">{{ !is_null($matiere["moyenneGenerale"]) ? round($matiere["moyenneGenerale"], 1) : '-' }}</td>--}}
{{--                            <td style="font-size: 9px; border: 1px solid #212628; text-align: center; padding: 4px; font-weight: bold;">{!! !is_null($infosMatiere["rang"]) ? getStudentRank($infosMatiere["rang"]) : '-' !!}</td>--}}
{{--                            <td style="border: 1px solid #212628; text-align: center; padding: 4px; color:{{getAppreciationBareme($matiere['pourcentageReussite'], 100)}}; background-color: rgba(200, 200, 200, 1); font-weight: bold;">--}}
{{--                                {{ !is_null($matiere["pourcentageReussite"]) ? round($matiere["pourcentageReussite"]).'%' : '-' }}--}}
{{--                            </td>--}}

{{--                            <td style="border: 1px solid #212628; text-align: center; font-weight: bold; padding: 4px; color:{{getAppreciation0($infosMatiere['trimestre'], $isSimple)['couleur']}};">--}}
{{--                                <strong>--}}
{{--                                    {{ !is_null($infosMatiere["trimestre"]) ? getAppreciationAbrev($infosMatiere["trimestre"], $isSimple) : '-' }}--}}
{{--                                </strong>--}}
{{--                            </td>--}}
{{--                            <td style="border: 1px solid #212628; text-align: center; padding: 4px;"></td>--}}
{{--                        </tr>--}}
{{--                    @endif--}}

{{--                @endforeach--}}

{{--                </tbody>--}}


{{--<!-- Block de remplissage pour les groupes de matiere -->--}}
{{--            @if(count($groupeMatieres) > 1)--}}
{{--                <tfoot style="background-color: #C8C8C8;">--}}
{{--                    <tr>--}}
{{--                        <td colspan="{{ 2 + count($trimestres ?? $sequences) }}" style="border: 1px solid #181A1B; text-align: left; padding: 4px;"><strong>{{__('bulletin_secondaire.total_matieres')}} {{ strtoupper($groupeMatiere["descGroupMat"]) }}</strong></td>--}}
{{--<!-- Afficher le total par sequence -->--}}
{{--                        <!-- <td colspan="2" style="border: 1px solid #181A1B; text-align: left; padding: 4px;"><strong>{{__('bulletin_secondaire.total_matieres')}} {{ strtoupper($groupeMatiere["descGroupMat"]) }}</strong></td>--}}

{{--                    @foreach(array_column($sequences, "id") as $sequence)--}}
{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve[$idGroupeMatiere]["sequence$sequence"])? $eleve[$idGroupeMatiere]["sequence$sequence"] : '-' }}--}}
{{--                        </strong></td>--}}
{{--                    @endforeach -->--}}

{{--                    @if(count($sequences) > 1)--}}
{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px; background-color: rgba(200, 200, 200, 1)"><strong>--}}
{{--                            {{ !is_null($eleve[$idGroupeMatiere]["trimestre"])? round($eleve[$idGroupeMatiere]["trimestre"], 2) : '-' }}--}}
{{--                        </strong></td>--}}
{{--                    @endif--}}

{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve[$idGroupeMatiere]["totalCoef"])? round($eleve[$idGroupeMatiere]["totalCoef"], 2) : '-' }}--}}
{{--                        </strong></td>--}}

{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve[$idGroupeMatiere]["totalNoteCoef"])? round($eleve[$idGroupeMatiere]["totalNoteCoef"], 2) : '-' }}--}}
{{--                        </strong></td>--}}

{{--                        <td colspan="3" style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>{{__('bulletin_secondaire.moyenne')}}</strong></td>--}}

{{--                        <td colspan="2" style="border: 1px solid #181A1B; text-align: center; padding: 4px; color: {{ $eleve[$idGroupeMatiere]['moyenne'] < 10 ? 'red' : getAppreciation0($eleve[$idGroupeMatiere]['moyenne'], $isSimple)['couleur'] }};">--}}
{{--                            <strong>--}}
{{--                                {{ !is_null($eleve[$idGroupeMatiere]['moyenne']) ? round($eleve[$idGroupeMatiere]['moyenne'], 2) : '-' }}--}}
{{--                            </strong>--}}
{{--                        </td>--}}

{{--                    </tr>--}}
{{--                </tfoot>--}}
{{--            @endif--}}

{{--<!-- Block de remplissage pour le total des matieres -->--}}
{{--            @endforeach--}}

{{--                <tfoot style="color: {{ count($couleurs) > 0 ? 'white' : 'inherit' }};background-color: #{{ $couleurs[0] ?? 'C8C8C8' }};">--}}
{{--                    <tr>--}}
{{--                        <td colspan="{{ 2 + count($trimestres ?? $sequences)}}" style="border: 1px solid #181A1B; text-align: left; padding: 4px;"><strong>{{__('bulletin_secondaire.total_matieres')}}</strong></td>--}}

{{--<!-- Afficher le total par sequence -->--}}
{{--                        <!-- <td colspan="2" style="border: 1px solid #181A1B; text-align: left; padding: 4px;"><strong>{{__('bulletin_secondaire.total_matieres')}}</strong></td>--}}

{{--                    @foreach(array_column($sequences, "id") as $sequence)--}}
{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve["sequence$sequence"])? round($eleve["sequence$sequence"], 2) : '-' }}--}}
{{--                        </strong></td>--}}
{{--                    @endforeach -->--}}

{{--                    @if(count($sequences) > 1)--}}
{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve["trimestre"])? round($eleve[$idGroupeMatiere]["trimestre"], 2) : '-' }}--}}
{{--                        </strong></td>--}}
{{--                    @endif--}}

{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve["totalCoef"])? round($eleve["totalCoef"], 2) : '-' }}--}}
{{--                        </strong></td>--}}

{{--                        <td style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>--}}
{{--                            {{ !is_null($eleve["totalNoteCoef"])? round($eleve["totalNoteCoef"], 2) : '-' }}--}}
{{--                        </strong></td>--}}

{{--                        <td colspan="3" style="border: 1px solid #181A1B; text-align: center; padding: 4px;"><strong>{{__('bulletin_secondaire.moyenne')}}</strong></td>--}}

{{--                        <td colspan="2" style="border: 1px solid #181A1B; text-align: center; padding: 4px; color: {{ $eleve[$idGroupeMatiere]['moyenne'] < 10 ? 'red' : 'inherit' }};">--}}
{{--                            <strong>--}}
{{--                                {{ !is_null($eleve['moyenne']) ? round($eleve['moyenne'], 2) : '-' }}--}}
{{--                            </strong>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </tfoot>--}}
{{--            </table>--}}
{{--        </div>--}}

{{--=======--}}
        @include('documents.create-documents.tableau-de-notes.defaut')
    @elseif(isset($route) && $route == "afc")
        @include('documents.create-documents.informations.default')
        @include('documents.create-documents.tableau-de-notes.defaut')
    @elseif(isset($route) && $route == "lamartine")
        @include('documents.create-documents.informations.lamartine')
        @include('documents.create-documents.tableau-de-notes.lamartine')
    @elseif(isset($route) && $route == "cim")
        @include('documents.create-documents.informations.cim')
        @include('documents.create-documents.tableau-de-notes.defaut')
    @elseif(isset($route) && $route == "iai")
        @include('documents.create-documents.informations.iai')
        @include('documents.create-documents.tableau-de-notes.iai')
    @elseif(isset($route) && $route == "ests")
        @include('documents.create-documents.informations.ests')
        @include('documents.create-documents.tableau-de-notes.ests')
    @else
        @include('documents.create-documents.informations.default')
        @include('documents.create-documents.tableau-de-notes.defaut')
    @endif

<!-- Bilan de l'évaluation -->
    @if(count($sequences) > 1)
        @include('documents.create-documents.bilan-evaluation.trimestre')
    @else
        @include('documents.create-documents.bilan-evaluation.sequence')
    @endif

@if(isset($route) && $route == "cim")
<!--AFFICHER Fait le : 19/11/2025 à DOUALA-->
<p style="margin-top: 10px; font-size: 14px;"><strong>{{ __('bulletin_secondaire.fait_le') }} : {{ \Carbon\Carbon::now()->format('d/m/Y') }} {{ __('bulletin_secondaire.a') }} DOUALA</strong></p>
@elseif (isset($route) && $route == "iai")
    <div style="width:100%; display:inline-flex; height:50px; ">
        <div style="width:30%; float:left;"><i><strong><span style="font-size: 14px;">Decision du Conseil des professeurs:</span></strong></i></div>
        <div class="full-width" style="width:70%; margin-top:4px; margin-left:28%; "><strong><span style="font-size: 14px;"> ADMIS (E)</span></strong></div>
    </div>

@elseif(isset($route) && $route == "ests")
<p style="margin-top: 10px; font-size: 14px; text-align: right; padding-right: 70px;"><strong>{{ __('bulletin_secondaire.fait_a') }} : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></p><br>
@else
<p style="margin-top: 10px; font-size: 14px;"><strong>{{ __('bulletin_secondaire.fait_le') }} : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></p><br>
<p style="margin-top: 10px; font-size: 14px;">Principal's comment: Next academic year begins on September 7th 2026</p>
@endif


<!-- Note informative  -->
    @if($route == "abiscoms")
        @include('documents.create-documents.exceptions.note-informative')
    @endif


<!-- Signatures -->
    @if(isset($route) && $route == "cim")
        @include('documents.create-documents.signatures.cim')
    @elseif(isset($route) && $route == "iai")
        @include('documents.create-documents.signatures.iai')
    @elseif(isset($route) && $route == "ests")
        @include('documents.create-documents.signatures.ests')
    @else
        @include('documents.create-documents.signatures.defaut')
    @endif

<!-- Pied de page -->
    @if($route == "afc")
        @include('documents.create-documents.pied-de-page.'. $route .'')
    @endif
</body>

</html>
