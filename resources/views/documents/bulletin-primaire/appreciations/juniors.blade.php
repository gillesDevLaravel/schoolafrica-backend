<!-- Legende des appreciations -->
@if(count($sequences) > 1)
    <table style="width:69%; padding-right:1%;float:left; border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="font-weight: bold; width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['nye_color']}}">({{__('bulletin_primaire.appr_nye')}}) {{ __('bulletin_primaire.appr_nye_txt') }} : [0;10[</span>
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['ae_color']}}">({{__('bulletin_primaire.appr_ae')}}) {{ __('bulletin_primaire.appr_ae_txt') }} : [10;15[</span>
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['me_color']}}">({{__('bulletin_primaire.appr_me')}}) {{ __('bulletin_primaire.appr_me_txt') }} : [15;18[</span>
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['abe_color']}}">({{__('bulletin_primaire.appr_abe')}}) {{ __('bulletin_primaire.appr_abe_txt') }} : [18;20]</span>
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>
@else
    <table width="100%" style="border-collapse: collapse; margin-left: 0;">
        <tr>
            <td style="font-weight: bold; width: 10%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;" >
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    {{ __('bulletin_primaire.leg_of_grade') }}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['nye_color']}}">({{__('bulletin_primaire.appr_nye')}}) {{ __('bulletin_primaire.appr_nye_txt') }} : [0;10[</span>
                    <br> {{$legend_of_grade['nye'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['ae_color']}}">({{__('bulletin_primaire.appr_ae')}}) {{ __('bulletin_primaire.appr_ae_txt') }} : [10;15[</span>
                    <br> {{$legend_of_grade['ae'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['me_color']}}">({{__('bulletin_primaire.appr_me')}}) {{ __('bulletin_primaire.appr_me_txt') }} : [15;18[</span>
                    <br> {{$legend_of_grade['me'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
            <td style="font-weight: bold; width: 20%;border-top-style: solid;border-top-width: 1pt;border-top-color: #808080;border-left-style: solid;border-left-width: 1pt;border-left-color: #808080;border-bottom-style: solid;border-bottom-width: 1pt;border-bottom-color: #808080;border-right-style: solid;border-right-width: 1pt;border-right-color: #808080;">
                <p class="s10" style="font-size: 9px!important; padding: 2pt; text-indent: 0pt; line-height: 10pt; text-align: center;">
                    <span style="color: #{{$legend_of_grade['abe_color']}}">({{__('bulletin_primaire.appr_abe')}}) {{ __('bulletin_primaire.appr_abe_txt') }} : [18;20]</span>
                    <br> {{$legend_of_grade['abe'] . " " . __('bulletin_primaire.leaners')}}
                </p>
            </td>
        </tr>
    </table>
@endif