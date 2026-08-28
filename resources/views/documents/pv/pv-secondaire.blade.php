<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PV de Classe</title>
    <style type="text/css">
        body { padding: 10px 30px; font-family: Arial, sans-serif; font-size: 12px; }
        * { margin:0; padding:0; text-indent:0; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1pt solid #212628; padding: 4pt; text-align: center; vertical-align: middle; }
        .v { height: 100px; white-space: nowrap; font-size: 8px; }
        .bold { font-weight: bold; }
        .left { text-align: left !important; padding-left: 6pt; }
        .gray { background: rgba(207,196,196,0.4); }
        .line { height: 3pt; background: #808080; }
    </style>
</head>
<body>
{{-- Entête du document --}}
@if(isset($route) && $route == "cim")
    @include('documents.create-documents.entetes.pv-secondaire-cim')
@else
    @include('documents.create-documents.entetes.pv-secondaire-defaut')
@endif

<table style="text-align: center; width: 100%; margin-bottom: 8px; border: none;">
    <tr>
        <td style="color:#{{$code_couleurs[0]}}; text-align: center; font-size:18px; border: none !important;">
            <strong>{{ strtoupper($ecole->name) }}</strong>
        </td>
    </tr>
</table>

<div style="text-align: center; font-weight: bold; font-size: 20px;">{{ __('bulletin_primaire.mark_sheet') }}</div>
<hr>

<div style="text-align: center; width: 100%; margin-top: 10px">
    <strong>{{ strtoupper($classe->name) }} </strong> ({{ data_get($detail_evaluation, 'name') }} / {{ $academic_year }} / {{$classe->nomSection}})
</div>

{{-- Effectifs --}}
<table style="width: 100%; margin-top: 10px;">
    <tr>
        <td style="width: 100%; border: none !important; ">
            <table style="border-collapse: collapse; margin-top: 5px;  width: 100%" cellspacing="0">
                <tr style="background-color: rgba(207, 196, 196, 0.4)">
                    <td colspan="3" style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.nouveaux') }}</strong></p>
                    </td>
                    <td colspan="3"
                        style="width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; padding-right: 2pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>{{ __('document_list_students.redoublants') }}</strong></p>
                    </td>
                    <td colspan="3"
                        style=" width: 30%; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px"><strong>TOTAL</strong></p>
                    </td>
                </tr>

                <tr>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.boys_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.girls_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.boys_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.girls_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.boys_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ __('bulletin_primaire.girls_abbr') }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">Total</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $effectif_classe["nouveaux"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $effectif_classe["nouvelles"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $tn = $effectif_classe["nouveaux"] + $effectif_classe["nouvelles"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $effectif_classe["redoublants"]}}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $effectif_classe["redoublantes"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $effectif_classe["redoublants"] + $effectif_classe["redoublantes"]  }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $tm =$effectif_classe["nbrGarcons"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $tf = $effectif_classe["nbrFilles"] }}</p>
                    </td>
                    <td style="width: 15pt; border-top-style: solid; border-top-width: 1pt; border-top-color: #212628; border-left-style: solid; border-left-width: 1pt; border-left-color: #212628; border-bottom-style: solid; border-bottom-width: 1.5pt; border-bottom-color: #212628; border-right-style: solid; border-right-width: 1pt; border-right-color: #212628;">
                        <p class="s2" style="padding-top: 4pt; text-indent: 0pt; text-align: center;font-size: 12px">{{ $tm + $tf }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- Tableau principal PV --}}
<table style="margin-top:20pt" cellspacing="0">
    <tr>
        <td rowspan="2" class="bold">N°</td>
        <td rowspan="2" class="bold" style="width:140px">NOMS DES ÉLÈVES</td>
        @foreach($matieres as $m)
            <td><span class="v">{{ $m['code'] }}</span></td>
        @endforeach
        <td rowspan="2"><span class="v">TOTAL</span></td>
        <td rowspan="2"><span class="v">MOY./20</span></td>
        <td rowspan="2"><span class="v">RANG</span></td>
        <td rowspan="2"><span class="v">APPR.</span></td>
        <td rowspan="2"><span class="v">DÉC.</span></td>
    </tr>
    <tr>
        @foreach($matieres as $m)
            <td class="bold">{{ $m['coef'] }}</td>
        @endforeach
    </tr>
    <tr><td colspan="{{ count($matieres) + 7 }}" class="line"></td></tr>
    <tr>
        <td colspan="2" class="bold">Note sur</td>
        @foreach($matieres as $m)
            <td>20</td>
        @endforeach
        <td>{{ array_sum(array_column($matieres,'coef')) * 20 }}</td>
        <td>/20</td>
        <td>/{{ count($moyennes) }}</td>
        <td colspan="2"></td>
    </tr>
    <tr><td colspan="{{ count($matieres) + 7 }}" class="line"></td></tr>

    @php $cpt = 1; @endphp
    @foreach($evaluation as $eleve)
        @php
            $moy = $eleve['moyenne'] ?? null;
            $isEvalue = !empty($eleve['isEvalue']);
            $app = $moy !== null ? getAppreciationGradeAndColor($moy,20) : null;
            $col = $app ? $legend_of_grade[$app[1]] : '000000';
            $passed = $isEvalue && $moy >= 10;

            // TOTAL PONDÉRÉ = Σ (note_matière × coef_matière)
            $totalPondere = 0;
            foreach($matieres as $m) {
                $note = $eleve[$m['idGroupMat']][$m['idMat']]['trimestre'] ?? null;
                $coef = $m['coef'] ?? 0;
                if ($note !== null) {
                    $totalPondere += $note * $coef;
                }
            }

            // Rang avec ex-aequo
            $rang = '-';
            if ($isEvalue && $moy !== null) {
                $pos = array_search($moy, $moyennes);
                if ($pos !== false) {
                    $rang = $pos + 1;
                    $ex = 0;
                    foreach($moyennes as $i => $v) {
                        if ($i != $pos && $v == $moy) $ex++;
                    }
                    if ($ex > 0) $rang .= ' ex';
                }
            }
        @endphp

        <tr>
            <td class="bold">{{ $cpt++ }}</td>
            <td class="left">{{ Str::limit($eleve['nom'], 21, '...') }}</td>

            @foreach($matieres as $m)
                @php
                    $n = $eleve[$m['idGroupMat']][$m['idMat']]['trimestre'] ?? null;
                    $c = $n !== null ? $legend_of_grade[getAppreciationGradeAndColor($n,20)[1]] : '000000';
                @endphp
                <td class="bold" style="color:#{{ $c }}">{{ $n !== null ? number_format($n, 2) : '-' }}</td>
            @endforeach

            {{-- TOTAL PONDÉRÉ (note × coef) --}}
            <td class="bold">{{ $totalPondere > 0 ? number_format($totalPondere, 2) : '-' }}</td>

            {{-- Moyenne sur 20 --}}
            <td class="bold" style="color:#{{ $col }}">{{ $moy !== null ? number_format($moy, 2) : '-' }}</td>

            <td class="bold">{{ $rang }}</td>

            <td style="color:#{{ $col }}">{{ $moy !== null ? getAppreciationAbrev($moy, $isSimple) : '-' }}</td>

            <td class="bold" style="color:{{ $passed ? 'green' : 'red' }}">
                {{ $isEvalue ? ($passed ? mb_substr(strtoupper(__('bulletin_primaire.PASSED')),0,1) : mb_substr(strtoupper(__('bulletin_primaire.FAILED')),0,1)) : '-' }}
            </td>
        </tr>
    @endforeach
