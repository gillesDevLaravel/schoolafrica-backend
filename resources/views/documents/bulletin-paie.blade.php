<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $doc_title }}</title>
<style>
@page {
    margin: 7px;
}
body {
    margin: 7px;
    padding: 10px;
}
/* ===== TABLE ===== */
.main-table {
  width: 100%;
  overflow: visible;
  border-collapse: collapse;
  font-size: 7pt;
  height: 20px;
 
}

.main-table td, .main-table th {
  border: 1px solid #070707ff;
  padding: 3px 5px;
  vertical-align: middle;
  height: 9px;
}

/* Colonnes */
.c1 { width: 7%; }
.c2 { width: 28%; }
.c3 { width: 12%; }
.c4 { width: 10%; }
.c5 { width: 12%; }
.c6 { width: 9%; }
.c7 { width: 7%; }
.c8 { width: 25%; }

/* Labels / Headers */
.lbl { font-weight: bold;  font-size: 7pt; }
.center { text-align: center; }
.left { text-align: left; }
.right { text-align: right; }

.bold { font-weight: bold; }


/* Headers de sections */
.th-teal {
  background: #00bfff; /* bleu clair */
  color: black;
  font-weight: bold;
  text-align: center;
  font-size: 7.5pt;
  padding: 4px;
}

.th-teal-sub {
  background: #5dade2;
  color: black;
  font-weight: bold;
  text-align: center;
  font-size: 7pt;
  padding: 3px;
}

/* Sidebar vertical */
.sidebar-cellvertical {

  text-align: center;
  font-weight: bold;
  font-size: 7pt;
  vertical-align: middle;
}
.vertical-text {
  display: inline-block;
  transform: rotate(-90deg);
}
.sidebar-cell {
  writing-mode: vertical-rl; /* vertical */
  text-orientation: mixed; /* texte droit, pas renversé */
  text-align: center;
  font-weight: bold;
  font-size: 7pt;
  vertical-align: middle;
}

