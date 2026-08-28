<!-- Informations de l'élève et de la classe -->
<table width="100%" style="border-collapse: collapse; margin-left: 0;">
    <tr>
        <td rowspan="2" style="width: 100px;">
            @if(file_exists(public_path("/public/profil/{$eleve['photo']}")))
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$eleve['photo']}"))) }}">
            @else
                <img style="width: 85px; height: 70px; margin-right:10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/user.jpg"))) }}">
            @endif
        </td>
        <td colspan="2">
            <p style="font-size:14px; margin-left: 1pt; color: green"><strong>{{ $eleve['name'] }}</strong></p>
        </td>
        <td colspan="2">
            <p style="margin-left: 1pt; color: green"><strong>{{ $classe->name }}</strong></p>
        </td>
    </tr>
    <tr>
        <td >
            <p style="margin-left: 1pt">
                {{__('bulletin_primaire.reg_number')}}: <strong>{{ $eleve['matricule'] }}</strong> <br>
                {{__('bulletin_primaire.sex')}}: <strong><strong>{{ $eleve['gender'][0] }}</strong></strong> <br>
                {{__('bulletin_primaire.repeater')}}: <strong>{{ ($eleve['repeater']) ? __('bulletin_primaire.oui') : __('bulletin_primaire.non') }}</strong>
            </p>
        </td>
        <td>
            <p style="margin-left: 1pt">
                @php
                    $dateString = $eleve['birthday'];
                    $date = new DateTime($dateString);
                    $formattedDate = $date->format('d / m / Y');
                @endphp

                {{__('bulletin_primaire.birth_date')}}: <strong>{{ (!is_null($eleve['birthday'])) ? $formattedDate : "-" }}</strong> <br>

                {{__('bulletin_primaire.pays')}}: <strong>{{ $eleve['nationality'] }}</strong> <br>
                {{--                {{__('bulletin_primaire.ville')}} <strong>{{ $elevecity }}</strong>--}}
            </p>
        </td>
        <td colspan="2" style="width: 150px">
            <p style="margin-left: 1pt">
                <strong>{{ $classe['nomSection'] }}</strong> <br>
                {{__('bulletin_primaire.effectif')}}: <strong style="color: green">{{ $infosClasse['effectifClasse'] }}</strong> <br>
                {{__('bulletin_primaire.teacher')}}: {{ @$teacher_principal->name }}
            </p>
        </td>
    </tr>
</table>
<br>
