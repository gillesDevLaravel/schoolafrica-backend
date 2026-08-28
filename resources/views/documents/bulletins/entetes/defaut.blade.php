<table style="width: 100%;">
    <tr>
        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIQUE DU CAMEROUN <br>
                paix-travail-patrie <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
                Ministere de l'education de Base <br><br>
                Region du Centre <br>
                Departement du Mfoundi
            </strong>
        </td>

        <td style="width: 70%; text-align: center;">
            @if(file_exists(public_path("/public/profil/{$ecole['logo']}")))
                <img style="max-height: 50px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole['logo']}"))) }}">
            @endif
        </td>

        <td style="text-align: center; width: 40%;">
            <strong>
                REPUBLIC OF CAMEROON <br>
                peace-work-fatherland <br>
                <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">*******</div>
                Ministry of basic education <br><br>
                Center Region<br>
                Mfoundi Division
            </strong>
        </td>
    </tr>
</table>

<!-- Nom de l'école -->
<table style="text-align: center;  width: 100%;">
    <tr>
        <td style="color:#{{$codeCouleur[0]}}; text-align: center; font-size:14px;"><strong>{{ strtoupper($ecole['nom']) }}</strong></td>
    </tr>
</table>


<!-- Titre du bulletin -->
    <table style="width:100%; text-align: center">
        <tr style="height: 10pt;">
            <td colspan="6" style="" >
                <p class="s10" style="padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.prog_rep_card') }} /
                    <u>{{ __('bulletin_primaire.eng_educ') }}</u> /
                    <strong>{{ $infosEvaluation['name'] }}</strong> /
                    <strong>2024/2025</strong>
                </p>
            </td>
        </tr>
    </table>
