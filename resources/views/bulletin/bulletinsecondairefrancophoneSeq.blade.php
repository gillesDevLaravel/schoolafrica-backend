@extends('layouts.headerbulletinsecondairefrancophone')

@section('content')
    
    @foreach ($tabNote['user'] as $user) 
              
        <section class="content">
            <div class="content-block">
                <div class="row clearfix">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            @foreach ($user['trimestre'] as $trimestre)
                                @foreach ($trimestre['assessmentType'] as $assessmentType)
                                    <div>
                                        <div>
                                        <div id="content" #content *ngIf="indes === index">
                                            <div class="cl1">
                                            <div class="cl4 w">
                                                <table style=" margin-top: 2px;">
                                                <tr class="styl5">
                                                    <th align="left" class="styl6">
                                                    MINISTERE DES ENSEIGNEMENTS SECONDAIRES <br>
                                                    ***************************** <br>
                                                    DELEGATION REGIONALE POUR LE CENTRE <br>
                                                    ***************************** <br>
                                                    DELEGATION DEPARTEMENTALE DU MFOUDI <br>
                                                    ***************************** <br>
                                                    COMPLEXE SCOLAIRE BILINGUE B. OLIVE <br>
                                                    </th>
                                                    <td align="right" style="width: 10%;">
                                                    <img src="assets/logo/oli.jpg"
                                                        class="textimg"
                                                        style="max-height: 30px; max-width: 30px; border-radius: 1px;" />
                                                    </td>
                                                    <th align="right" class="styl7">
                                                    REPUBLIQUE DU CAMEROUN <br>
                                                    Paix - Travail - Patrie <br>
                                                    ************** <br>
                                                    ANNEE SCOLAIRE 2023-2024
                                                    <br><br><br>
                                                    </th>
                                                </tr>
                                                </table>
                                                <div class="styl">
                                                <div style="width: 20%">
                                                </div>
                                                <div class="styl1">
                                                    <span></span>
                                                </div>
                                                <div style="width: 20%;">
                                                </div>
                                                </div>
                                                <div style="display: flex;">
                                                <div style="width: 20%">
                                                </div>
                                                <div class="styl2">
                                                    <span>
                                                    BULLETIN DE NOTES SEQUENCE
                                                    {{ $assessmentType['name'] }}
                                                    </span>
                                                </div>
                                                <div style="width: 20%;">
                                                </div>
                                                </div>
                                                <div style="display: flex; margin-top: 5px; ">
                                                <div class="styl3">
                                                    <span>Nom et prenom : {{ $user['name'] }} </span><br>
                                                    <span>Sexe: {{ $user['gender'] }}</span><br>
                                                    <span>Matricule : </span><br>
                                                    <span>Né(e) le :</span><br>
                                                    <span>Année scolaire : 2023 - 2024 </span>
                                                </div>
                                                <div class="styl4">
                                                    <span>Classe : {{ $user['classe']}} </span><br>
                                                    <span>Redoublant : Non</span><br>
                                                    <span>Effectifs :
                                                        {{ $tabNote['effectifClasse']}}
                                                    </span><br>
                                                    <span>Situation : Nouveau</span><br>
                                                    <span class="spacing">Professeur Titulaire :
                                                    <span *ngIf="classroom.teacher != null">
                                                        {{--classroom.teacher.name--}}
                                                    </span>
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="dis2 cl5 w100 tx-c mag3 bord bold">
                                                <div class="w20 pad-ls bor-r">DISCIPLINES</div>
                                                <div class="w20 pad-ls bor-r">ENSEIGNANTS</div>
                                                <div class="w10 pad-ls bor-r">EVAL 1 </div>
                                                <div class="w10 pad-ls bor-r">COEF. </div>
                                                <div class="w15 pad-ls bor-r">TOTAL</div>
                                                <div class="w10 pad-ls bor-r">RANG</div>
                                                <div class="w10 pad-ls bor-r">MENTIONS</div>
                                                <div class="w10 pad-ls ">VISA </div>
                                                </div>
                                                @foreach ($assessmentType['matterGroup'] as $matterGroup)
                                                    <div class="dis1 cl5 w100">
                                                    @foreach ($matterGroup['assessment'] as $assessment)
                                                        <div class="dis2 cl5 w100 boru">
                                                            <div class="w20 pad-ls bor-r bor-l bold tx-l">
                                                            {{$assessment['nameMatter']}}
                                                            </div>
                                                            <div class="w20 pad-ls bor-r" style="font-size: 2.5;">
                                                            {{$assessment['tearcherName']}}
                                                            </div>
                                                            <div class="w10 pad-ls bor-r bold">
                                                                <span>
                                                                    @if ($assessment['ratings'] && $assessment['ratings'] != null) 
                                                                            @if($assessment['ratings']->value === null) 
                                                                                <span class="tx-color"> {{ $tabNote['vide'] }}</span> 
                                                                            @endif  

                                                                            @if ($assessment['ratings']->value != null && $assessment['ratings']->value < 10)
                                                                                <span class="col-red"> {{$assessment['ratings']->value}} </span>
                                                                            @elseif ($assessment['ratings']->value != null && $assessment['ratings']->value >= 10)
                                                                                <span> {{$assessment['ratings']->value}} </span>
                                                                            @endif                                             

                                                                    @else
                                                                        <span class="tx-color"> {{ $tabNote['vide'] }}</span>                                                    
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="w10 pad-ls bor-r bold">
                                                                <span>
                                                                    @if ($assessment['ratings'] === null)
                                                                        <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                                    @elseif ($assessment['ratings'] != null)
                                                                        <span class="tx-color">{{ $assessment['ratings']->coefficient }}</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="w15 pad-ls bor-r bold">
                                                                <span *ngIf="matter.ratings != null">
                                                                    @if ($assessment['ratings'] != null)
                                                                        @if ($assessment['ratings']->value != null)
                                                                            <span>
                                                                                {{ $assessment['ratings']->value *
                                                                                $assessment['ratings']->coefficient }}
                                                                            </span>
                                                                        @else
                                                                            <span class="tx-color"> {{ $tabNote['vide'] }}</span>         
                                                                        @endif
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="w10 pad-ls bor-r bold">
                                                                <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                            </div>
                                                            <div class="w10 pad-ls bor-r bold">
                                                                <span>
                                                                    @if ($assessment['ratings'] != null)
                                                                        @if ($assessment['ratings']->value === null)
                                                                            <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                                        @elseif ($assessment['ratings']->value != null)
                                                                            @if ($assessment['ratings']->value <= 10)
                                                                            <span>NA</span> 
                                                                            @endif
                                                                            @if ($assessment['ratings']->value > 10 && $assessment['ratings']->value < 14)
                                                                            <span>ECA</span> 
                                                                            @endif                                                        
                                                                            @if ($assessment['ratings']->value > 14 && $assessment['ratings']->value < 17)
                                                                            <span>A</span> 
                                                                            @endif                                                        
                                                                            @if ($assessment['ratings']->value > 17)
                                                                            <span>E</span> 
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                                    @endif                                                
                                                                </span>
                                                            </div>
                                                            <div class="w10 pad-ls bor-r">
                                                                <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                            </div>
                                                            
                                                        </div>
                                                    @endforeach
                                                    <div class="dis2 cl5 w100 bors"
                                                        style="background-color: rgb(194, 196, 196);">
                                                        <div class="w40 pad-ls bor-r boru bor-l bold tx-r"
                                                        style="text-align: left;">
                                                        {{$matterGroup['description']}}
                                                        </div>
                                                        <div class="w10 pad-ls bor-r boru bold">
                                                        {{$matterGroup['totalNoteByMatterGroup']}}
                                                        </div>
                                                        <div class="w10 pad-ls bor-r boru bold">
                                                        {{$matterGroup['totalCoefMatterGroupAssessment']}}
                                                        </div>
                                                        <div class="w15 pad-l bor-r boru bold">
                                                        {{ $matterGroup['totalNoteCoefByMatterGroup'] }}
                                                        </div>
                                                        <div class="w20 pad-ls bor-r boru bold">
                                                        MOY
                                                        </div>
                                                        <div class="w10 pad-ls bor-r boru bold">
                                                            @if ($matterGroup['MoyenneMatterGroup'] < 10)
                                                                <span class="col-red">
                                                                    {{$matterGroup['MoyenneMatterGroup']}}
                                                                </span>
                                                            
                                                            @elseif ($matterGroup['MoyenneMatterGroup'] >= 10)
                                                                <span>
                                                                    {{$matterGroup['MoyenneMatterGroup']}}
                                                                </span>
                                                                
                                                            @endif
                                                        </div>
                                                    </div>
                                                    </div>
                                                @endforeach
                                                <div class="dis2 cl5 w100 bors">
                                                <div class="w40 pad-ls bor-r boru bor-l bold tx-r"
                                                    style="text-align: left;">
                                                    <span class="bor-r bold">TOTAL SEQUENCE</span>
                                                </div>
                                                <div class="w10 pad-ls bor-r boru bold">
                                                    {{$assessmentType['totalSequence']}}
                                                </div>
                                                <div class="w10 pad-ls bor-r boru bold">
                                                    {{$assessmentType['totalSequenceCoef']}}
                                                </div>
                                                <div class="w15 pad-ls bor-r boru bold">
                                                    {{$assessmentType['totalSequenceNoteCoef']}}
                                                </div>
                                                <div class="w20 pad-ls bor-r boru bold">
                                                    Moyenne
                                                </div>
                                                <div class="w10 pad-ls bor-r boru bold">
                                                    <span class="col-red">
                                                    {{$assessmentType['moyenne']}}
                                                    </span>
                                                    <span>
                                                    {{$assessmentType['moyenne']}}
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="dis2 mag1 cl5 w-100 tx-c generle">
                                                <div class="w10 pad-l bor-r boru bor-l">Total Abs</div>
                                                <div class="w15 pad-l bor-r boru">Non-Justifier Abs</div>
                                                <div class="w10 pad-l bor-r boru">Sanctions</div>
                                                <div class="w25 pad-l bor-r boru">Conseil de
                                                    Discipline</div>
                                                <div class="w40 pad-l bor-r boru bold">
                                                    Commentaire
                                                </div>
                                                </div>
                                                <div class="dis2 mag1 cl5 w-100 tx-c">
                                                <div class="w10 pad-l bor-r boru bor-l">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                <div class="w15 pad-l bor-r boru">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                <div class="w10 pad-l bor-r boru">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                <div class="w25 pad-l bor-r boru">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                <div class="w40 pad-l bor-r boru bold">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                </div>
                                                <div class="dis2 mag1 cl5 w-100 tx-c">
                                                <div class="w10 pad-l bor-r boru bor-l">Moy Classe</div>
                                                <div class="w15 pad-l bor-r boru">Moy Eleve</div>
                                                <div class="w10 pad-l bor-r boru">Rang</div>
                                                <div class="w25 pad-l bor-r boru">
                                                    Commentaire
                                                </div>
                                                <div class="w40 pad-l bor-r bold">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                </div>
                                                <div class="dis2 mag1 cl5 w-100 tx-c bors">
                                                <div class="w10 pad-l bor-r boru bor-l">
                                                    {{$tabNote['moyenneClasse']}}
                                                </div>
                                                <div class="w15 pad-l bor-r boru ff bold">
                                                        @if ($assessmentType['moyenne'] < 10)
                                                            <span class="col-red">
                                                                {{$assessmentType['moyenne']}}
                                                            </span>
                                                        @elseif ($assessmentType['moyenne'] >= 10)
                                                            <span>
                                                                {{$assessmentType['moyenne']}}
                                                            </span>
                                                            
                                                        @endif
                                                </div>
                                                <div class="w10 pad-l bor-r boru bold">
                                                    {{--user.trimestre[0].assessmentType[0].rang --}}
                                                </div>
                                                <div class="w25 pad-l bor-r boru">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                <div class="w40 pad-l bor-r bold">
                                                    <span class="tx-color"> {{ $tabNote['vide'] }}</span>
                                                </div>
                                                </div>
                                                <div class="cl2 dis2 mag1 cl3 w100 pad-l">
                                                fait à Yaoundé le :
                                                </div>
                                                <div class="cl2 dis2 mag1 cl3 w100 generle bold">
                                                <div class="w50 pad-l"> Parent</div>
                                                <div align="right" class="w50 pad-l">
                                                    Professeur Titulaire
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="page-break"></div>
                                @endforeach
                                
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="page-break"></div>
        
    @endforeach
@endsection

