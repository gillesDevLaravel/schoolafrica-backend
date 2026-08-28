<!-- Legende des appreciations -->
@if(count($sequences) > 1)
<div style="width: 100%; display: flex; page-break-inside: avoid">
    <table style="width:58%; float:left; border-collapse: collapse;">
        <tr>
            <td rowspan="2" style="width: 20%; vertical-align: middle" class="td_border" >
                <p class="s10" style="font-size: 12px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{!! __('bulletin_primaire.leg_br_of_grade') !!}</strong>
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    [0;10[ = {{ __('bulletin_primaire.appr_nye') }} = {{ __('bulletin_primaire.appr_nye_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    [10;15[ = {{ __('bulletin_primaire.appr_ae') }} = {{ __('bulletin_primaire.appr_ae_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    [15;18[ = {{ __('bulletin_primaire.appr_me') }} = {{ __('bulletin_primaire.appr_me_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 8px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    [18;20] = {{ __('bulletin_primaire.appr_abe') }} = {{ __('bulletin_primaire.appr_abe_txt') }}
                </p>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation1.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation2.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation3.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation4.png"))) }}">
            </td>
        </tr>
    </table>
@else
    <table width="100%" style="border-collapse: collapse; margin-left: 0; page-break-inside: avoid">
        <tr>
            <td rowspan="2" style="width: 20%; vertical-align: middle" class="td_border" >
                <p class="s10" style="font-size: 14px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <strong>{!! __('bulletin_primaire.leg_br_of_grade') !!}</strong>
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    [0;10[ = {{ __('bulletin_primaire.appr_nye') }} = {{ __('bulletin_primaire.appr_nye_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    [10;15[ = {{ __('bulletin_primaire.appr_ae') }} = {{ __('bulletin_primaire.appr_ae_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    [15;18[ = {{ __('bulletin_primaire.appr_me') }} = {{ __('bulletin_primaire.appr_me_txt') }}
                </p>
            </td>
            <td style="border-bottom-style:none!important; width: 20%; vertical-align: auto" class="td_border" >
                <p class="s10" style="font-size: 10px; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    [18;20] = {{ __('bulletin_primaire.appr_abe') }} = {{ __('bulletin_primaire.appr_abe_txt') }}
                </p>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation1.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation2.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation3.png"))) }}">
            </td>
            <td style="text-align: center; vertical-align: auto; border-top-style:none!important; padding-bottom: 2px;" class="td_border" >
                <img style="width: 30px; height: 30px;" class="appreciation_img" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/appreciation4.png"))) }}">
            </td>
        </tr>
    </table>
@endif