/* Lignes spécifiques */
.salaire-brut td {  font-weight: bold; }
.total-fiscal td, .total-social td {  font-weight: bold; }
.total-retenues td { background: #d6eaf8; font-weight: bold; }
.net-payer-row td { background: #00bfff; color: black; font-weight: bold; font-size: 7pt; }
.net-amount-cell { background: #d6eaf8 !important; color: black !important; text-align: right; font-weight: bold; font-size: 11pt; }

/* Notices / Récap */
.notice td {
  font-style: italic;
  font-size: 6.5pt;
  color: #48841aff;
  text-align: center;
  padding: 3px;
}

.recap-hd td {
  background: #d6eaf8;
  font-weight: bold;
  font-size: 8pt;
  text-align: center;
  padding: 2px;
}


.recap-dt td {
  font-weight: bold;
  font-size: 9pt;
  text-align: center;
  padding: 3px;
}

/* Lignes vides / séparateurs */
.sep td { height: 5px; border: none !important; background: white !important; }

/* Ajustements des bordures pour PDF */
.main-table tr td:first-child, .main-table tr th:first-child { border-left: 1px solid #000000ff; }
.main-table tr td:last-child, .main-table tr th:last-child { border-right: 1px solid #000000ff; }
</style>
    @if(isset($route) && $route == "abiscoms")
        @include('documents.create-documents.entetes.entete-bulletin-secondaire-abiscom')
    @elseif(isset($route) && $route == "afc")
        @include('documents.create-documents.entetes.entete-bulletin-secondaire-afc')

    @elseif(isset($route) && $route == "cim")
        @include('documents.create-documents.entetes.entete-bulletin-secondaire-montreal')
    @elseif(isset($route) && $route == "juniors")
    <table style="width: 100%;">
    <tr style="font-size: 13px">
        <td style="text-align: center; width: 40%;">
            REPUBLIQUE DU CAMEROUN <br>
            paix-travail-patrie <br>
            <div style="margin-left: 3%; margin-top: 1pt; margin-bottom: 2px;">********</div>
            Ministere de l'education de Base <br>
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
            Ministry of basic education <br>
            Center Region<br>
            Mfoundi Division
        </td>
    </tr>
</table>
    @else
        @include('documents.create-documents.entetes.entete-bulletin-secondaire')
    @endif
</head>
<br>
<body>
<div class="page">

<!-- ===== HEADER ===== -->



<!-- ===== SINGLE BIG TABLE ===== -->
<table class="main-table">
<colgroup>
  <col class="c1"><col class="c2"><col class="c3"><col class="c4">
  <col class="c5"><col class="c6"><col class="c7"><col class="c8">
</colgroup>

<!-- ─── INFO ÉCOLE ─── -->
<tr>
  <td class="lbl">{{ __('bulletin-de-paie.situe_a') }}</td>
  <td><strong>{{ $school->adresse }}</strong></td>
  <td></td><td></td><td></td>
  <td colspan="3" style="text-align: left; font-weight:bold;">{{ $school->city}} , le {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
</tr>
<tr>
  <td class="lbl">{{ __('bulletin-de-paie.tel') }}</td>
  <td>{{ $school->phone }}</td>
  <td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<tr>
  <td  class="lbl">{{ __('bulletin-de-paie.cnps') }}</td>
  <td >{{ $etab->cnps }}</td>
  <td></td><td></td><td></td><td></td><td></td><td></td>
</tr>

<!-- ─── TITRE ─── -->
<tr>
  <td colspan="8" style="text-align:center; font-weight:bold; font-size:8pt; padding:5px 0;">
    {{ __('bulletin-de-paie.bulletin_de_paie') }}
  </td>
</tr>

<!-- ─── INFOS EMPLOYÉE ─── -->
 @php
    $date = \Carbon\Carbon::parse($invoice->date);
@endphp
<tr>
  <td  class="lbl">{{ __('bulletin-de-paie.nom_et_prenom') }}</td>
  <td class="lbl">{{ $user->name }}</td>
  <td></td><td></td><td></td><td></td><td></td><td></td>

</tr>
<tr>
  <td  class="lbl">{{ __('bulletin-de-paie.date_de_naissance') }}</td>
  <td class="lbl">{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}</td>
  <td></td><td></td>
  <td colspan="4"><strong>{{ __('bulletin-de-paie.periode') }} : {{ $date->copy()->startOfMonth()->format('d/m/Y') }} – {{ $date->copy()->endOfMonth()->format('d/m/Y') }}</strong></td>
</tr>
<tr>
  <td  class="lbl">{{ __('bulletin-de-paie.date_d\'entree') }}</td>
  <td class="lbl">{{ \Carbon\Carbon::parse($user->hiring_date)->format('d/m/Y') }}</td>
  <td></td><td></td>
  <td colspan="4"><strong>Bulletin N°: {{ $invoice->number }}</strong></td>
</tr>
<tr>
  <td class="lbl">{{ __('bulletin-de-paie.emploi') }}</td>
  <td class="lbl">{{ $user->profession }}</td>
  <td></td><td></td>
  <td><strong>{{ __('bulletin-de-paie.anciennete') }} : {{ $user->anciennete }} ans</strong></td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td class="lbl">{{ __('bulletin-de-paie.num_cnps') }}</td>
  <td class="lbl">{{ $user->num_cnps }}</td>
  <td></td><td></td>
  <td class="left"><strong>CAT</strong></td>
  <td class="center"><strong>{{ $user->cat }}</strong></td>
  <td class="lbl center"><strong>ECH</strong></td>
  <td class="left"><strong>{{ $user->ech }}</strong></td>
</tr>
<tr>
  <td colspan="8" ></td>
</tr>

<!-- elements de gain-->
 @php
$nbreGains = collect($salary_components)
    ->where('code', 'ELEMENTS DE GAIN')
    ->count();
@endphp
<tr>
  <td rowspan="{{ 3 + $nbreGains }}" class="sidebar-cellvertical"><span class="vertical-text">{{ __('bulletin-de-paie.Elements_de_gain') }}</span></td>
  <td class="th-teal center">{{ __('bulletin-de-paie.Rubrique') }}</td>
  <td class="th-teal center">{{ __('bulletin-de-paie.base') }}</td>
  <td class="th-teal center">{{ __('bulletin-de-paie.coeff') }}</td>
  <td class="th-teal center">{{ __('bulletin-de-paie.gains') }}</td>
  <td class="th-teal center"></td><td class="th-teal center"></td><td class="th-teal center"></td>
</tr>
@foreach($salary_components->where('code', 'ELEMENTS DE GAIN')->sortBy('order') as $component)
    <tr>
        <td class="lett">{{ $component['name'] }}</td>
        <td class="right">{{ $component['base_amount'] }}</td>
        <td class="right">{{ $component['coef'] }}</td>
        <td class="right">{{ $component['base_amount'] * $component['coef'] }}</td>
        <td class="right"></td><td></td><td></td>
    </tr>
@endforeach
@php
$totalBrut = collect($salary_components)
    ->where('code', 'ELEMENTS DE GAIN')
    ->sum(function($component){
        return $component['base_amount'] * $component['coef'];
    });
@endphp

<tr class="salaire-brut">
  <td>{{ __('bulletin-de-paie.salaire_brut') }}</td>
  <td></td><td></td>
  <td class="right">{{ number_format($totalBrut, 0, ',', ' ') }}</td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td></td>
  <td></td><td></td>
  <td></td>
  <td></td><td></td><td></td>
</tr>

<!-- retenu-->
@php
$nbreGainsR = collect($salary_components)
    ->where('code', 'RETENUES')
    ->count();
@endphp
<tr>
  <td rowspan="{{ 9 + $nbreGainsR }}" class="sidebar-cellvertical"><strong><span class="vertical-text">{{ __('bulletin-de-paie.retenues') }}</span></strong></td>
  <td colspan="4" class="center"><strong>{{ __('bulletin-de-paie.charges_salariales') }}</strong></td>
  <td colspan="3" class="center"><strong>{{ __('bulletin-de-paie.charges_patronales') }}</strong></td>

</tr>
<tr>
  <td><strong>-{{ __('bulletin-de-paie.fiscales') }}</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.base') }}</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.coeff') }}.</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.Retenue') }}</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.base') }}</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.coeff') }}</strong></td>
  <td class=" center"><strong>{{ __('bulletin-de-paie.t_ch_patr') }}</strong></td>
