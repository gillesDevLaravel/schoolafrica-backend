@extends('layouts.app')  {{-- Assurez-vous d'adapter le nom de votre layout --}}

@section('content')
<section class="content">
    <div class="content-block">
        <div class="row clearfix">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        @foreach ($tabNote['user'] as $index => $user)
                            <div id="content" #content>
                                {{-- ... (Adaptez le reste de la structure en conséquence) --}}
                                <div class="cl1">
                                    <div class="cl4">
                                        <div class="cl2 dis1 mag1 cl3">
                                            <div class="dis2  w100">
                                                <div class="w25 pad-l">{{ $user->name }}</div>
                                                <div class="w25 pad-l">{{ $user->repeater }}</div>
                                                <div class="w25 pad-l">{{ $user->classe }}</div>
                                                <div class="pad-l"> SCHOOL YEAR : 2023/2024 </div>
                                            </div>
                                            {{-- Continuez à adapter le code en fonction de vos besoins --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- ... --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
