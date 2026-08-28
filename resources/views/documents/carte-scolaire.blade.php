<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $doc_title }}</title>
</head>

<body style="font-family: 'Arial', sans-serif">
<div style="width:386px;height:245px;
    background-image: url('data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/bg_msshool.jpeg"))) }}');
    background-size: cover; /* Couvre entièrement la div */
    background-position: center; /* Centre l'image */
    background-repeat: no-repeat; /* Évite la répétition de l'image */
    border-radius: 30px; /* Ajustez la valeur selon le degré de courbure souhaité */
    overflow: hidden;
    ">
    <div style="width:100%;border-radius: 30px 30px 0px 0px; background-color:#{{ $couleurs[0] }} ;">
        <table style="width:100%;border-spacing: 0;padding-top:2px">
            <tr style="height:60px;border-radius: 30px 30px 0px 0px; padding:5px; width: 100%; color: white;border-collapse: collapse; ">
                <td style="width:43px">
                    <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$logo"))) }}" style="width:28px;max-height: 28px; border-radius: 1px; margin-left: 25px;" />
                </td>

                <td style="height:40px;width:280px; font-size: 15px; text-align:center; font-family: arial; color: white;">
                    {{ $school_name }}
                </td>

                <td style="width:43px">
                    <img src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/camr.jpg"))) }}" style="width:28px;max-height: 28px; border-radius: 1px; margin-right: 15px" />
                </td>
            </tr>
        </table>
    </div>

    <div style="width:80%; background-color:#{{ $couleurs[1] }}; text-align:center; font-size:15px; margin-left:45px;border-radius: 0px 0px 20px 20px;padding:3px; color: white">
        {{ $school->adresse }}
    </div>

    <div style="width: 356px; height: 120px; display: flex; margin-left: 8px; padding-top: 15px; float:left">
        @php
            $imagePath = public_path("/public/profil/$image");
            $imageData = file_exists($imagePath) ? image_data_uri($imagePath) : image_data_uri(public_path("/public/profil/user.jpg"));
        @endphp
        <img src="{{ $imageData }}"
             style="width:160px;height:110px; margin-left: 10px; margin-top:10px;padding:1px;margin-right: 0px; max-height: 80px;max-width: 90px; border-radius: 5px; box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.3);">

        <div style="width: 85%; margin-left: 115px;float:left; margin-top: 10px; font-size: 12px">
            <div style="margin-bottom: 6px">
                <span style="color:#{{ $couleurs[0] }}; font-size:12px; font-weight:bold;"> {{ __('document_carte_scolaire.nom') }}:</span>  {{ $name }}
            </div>
            <div style="margin-bottom: 6px">
                <span style="color:#{{ $couleurs[0] }}; font-size:12px; font-weight:bold;"> {{ __('document_carte_scolaire.classe') }}:</span> {{ $class }}
            </div>
            <div style="margin-bottom: 6px">
                <span style="color:#{{ $couleurs[0] }}; font-size:12px; font-weight:bold;"> {{ __('document_carte_scolaire.matricule') }}:</span>  {{ $matricule }}
            </div>
            <div style="margin-bottom: 6px">
                <span style="color:#{{ $couleurs[0] }}; font-size:12px; font-weight:bold;"> {{ __('document_carte_scolaire.numero') }}:</span>  {{ $number }}
            </div>
        </div>
    </div>

    <div style="display: flex; background-color:#{{ $couleurs[1] }}; width:100%; height:20px; color: black; font-size: 10px; margin-top:137px;">
        <div style="width: 100%; text-align: center; padding-top: 2px; color: white">
            {{ $school->phone }} | {{ $school->email }} | {{ $school->website }}
        </div>
    </div>

    <div style="display: flex; background-color:#{{ $couleurs[0] }};width:100%;height:20px;color: white; border-radius: 0px 0px 30px 30px; font-size: 10px;">
        <div style="width:100%; padding-top:1px">
            <div style="display: inline-flex; margin-left:20px; width: 210px; text-align:left; font-size:12px;">{{ __('document_carte_scolaire.id_card') }}</div>
            <div style="display: inline-flex; width: 130px; font-size:12px; margin-top: 5px; text-align: right"> {{ $annee_scolaire}}</div>
        </div>
    </div>
</div>
</body>

</html>
