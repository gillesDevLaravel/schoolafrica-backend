@if(count($sequences) > 1)
    <table style="width:517px; padding-right:1%;float:left; border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    ({{__('bulletin_primaire.appr_nye_classik')}}) {{ __('bulletin_primaire.appr_nye_txt_classik') }} : [0;10[
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    ({{__('bulletin_primaire.appr_ae_classik')}}) {{ __('bulletin_primaire.appr_ae_txt_classik') }} : [10;15[
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    ({{__('bulletin_primaire.appr_me_classik')}}) {{ __('bulletin_primaire.appr_me_txt_classik') }} : [15;18[
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    ({{__('bulletin_primaire.appr_abe_classik')}}) {{ __('bulletin_primaire.appr_abe_txt_classik') }} : [18;20]
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>
@else
    <table width="100%" style="border-collapse: collapse; margin-left: 0; margin: 2px 0px">
        <tr>
            <td style="width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['nye_color']}}">
                    ({{__('bulletin_primaire.appr_nye_classik')}}) {{ __('bulletin_primaire.appr_nye_txt_classik') }} : [0;10[
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['ae_color']}}">
                    ({{__('bulletin_primaire.appr_ae_classik')}}) {{ __('bulletin_primaire.appr_ae_txt_classik') }} : [10;15[
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['me_color']}}">
                    ({{__('bulletin_primaire.appr_me_classik')}}) {{ __('bulletin_primaire.appr_me_txt_classik') }} : [15;18[
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-weight:bold; font-size: 8px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center; color: #{{$legend_of_grade['abe_color']}}">
                    ({{__('bulletin_primaire.appr_abe_classik')}}) {{ __('bulletin_primaire.appr_abe_txt_classik') }} : [18;20]
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>
@endif