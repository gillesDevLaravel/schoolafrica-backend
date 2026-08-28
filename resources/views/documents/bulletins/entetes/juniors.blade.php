<table style="width: 100%;">
    <tr style="">
        <td style="text-align: center; width: 40%;">
            REPUBLIQUE DU CAMEROUN <br>
            paix-travail-patrie <br>
            <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
            Ministere de l'education de Base <br><br>
            Region du Centre <br>
            Departement du Mfoundi
        </td>

        <td style="width: 70%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$ecole['logo']}")))
                <img style="max-height: 80px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole['logo']}"))) }}">
            @endif
        </td>
        <td style="text-align: center; width: 40%;">
            REPUBLIC OF CAMEROON <br>
            peace-work-fatherland <br>
            <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
            Ministry of basic education <br><br>
            Center Region<br>
            Mfoundi Division
        </td>
    </tr>
</table>

<table style="text-align: center;  width: 100%; margin-bottom: 8px">
    <tr>
        <td style="color:#{{$codeCouleur[0]}}; text-align: center; font-size:14px; "><strong>{{ strtoupper($ecole['nom']) }}</strong></td>
    </tr>
</table>

<hr>
<table width="90%" style="margin-left: 5%">
    <tr>
        <td style="text-align:center; background-color:green;font-size:17px;padding:5px; color:white;display:flex;" >{{ __('bul_mat.bul_notes') }}</td>
        <td style="text-align:center; background-color:red;font-size:17px;padding:5px; color:white;">{{ __('bul_mat.ensgn_franc') . " " . $infosEvaluation['name'] }}</td>
        <td style="text-align:center; background-color:rgb(239, 239, 49);font-size:17px;padding:5px; color:rgb(14, 14, 14);">2024/2025</td>
    </tr>
</table>
