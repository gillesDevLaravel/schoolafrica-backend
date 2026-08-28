<!-- Informations de l'élève et de la classe -->
<table width="100%" style="border-collapse: collapse; margin-left: 0; margin-bottom: 2px">
    <tr>
        <td rowspan="2" width="50px">
            @php
                $photoPath = public_path("/public/profil/{$infosEleve->photo}");
                $photoData = file_exists($photoPath) ? image_data_uri($photoPath) : null;
                $fallbackData = image_data_uri(public_path("/public/profil/user.jpg"));
            @endphp
            @if($photoData)
                <img style="width: 50px; height: 50px; margin-right:10px;" src="{{ $photoData }}">
            @else
                <img style="width: 50px; height: 50px; margin-right:10px;" src="{{ $fallbackData }}">
            @endif
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt; color: #{{ $codeCouleur[0] }}">
                <strong>{{ $infosEleve->name }}</strong>
            </p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt;">
                {{ __('bulletin_primaire.class') }}: <strong style="color: #{{ $codeCouleur[0] }}">{{ $classe['name'] }}</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="margin-left: 1pt">
                {{ __('bulletin_primaire.reg_number') }}:
                <strong>{{ $infosEleve->matricule }}</strong> <br>
                {{ __('bulletin_primaire.sex') }}:
                <strong>{{ $infosEleve->gender[0] }}</strong> <br>
                {{ __('bulletin_primaire.repeater') }}:
                <strong>{{ $infosEleve->repeater ? __('bulletin_primaire.oui') : __('bulletin_primaire.non') }}</strong>
            </p>
        </td>
        <td>
            <p style="margin-left: 1pt">
                @php
                    $dateString = $infosEleve->birthday;
                    $date = new DateTime($dateString);
                    $formattedDate = $date->format('d / m / Y');
                @endphp

                {{ __('bulletin_primaire.birth_date') }}:
                <strong>{{ !is_null($infosEleve->birthday) ? $formattedDate : "-" }}</strong> <br>

                {{ __('bulletin_primaire.pays') }}:
                <strong>{{ $infosEleve->nationality }}</strong> <br>
                {{ __('bulletin_primaire.ville') }}:
                <strong>{{ $infosEleve->city }}</strong>
            </p>
        </td>
        <td colspan="2" style="width: 150px">
            <p style="margin-left: 1pt">
                <strong>{{ $classe['nomSection'] }}</strong> <br>
                {{ __('bulletin_primaire.effectif') }}:
                <strong style="color: #{{ $codeCouleur[0] }}">{{ $infosClasse['effectifClasse'] }}</strong> <br>
                {{ __('bulletin_primaire.teacher') }}:
                <strong>{{ $infosClasse['nomEnseignant'] }}</strong>
            </p>
        </td>
    </tr>
</table>
