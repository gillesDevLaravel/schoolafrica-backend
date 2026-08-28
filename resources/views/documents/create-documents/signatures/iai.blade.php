<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 16px; margin-top: 10px;">

    <tr>

        <td style="width: 20%; font-size: 16px; font-weight: bold; align-items: center; justify-content: center; padding: 2px; vertical-align: bottom; text-align: right; padding-right: 70px;">
          <div>LE REPRESNTANT RESIDENT<br>CHEF D'ETABLISSEMENT<br><br>ARMAND CLAUDE ABANDA</div>
            @if(file_exists(public_path('public/profil/seal-signature-director.png')))
                <img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}"
                    alt="Signature"
                    style="height: 130px; object-fit: contain;">

            @endif

        </td>
    </tr>
</table>
