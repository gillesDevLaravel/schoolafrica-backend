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
                                <h3>{{ $user }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
