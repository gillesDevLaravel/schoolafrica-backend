<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>8b56ab00-3231-43ce-b371-6adb340bdbbf</title>
    <meta name="author" content="BABAYAGA" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }
        .s1 {
            color: #131313;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }
        .s2 {
            color: black;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 1pt;
        }
        .s3 {
            color: #131313;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 20pt;
        }
        p {
            color: #131313;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt;
            margin: 0pt;
        }
        /* Ajout signatures comme abiscoms */
        .signature-block {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: -20px;
            position: relative; /* important pour contenir les images absolues */
        }
        .signature-block img {
            height: 150px;
            object-fit: contain;
            position: absolute;
            right: 0;
            transform: translateY(-80px);
        }
        .signature-block img + img { /* si plusieurs images */
            margin-left: -60px;
            bottom: -10px;
        }
    </style>
</head>
<body>

<table class="s1" style="width: 100%;">
    <tr style="">
        <td style="width: 40%; padding-top: 10pt; padding-left: -80px; text-align: center;">
            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">MINISTERE DE L&#39;EDUCATION DE BASE</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">DELEGATION REGIONALE DU CENTRE</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">DELEGATION DEPARTEMENTALE DU MFOUNDI</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">INSPECTION D&#39;ARRONDISSEMENT DE YAOUNDÉ IV</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">REPUBLIQUE DU CAMEROUN</p>
            <p class="s1" style="padding-top: 3pt; padding-left: -15pt; text-indent: 0pt;">Paix - Travail - Patrie</p>
        </td>

        <td style="width: 20%; text-align: center;">
            <img style="width: 100%; margin-right: 10px;" src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/$school_logo"))) }}">
        </td>

        <td style="width: 40%; padding-top: 3pt; text-align: center;">
            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">MINISTRY OF BASIC EDUCATION</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">CENTRAL REGIONAL DELEGATION</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">MFOUNDI DEPARTMENTAL DELEGATION</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">YAOUNDÉ IV DISTRICT INSPECTION</p>
            <div style="text-align: center;">-------------</div>

            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">REPUBLIC OF CAMEROUN</p>
            <p class="s1" style="padding-top: 3pt; text-indent: 0pt;">Peace - Work - Fatherland</p>
        </td>
    </tr>
</table>

<p class="s3" style="padding-top: 40pt; padding-left: 57pt; text-indent: 0pt; text-align: center;">CERTIFICAT DE SCOLARITÉ</p>
<p style="padding-top: 3pt; padding-left: 57pt; text-indent: 0pt; text-align: center;">Année scolaire 2024 - 2025</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>

<p style="padding-top: 30pt; padding-left: 56pt; text-indent: 0pt; text-align: left;">Je soussigné M. ...........................................................................</p>
<p style="padding-top: 13pt; padding-left: 23pt; text-indent: 0pt; text-align: left;">Directeur de l'institut universitaire ms-school ................................................................................</p>

<br><br>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<p style="padding-left: 56pt; text-indent: 0pt; text-align: left;">Certifie que l&#39;élève {{ $nom }}</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<p style="padding-left: 23pt; text-indent: 0pt; text-align: left;">né(e) le {{ $dateNaissance }} à {{ $lieuNaissance }}</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<p style="padding-left: 23pt; text-indent: 0pt; text-align: left;">fils ou fille de {{ $nomParent1 }} et de {{ $nomParent2 }}</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>
<p style="padding-left: 23pt; text-indent: 0pt; text-align: left;">est inscrit dans mon étblissement sous le matricule n° {{ $matricule }}</p>
<p style="padding-top: 13pt; padding-left: 23pt; text-indent: 0pt; text-align: left;">il suit actuellement le programme de {{ $cursusEtudiant }}</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>

<p style="padding-top: 50pt; padding-left: 57pt; text-indent: 0pt; text-align: center;">Cette pièce est délivrée pour servir et valoir ce que de droit.</p>
<p style="text-indent: 0pt; text-align: left;"><br /></p>

<p class="s3" style="padding-top: 50pt; padding-right: 57pt; text-indent: 0pt; text-align: right;">LE DIRECTEUR</p>

<!-- Bloc signatures superposées à droite (même logique que abiscoms) -->
<div class="signature-block">
    @if(file_exists(public_path('public/profil/seal-signature-director.png')))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('public/profil/seal-signature-director.png'))) }}" alt="Signature">
    @endif
</div>
</body>
</html>