</tr>

<!-- IRPP/RS -->
@foreach($salary_components->where('code', 'RETENUES')->where('type', 'FISCALES')->sortBy('order') as $component)
    <tr>
        <td class="lett">*{{ $component['name'] }}</td>
        <td class="right">{{ $component['base_amount'] }}</td>
        <td class="right">{{ $component['coef'] }}</td>
        <td class="right">{{ $component['base_amount'] * $component['coef'] }}</td>
        <td class="right">{{ $component['base_patronal'] }}</td>
        <td class="right">{{ $component['coef_patronal'] }}</td>
        <td class="right">{{ $component['base_patronal'] * $component['coef_patronal'] }}</td>
    </tr>
@endforeach
@php
$totalGainFiscale = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'FISCALES')
    ->sum(function($component){
        return $component['base_amount'] * $component['coef'];
    });
@endphp
@php
$totalGainpatronalFiscale = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'FISCALES')
    ->sum(function($component){
        return $component['base_patronal'] * $component['coef_patronal'];
    });
@endphp
<!-- Total charges fiscales -->
<tr class="total-fiscal">
  <td><strong>{{ __('bulletin-de-paie.total_charges_fiscale') }}</strong></td>
  <td></td><td></td>
  <td class="right">{{ number_format($totalGainFiscale, 0, ',', ' ') }}</td>
  <td></td><td></td>
  <td class="right">{{ number_format($totalGainpatronalFiscale, 0, ',', ' ') }}</td>
</tr>

<!-- LIGNE VIDE -->
<tr>
  <td></td>
  <td></td><td></td>
  <td></td>
  <td></td><td></td><td></td>
</tr>

<!-- -Sociales -->
<tr>
  <td><strong>-{{ __('bulletin-de-paie.sociales') }}</strong></td>
  <td></td><td></td><td></td><td></td><td></td><td></td>
