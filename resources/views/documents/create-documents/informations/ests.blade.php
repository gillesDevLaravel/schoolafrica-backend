@php
    $nom = $eleve['nom'] ?? null;
    $matricule = $eleve['matricule'] ?? null;
    $dateNaissance = $eleve['dateNaiss'] ?? null;
    $lieuNaissance = $eleve['lieuNaiss'] ?? null;
    $domaine = $eleve['domaine'] ?? 'Industrie & Technologie';
    $mention = $eleve['mention'] ?? null;
    $cycle = $eleve['cycle'] ?? 'Licence Professionnelle';
    $niveau = $eleve['niveau'] ?? 'NIVEAU 3';
    $specialite = $eleve['specialite'] ?? 'MÉCATRONIQUE INDUSTRIELLE';
    $anneeAcademique = $eleve['anneeAcademique'] ?? ($academic_year ?? '2024/2025');
    $registrationNumber = $eleve['registrationNumber'] ?? null;
    $numeroIdentification = $eleve['numeroIdentification'] ?? null;
    $specialisation = $eleve['specialisation'] ?? null;

@endphp

{{-- En-tête RELEVE DE NOTES --}}

<table style="width: 25%; border-collapse:collapse; margin-left:auto; margin-right:auto; margin-bottom:5px; ">
    <tr>
        <td style="background-color: #{{ $couleurs[0] ?? '5B9BD5' }}; color: #fff; text-align: center; padding: 5px; font-weight: bold; font-size: 16px; font-family: Arial, sans-serif;">
            RELEVE DE NOTES
        </td>
    </tr>
</table>

{{-- Informations élève - Layout 2 colonnes --}}
<table style="width:100%; border-collapse:collapse; font-family: Arial, sans-serif; font-size: 11px; line-height: 1.1;">
    <tr>
        {{-- Colonne gauche --}}
        <td style="width: 50%; vertical-align: top; padding-right: 20px;">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="font-size: 12px; width: 35%; font-weight: bold; padding: 2px 0;">Nom(s) & Prénom(s)<br>Name(s) & Surname(s)</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $nom ? mb_strtoupper($nom) : '-' }}</td>
                </tr>

                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Né(e) le<br>Birth on the</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $dateNaissance ?? '-' }} {{ $lieuNaissance ? 'à ' . $lieuNaissance : '' }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Domaine<br>Major</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $domaine }}</td>
                </tr>

                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Cycle<br>Degree</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $cycle }}</td>
                </tr>

                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Spécialité<br>Speciality</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $specialite }}</td>
                </tr>
            </table>
        </td>

        {{-- Colonne droite --}}
        <td style="font-size: 12px; width: 50%; vertical-align: top; padding-left: 20px;">
            <table style="font-size: 12px; width:100%; border-collapse:collapse;">
                <tr>
                    <td style="font-size: 12px; width: 40%; font-weight: bold; padding: 2px 0;" colspan="2">N°___________ /LSD/DFRE/TUR/UUR/2025-2026</td>
                </tr>
                <br>
                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Matricule<br>Registration No</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $registrationNumber ?? ($matricule ?? '-') }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Mention<br>Specialization</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $mention ?? 'GENIE MECANIQUE & PRODUITIQUE' }}</td>
                </tr>

                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Niveau<br>Level</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $niveau }}</td>
                </tr>
                <tr>
                    <td style="font-size: 12px; font-weight: bold; padding: 2px 0;">Année académique<br>Academic year</td>
                    <td style="font-size: 12px; padding: 2px 0;">: {{ $anneeAcademique }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

