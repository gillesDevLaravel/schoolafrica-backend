<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #FFFFFF;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            position: relative;
            width: 90vw;
            height: auto;
            aspect-ratio: 1262 / 892;
            z-index: -1;
        }
        .container p {
            position: absolute;
            margin: 0;
            padding: 0;
            white-space: nowrap;
        }

        .ft10 { font-size: 15px; font-family: Helvetica; color: #000000; }
        .ft11, .ft12 { font-size: 12px; font-family: Helvetica; color: #808080; }
        .ft13 { font-size: 2vw; font-family: Helvetica; color: #308743; }
        .ft14 { font-size: 1.3vw; font-family: Helvetica; color: #808080; }
        .ft15 { font-size: 1.3vw; font-family: Helvetica; color: #000000; }
        .ft17 { font-size: 1.8vw; font-family: Helvetica; color: #308743; }
        .ft18 { font-size: 1.3vw; font-family: Helvetica; color: #000000; }
        .ft19 { font-size: 1.3vw; font-family: Helvetica; color: #000000; }
        .ft20 { font-size: 14px; font-family: Helvetica; color: #000000; }
        .ft112, .ft114, .ft115 { font-size: 1.3vw; font-family: Courier; color: #000000; }
        .ft116 { font-size: 1.3vw; line-height: 1.5vw; font-family: Helvetica; color: #000000; }
        .ft117 { font-size: 2vw; line-height: 2.5vw; font-family: Helvetica; color: #000000; }
    </style>
</head>
<body>
@php
    $isBoy = !empty($gender) && strtoupper(substr($gender, 0, 1)) !== 'F';
@endphp

<?php if(file_exists(public_path("/public/profil/honour_roll_fr.png"))): ?>
<img style="position: absolute; width: auto; height: 100%; background: transparent;" src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path("/public/profil/honour_roll_fr.png")))); ?>" alt="Photo élève">
<?php else: ?>
<img style="position: absolute; width: auto; height: 100%; background: transparent;" src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path("/public/profil/honour_roll_fr.png")))); ?>" alt="Photo par défaut">
<?php endif; ?>


<div class="container">

    <div style="position: absolute; top:10%; left: 5%; width: 90%; text-align: center;">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center; width: 33%;">
                    <span class="ft10"><b>RÉPUBLIQUE DU CAMEROUN</b></span><br>
                    <span class="ft11"><i>Paix-Travail-Patrie</i></span><br>
                    <span class="ft12">**********</span><br>
                    <span class="ft12">Ministère de l'Education de Base</span><br>
                    <span class="ft12">Région du Centre</span><br>
                    @if($route === 'kingdom')
                        <span class="ft12">Département de Méfou-et-Akono</span>
                    @else
                        <span class="ft12">Département du Mfoundi</span>
                    @endif
                </td>

                <td style="width: 33%; text-align: center;">
                    @if(file_exists(public_path("/public/profil/{$ecole['logo']}")))
                        <img style="max-height: 120px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path("/public/profil/{$ecole['logo']}"))) }}">
                    @endif
                </td>

                <td style="text-align: center; width: 33%;">
                    <span class="ft10"><b>REPUBLIC OF CAMEROON</b></span><br>
                    <span class="ft11"><i>Peace-Work-Fatherland</i></span><br>
                    <span class="ft12">**********</span><br>
                    <span class="ft12">Ministry of Basic Education</span><br>
                    <span class="ft12">Center Region</span><br>
                    @if($route === 'kingdom')
                        <span class="ft12">Méfou-et-Akono Division</span>
                    @else
                        <span class="ft12">Mfoundi Division</span>
                    @endif
                </td>
            </tr>
        </table>

        <table style="text-align: center; width: 100%; margin-top: 10px;">
            <tr>
                <td style="color:#{{ $codeCouleur[0] }}; text-align: center; font-size: 18px;" class="ft13"><strong>{{ strtoupper($ecole['nom']) }}</strong></td>
            </tr>
        </table>
    </div>

    <p style="top:30%;left:49.7%;" class="ft14"><i>---</i></p>



    <p style="top:42.1%;left:15.7%;" class="ft15">
        Décerné, par la direction de l'école <b>"{{ strtoupper($ecole['nom']) }}"</b>
    </p>

    <?php if(!empty($photo) && file_exists(public_path("/public/profil/{$photo}"))): ?>
    <img style="position:absolute; top:45.5%;left:16%; width:110px; height:110px;" src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path("/public/profil/{$photo}")))); ?>" alt="Photo élève">
    <?php else: ?>
    <img style="position:absolute; top:45%; left:16%; width:110px; height:110px;" src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path("/public/profil/user.jpg")))); ?>" alt="Photo par défaut">
    <?php endif; ?>

    <p style="top:45%;left:26.6%;" class="ft17"><b><?php echo e($name ?? 'Nom Élève'); ?></b></p>
    <p style="top:47.5%;left:26.6%;" class="ft15">Matricule : <?php echo e($matricule ?? 'XXXXXX'); ?></p>
    <p style="top:50.5%;left:26.6%;" class="ft116">Née le : <b><?php echo e(\Carbon\Carbon::parse($birthday)->format('d F Y')); ?></b></p>
    <p style="top:53.5%;left:26.6%;" class="ft18">Sexe : <b style="color:red;"><?php echo e(strtoupper($gender ?? 'F')); ?></b></p>
    <p style="top:56.5%;left:26.6%;" class="ft15">Inscrite en classe de : <b><?php echo e($classe ?? 'Classe'); ?></b></p>

    <p style="top:47.2%;left:61.8%;" class="ft15">Moyenne:</p>
    <p style="top:47.2%;left:68.5%;" class="ft19"><b style="color: #008000;"><?php echo e(round($moyenne, 2) ?? '00.00'); ?></b> / 20</p>
    <p style="top:49.7%;left:61.8%;" class="ft15">Appréciation:</p>
    <p style="position:absolute; top:49.7%; left:70.5%; width:120px; font-size:15px; font-family:Helvetica; color:#000000; white-space:normal; word-wrap:break-word;">
        <b style="color:#008000;"><?php echo e(strtoupper($appreciation) ?? 'EXPERT'); ?></b>
    </p>

    <p style="top:60.8%;left:15.7%;" class="ft117">
        {{ $isBoy ? 'Il' : 'Elle' }}  s'est distinguée par son travail et sa conduite au cours<br/>
        @if($nom_trim)
            du <b>{{ $nom_trim }}</b>
        @endif
         de l'année scolaire 2024/2025.
    </p>

    <p style="top:68.3%;left:15.7%;" class="ft112">Fait à : <b>{{ mb_strtoupper($ecole['city']) . '-' . $ecole['adresse'] }}</b>, le: {{ date('d/m/Y') }}</p>
    <p style="top:68.3%;left:64.3%;" class="ft114"><i>DIRECTEUR</i></p>
    <p style="top:71%;left:59.6%;" class="ft115"><i><b>{{ strtoupper($ecole->principal->name) ?? '-' }}</b></i></p>

</div>
</body>
</html>
<?php /**PATH /home/mh-ibrah/PhpstormProjects/api_msschool_v7/resources/views/documents/honour-roll-en.blade.php ENDPATH**/ ?>
