@extends('layouts.app')

@section('content')
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    @for ($i = 0; $i < count($tabNote['user']); $i++)
        <section class="content">
            <div class="content-block">
                <div class="row clearfix">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="body">
                            </br></br></br>
                                Effectif Classe: {{ $tabNote['effectifClasse']}}</br>
                                @foreach ($tabNote['user'][$i]['trimestre'][0]['assessmentType'] as $assessmentType)
                                val :{{$assessmentType['name']}}
                                @endforeach
                                
                                        <div id="content" #content>
                                            {{-- ... (Adaptez le reste de la structure en conséquence) --}}
                                            <div class="cl1">
                                                <div class="cl4">
                                                    <div class="cl2 dis1 mag1 cl3">
                                                        <div class="dis2  w100">
                                                            <div class="w25 pad-l">Nom: {{ $tabNote['user'][$i]->name }}</div>
                                                            <div class="w25 pad-l">Redoublant: {{ $tabNote['user'][$i]->repeater }}</div>
                                                            <div class="w25 pad-l">Classe: {{ $tabNote['user'][$i]->classe }}</div>
                                                            <div class="pad-l"> SCHOOL YEAR : 2023/2024 </div>
                                                        </div>
                                                        {{-- Continuez à adapter le code en fonction de vos besoins --}}
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ... --}}
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="page-break"></div>
    @endfor
@endsection

