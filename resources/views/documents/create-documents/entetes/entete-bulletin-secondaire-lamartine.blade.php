<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin Scolaire Annuel - Collège Lamartine</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.4; }
        .separation-line { border-top: 2px solid #000; margin: 10px 0; }
        .main-header { text-align: center; margin-bottom: 20px; }
        .student-info { display: flex; align-items: stretch; margin-bottom: 20px; }
        .student-photo-container {
            flex-shrink: 0;
            width: 200px; /* Largeur fixe pour la photo */
            height: 200px; /* Hauteur fixe pour rendre carré */
            margin-right: 20px;
        }
        .student-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 1px solid #000;
        }
        .student-table { flex: 1; border-collapse: collapse; }
        .student-table td { border: 1px solid #000; padding: 4px; vertical-align: top; }
        .student-table td:first-child { width: 70%; font-weight: bold; }
        .student-table td:last-child { width: 30%; }
        table.grades-table { border-collapse: collapse; width: 100%; margin-bottom: 20px; line-height: 1; }
        .grades-table thead { margin-bottom: 2px; }
        .grades-table tbody { margin-top: 2px; }
        .grades-table th, .grades-table td { border: 1px solid #000; padding: 1px 6px; text-align: center; font-size: 0.9em; line-height: 1; }
        .grades-table th { background-color: #f2f2f2; }
        .grades-table .subject-cell { text-align: left; vertical-align: top; padding: 1px 6px; line-height: 0.8; }
        .grades-table .subject-cell strong { display: block; margin-bottom: -2px; }
        .summary-table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        .summary-table th, .summary-table td { border: 1px solid #000; padding: 6px; text-align: center; vertical-align: top; }
        .summary-table th { background-color: #f2f2f2; }
        .appreciation { margin-bottom: 20px; }
        .conduite-table { width: 50%; float: left; border-collapse: collapse; }
        .conduite-table th, .conduite-table td { border: 1px solid #000; padding: 6px; text-align: center; }
        .conduite-table th { background-color: #f2f2f2; }
        .signature { margin-top: 40px; }
        .page-break { page-break-before: always; }
        sup { font-size: 0.8em; vertical-align: super; }
    </style>
</head>
<body>

<!-- Header Table -->
<table style="width: 100%; border-collapse: collapse; font-size: 9px; font-family: Arial, sans-serif;">
    <tr>
        <!-- Colonne 1 : Informations en français -->
        <td style="text-align: center; width: 35%; font-size: 9px; font-family: Arial, sans-serif;">
            RÉPUBLIQUE DU CAMEROUN<br>
            <strong><i>Paix - Travail - Patrie</i></strong><br>
            MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES<br>
            DÉLÉGATION RÉGIONALE DU LITTORAL<br>
            DÉLÉGATION DÉPARTEMENTALE DU WOURI<br>
            COLLÈGE LAMARTINE<br>
            BP. 11020 BONABÉRI, DOUALA<br>
            ANNEE SCOLAIRE {{ $academic_year }}<br>
        </td>

        <!-- Colonne 2 : Logo (largeur dynamique) -->
        <td style="text-align: center; width: auto; padding: 0;">
            @if(file_exists(public_path("/public/profil/{$ecole->logo}")))
                <img style="width: auto; height: 130px; margin-right:10px; margin-top:-10px !important;"
                     src="data:image/png;base64,{{ @base64_encode(file_get_contents(public_path("/public/profil/{$ecole->logo}"))) }}">
            @endif
        </td>

        <!-- Colonne 3 : Informations en anglais -->
        <td style="text-align: center; width: 35%; font-size: 9px; font-family: Arial, sans-serif;">
            REPUBLIC OF CAMEROON<br>
            <strong><i>Peace - Work - Fatherland</i></strong><br>
            MINISTRY OF SECONDARY EDUCATION<br>
            REGIONAL DELEGATION OF THE LITTORAL<br>
            DEPARTMENTAL DELEGATION OF THE WOURI<br>
            LAMARTINE COLLEGE<br>
            BP. 11020 BONABÉRI, DOUALA<br>
            SCHOOL YEAR {{ $academic_year }}<br>
        </td>
    </tr>
</table>
<div class="separation-line"></div>