</table>

{{-- Légende appréciations --}}
<table style="margin-top:15px; width:100%; font-size:11px">
    <tr>
        <td style="width:20%; font-weight:bold;">Légende des appréciations</td>
        <td style="color:#{{ $legend_of_grade['nye_color'] }}">(NYE) [0-10[ {{ $legend_of_grade['nye'] }} élèves</td>
        <td style="color:#{{ $legend_of_grade['ae_color'] }}">(AE) [10-15[ {{ $legend_of_grade['ae'] }} élèves</td>
        <td style="color:#{{ $legend_of_grade['me_color'] }}">(ME) [15-18[ {{ $legend_of_grade['me'] }} élèves</td>
        <td style="color:#{{ $legend_of_grade['abe_color'] }}">(ABE) [18-20] {{ $legend_of_grade['abe'] }} élèves</td>
    </tr>
</table>

{{-- Légende matières + Statistiques (PARFAITEMENT ALIGNÉS CÔTE À CÔTE) --}}
@php
    $rg=$rf=$eg=$ef=0;
    foreach($evaluation as $e){
        if(!empty($e['isEvalue']) && $e['moyenne']!==null){
            if($e['moyenne']>=10){
                substr(strtolower($e['sexe']??''),0,1)==='f' ? $rf++ : $rg++;
            }else{
                substr(strtolower($e['sexe']??''),0,1)==='f' ? $ef++ : $eg++;
            }
        }
    }
    $total = $rg+$rf+$eg+$ef;
    $taux = $total>0 ? round(($rg+$rf)*100/$total,2) : 0;
@endphp

    <!-- Tableau conteneur invisible -->
<table width="100%" style="margin-top:25pt; border:none; border-collapse:collapse;">
    <tr style="border:none;">
        <td style="border:none; vertical-align:top; width:50%; padding-right:10pt;">
            <div style="text-align:center; margin-bottom:8pt"><strong>{{ __('bulletin_primaire.legende') }}</strong></div>
            <table style="width:100%; font-size:11px; border-collapse:collapse;">
                <tr style="background:#{{$code_couleurs[0]??'808080'}}">
                    <td style="width:50pt">CODE</td>
                    <td>{{ __('bulletin_primaire.matter') }}</td>
                </tr>
                @foreach($matieres as $m)
                    <tr>
                        <td>{{ $m['code'] }}</td>
                        <td class="left">{{ $m['nomMat'] }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
        <td style="border:none; vertical-align:top; width:50%; padding-left:10pt;">
            <div style="text-align:center; margin-bottom:8pt"><strong>Exam Statistics</strong></div>
            <table style="width:100%; font-size:11px; border-collapse:collapse;">
                <tr style="background:#{{$code_couleurs[0]??'808080'}}">
                    <td></td><td>G</td><td>F</td><td>T</td>
                </tr>
                <tr><td>Total effectif</td><td>{{ $effectif_classe['nbrGarcons']??0 }}</td><td>{{ $effectif_classe['nbrFilles']??0 }}</td><td>{{ ($effectif_classe['nbrGarcons']??0)+($effectif_classe['nbrFilles']??0) }}</td></tr>
                <tr><td>Présents</td><td>{{ $rg+$eg }}</td><td>{{ $rf+$ef }}</td><td>{{ $total }}</td></tr>
                <tr><td>Admis</td><td>{{ $rg }}</td><td>{{ $rf }}</td><td>{{ $rg+$rf }}</td></tr>
                <tr><td>Ajournés</td><td>{{ $eg }}</td><td>{{ $ef }}</td><td>{{ $eg+$ef }}</td></tr>
                <tr><td>% Réussite</td><td colspan="3" style="font-weight:bold">{{ $taux }} %</td></tr>
                <tr><td>Moy. classe</td><td colspan="3" style="font-weight:bold">{{ $moyenneGenerale ? number_format($moyenneGenerale,2) : '-' }}/20</td></tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
