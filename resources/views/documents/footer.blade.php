<footer>
    <hr>
    <div style="float:left; width:10%;">
        <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}" alt="" style=" width:50px;";>
    </div>
    <div style="width:90%; text-align:center; float:right; margin-top:5px;">
        <p style="font-size: 12px; margin-top:5px;"> Tel: {{ $school->phone . " / " . $school->mobile }} | Email: {{ $school->email }} | Site web: {{ $school->website }}</p>
        <p style="font-size: 12px"> Siege Social : {{ $school->adresse }} </p>
    </div>
</footer>
