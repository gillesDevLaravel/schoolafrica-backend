<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; margin-top: 10px;">
    <!-- Ligne des textes (parent et principal) -->
    <tr>
        <td style="text-align: left; padding: 5px; vertical-align: top;">
            {{ __('bulletin_secondaire.visa_du_parent') }}
        </td>
        <td style="width: 20%; align-items: center; justify-content: center; padding: 2px; vertical-align: bottom; text-align: center;">
            {{ __('bulletin_secondaire.visa_du_principal') }} <br>

            @if(file_exists(public_path('public/profil/sign-principal-'. $route .'.png')))
                <img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/sign-principal-'. $route .'.png'))) }}"
                    alt="Signature"
                    style="height: 130px; object-fit: contain;">
                @if($route == 'afc')
                    <p style="font-family: cursive;">Jules AKAMA AKAMA</p>
                @endif
            @endif

        </td>
    </tr>
</table>
