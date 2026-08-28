<table style=" padding-right:2%;float:left; border-collapse: collapse; margin-left: 0;">
    <!-- Première div avec flex-direction: column pour disposer les cases verticalement -->
    <div >
        <div style="margin-bottom: 7.5px;">
            <label style="font-size: 12px;">
                <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.tableau_dhonneur')}}
            </label>
        </div>
        <div style="margin-bottom: 7.5px;">
            <label style="font-size: 12px;">
                <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.encouragements')}}
            </label>
        </div>
        <div style="margin-bottom: 7.5px;">
            <label style="font-size: 12px;">
                <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.felicitations')}}
            </label>
        </div>
    </div>
</table>

<table style="float:right; border-collapse: collapse; margin-left: 0;">
    <tr>
        <!-- Deuxième div avec flex-direction: column pour disposer les cases verticalement -->
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="margin-bottom: 7.5px;">
                <label style="font-size: 12px;">
                    <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.avertissement')}}
                </label>
            </div>
            <div style="margin-bottom: 7.5px;">
                <label style="font-size: 12px;">
                    <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.blame')}}
                </label>
            </div>
            <div style="margin-bottom: 7.5px;">
                <label style="font-size: 12px;">
                    <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.conduite')}}
                </label>
            </div>
            <div style="margin-bottom: 7.5px;">
                <label style="font-size: 12px;">
                    <input type="checkbox" name="option1" style="transform: scale(1.5); margin-right: 5px;"> {{__('bulletin_secondaire.avertissement_conduite')}}
                </label>
            </div>
        </div>
    </tr>
</table>