</tr>
<!-- Vieillesse -->
@foreach($salary_components->where('code', 'RETENUES')->where('type', 'SOCIALES')->sortBy('order') as $component)
    <tr>
        <td class="lett">*{{ $component['name'] }}</td>
        <td class="right">{{ $component['base_amount'] }}</td>
        <td class="right">{{ $component['coef'] }}</td>
        <td class="right">{{ $component['base_amount'] * $component['coef'] }}</td>
        <td class="right">{{ $component['base_patronal'] }}</td>
        <td class="right">{{ $component['coef_patronal'] }}</td>
        <td class="right">{{ $component['base_patronal'] * $component['coef_patronal'] }}</td>
    </tr>
@endforeach
@php
$totalGainSociale = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'SOCIALES')
    ->sum(function($component){
        return $component['base_amount'] * $component['coef'];
    });
@endphp
@php
$totalGainpatronalSociale = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'SOCIALES')
    ->sum(function($component){
        return $component['base_patronal'] * $component['coef_patronal'];
    });
@endphp
<!-- Total charges sociales -->
<tr>
  <td><strong>{{ __('bulletin-de-paie.total_charges_sociales') }}</strong></td>
  <td></td><td></td>
  <td class="right"><strong>{{ number_format($totalGainSociale, 0, ',', ' ') }}</strong></td>
  <td></td><td></td>
  <td class="right"><strong>{{ number_format($totalGainpatronalSociale, 0, ',', ' ') }}</strong></td>
</tr>

<!-- LIGNE VIDE -->
<tr>
  <td></td>
  <td></td><td></td>
  <td></td>
  <td></td><td></td><td></td>
</tr>

<!-- Rembt-Avance -->
@foreach($salary_components->where('code', 'RETENUES')->where('type', 'AUTRES')->sortBy('order') as $component)
    <tr>
        <td class="lett">{{ $component['name'] }}</td>
        <td class="right">{{ $component['base_amount'] }}</td>
        <td class="right">{{ $component['coef'] }}</td>
        <td class="right">{{ $component['base_amount'] * $component['coef'] }}</td>
        <td class="right">{{ $component['base_patronal'] }}</td>
        <td class="right">{{ $component['coef_patronal'] }}</td>
        <td class="right">{{ $component['base_patronal'] * $component['coef_patronal'] }}</td>
    </tr>
@endforeach
@php
$totalGainAutre = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'AUTRES')
    ->sum(function($component){
        return $component['base_amount'] * $component['coef'];
    });
@endphp
@php
$totalGainpatronalAutre = collect($salary_components)
    ->where('code', 'RETENUES')
    ->where('type', 'AUTRES')
    ->sum(function($component){
        return $component['base_patronal'] * $component['coef_patronal'];
    });
@endphp
<!-- LIGNE VIDE -->

<!-- TOTAL RETENUES -->
  <!--SOMME fiscale + sociale + autre -->
  @php
    $totalretenuesalarial = $totalGainFiscale + $totalGainSociale + $totalGainAutre;
    $totalretenuepatronal = $totalGainpatronalFiscale + $totalGainpatronalSociale + $totalGainpatronalAutre;
  @endphp

<tr>
  <td><strong>{{ __('bulletin-de-paie.total_retenues') }}</strong></td>
  <td></td><td></td>
  <td class="right"><strong>{{ number_format($totalretenuesalarial, 0, ',', ' ') }}</strong></td>
  <td></td><td></td>
  <td class="right"><strong>{{ number_format($totalretenuepatronal, 0, ',', ' ') }}</strong></td>
</tr>
<!-- ─── LIGNE VIDE ─── -->
<tr>
  <td colspan="7" ></td>
</tr>

 @php
$autresGains = collect($salary_components)
    ->where('code', 'AUTRES GAINS');

$nbreGains = $autresGains->count();
@endphp

@if($nbreGains > 0)
   
        <tr>
            
                <td rowspan="{{ 1 + $nbreGains }}" class="sidebar-cell">
                    {{ __('bulletin-de-paie.autres_gains') }}
                </td>
                 @foreach($autresGains as $index => $component)
            <td>{{ $component['name'] }}</td>
            <td class="right">{{ $component['base_amount'] }}</td>
            <td class="right">{{ $component['coef'] }}</td>
            <td class="right">
                {{ $component['base_amount'] * $component['coef'] }}
            </td>
            

            <!-- On vide les colonnes patronales -->
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
@endif


@php
$totalAutre = collect($salary_components)
    ->where('code', 'AUTRES GAINS')
    ->sum(function($component){
        return $component['base_amount'] * $component['coef'];
    });
@endphp

<tr class="salaire-brut">
  <td><strong>{{ __('bulletin-de-paie.total_autres_gains') }}</strong></td>
  <td></td><td></td>
  <td class="right">{{ number_format($totalAutre, 0, ',', ' ') }}</td>
  <td></td><td></td><td></td>
</tr>
<tr>
  <td colspan="8"></td>
</tr>

<!-- ─── NET A PAYER ─── -->
 @php
    $netapayer = $totalBrut - $totalretenuesalarial + $totalAutre;
 @endphp
<tr class="net-payer-row">
  <td colspan="2"><strong>{{ __('bulletin-de-paie.salaire_net_a_payer') }}</strong></td>
  <td></td> <td></td> <td></td> <td></td> <td></td>
  <td style="text-align: right;"><strong>{{ number_format($netapayer, 0, ',', ' ') }}</strong></td>
</tr>

<!-- ─── NOTICE ─── -->
<tr class="notice">
  <td colspan="6">
    {{ __('bulletin-de-paie.texte_de_prevension') }}
  </td>
   <td></td> <td></td>
</tr>

<!-- ─── LIGNE VIDE ─── -->
<tr>
  <td></td><td></td> <td></td> <td></td> <td></td> <td></td><td></td> <td></td> 
</tr>

<!-- ─── RÉCAP EN-TÊTE ─── -->
<tr class="recap-h">
  <td style="color: #48841aff;"><strong>{{ __('bulletin-de-paie.salaire_brut') }}</strong></td>
  <td style="color: #48841aff;"><strong>{{ __('bulletin-de-paie.charges_salariale') }}</strong></td>
  <td><strong>{{ __('bulletin-de-paie.net_imposable') }}</strong></td>
  <td></td><td></td><td></td><td></td>
  <td><strong>{{ __('bulletin-de-paie.net_a_percevoir') }}</strong></td>
</tr>

<!-- ─── RÉCAP DONNÉES ─── -->
<tr class="recap-d">
  <td class="right"><strong>{{ number_format($totalBrut, 0, ',', ' ') }}</strong></td>
  <td class="right"><strong>{{ number_format($totalretenuesalarial, 0, ',', ' ') }}</strong></td>
  <td class="right"><strong>{{ number_format($totalBrut, 0, ',', ' ') }}</strong></td>
  <td></td><td></td><td></td><td></td>
  <td class="right"><strong>{{ number_format($netapayer, 0, ',', ' ') }}</strong></td>
</tr>

<!-- ─── LIGNE VIDE FINALE ─── -->
<tr >
 <td></td><td></td> <td></td> <td></td> <td></td> <td></td><td></td> <td></td> 
</tr>

</table>
<table style="width:100%; margin-top:1px; font-size:11pt; font-family:'Georgia',serif; font-style:italic; font-weight:bold;">
    <tr style="border:none;">
        <td style="text-align: left; width: 40%;font-size: 13px">
            <strong>{{ __('bulletin-de-paie.signature_employe') }}</strong><br>
             @if(file_exists(public_path("/public/profil/seal-signature-diretor.png")))
                <img style="width: auto; height: 80px; margin-right:10px; margin-top:-10px !important;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/seal-signature-director.png"))) }}">
            @endif

        </td>

        <td style="text-align: right; width: 40%;font-size: 13px">
            <strong>{{ __('bulletin-de-paie.signature_employeur') }}</strong><br>
             @if(file_exists(public_path("/public/profil/seal-signature-diretor.png")))
                <img style="width: auto; height: 80px; margin-right:10px; margin-top:-10px !important;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/seal-signature-director.png"))) }}">
            @endif
        </td>
    </tr>
</table>


</div><!-- /page -->
</body>
</html>