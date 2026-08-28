@php
    $nom = $eleve['nom'] ?? null;
    $matricule = $eleve['matricule'] ?? null;
    $dateNaissance = $eleve['dateNaiss'] ?? null;
    $lieuNaissance = $eleve['lieuNaiss'] ?? null;
    $country = $eleve['country'] ?? "Cameroun";
    $classeLabel = $eleve['nomClasse'] ?? null;
    $domaine = $eleve['domaine'] ?? 'Informatique';
    $grade = $eleve['grade'] ?? 'Licence';
    $campus = $eleve['campus'] ?? 'Yaoundé';
    $niveau = $eleve['niveau'] ?? 'III';
    $specialite = $eleve['specialite'] ?? 'Systèmes et Réseaux';
@endphp

<table style="width:100%; border-collapse:collapse; font-family: Arial, sans-serif; font-size:14pt; line-height:1.4; margin-bottom:10px;">
    {{-- Ligne 1: Domaine | Grade | Campus | Niveau --}}
    <tr>
        <td style="width:12%; font-size: 14px;"><strong>Domaine :</strong></td>
        <td style="width:23%; font-size: 14px;">{{ $domaine }}</td>
        <td style="width:12%; font-size: 14px;"><strong></strong></td>
        <td style="width:15%; font-size: 14px;"></td>
        <td style="width:12%; font-size: 14px;"><strong>Grade:</strong></td>
        <td style="width:15%; font-size: 14px;">{{ $grade }}</td>
        <td style="width:8%;  font-size: 14px;"><strong>Niveau: {{ $niveau }}</strong></td>
        <td style="width:3%;  font-size: 14px;"></td>
    </tr>

    {{-- Ligne 2: Spécialité | N° Matricule --}}
    <tr>
        <td style="font-size: 14px;"><strong>Spécialité:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $specialite }}</td>
        <td style="font-size: 14px;"><strong>N° Matricule:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $matricule ?? '-' }}</td>
    </tr>

    {{-- Ligne 3: Nom | Date de Naissance --}}
    <tr>
        <td style="font-size: 14px;"><strong>Nom (s):</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $nom ? mb_strtoupper($nom) : '-' }}</td>
        <td style="font-size: 14px;"><strong>Date de Naissance:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $dateNaissance ?? '-' }}</td>
    </tr>

    {{-- Ligne 4: Prénom | Lieu de Naissance --}}
    <tr>
        <td style="font-size: 14px;"><strong>Prénom (s):</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">Gilles Litvin</td>
        <td style="font-size: 14px;"><strong>Lieu de Naissance:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $lieuNaissance ?? '-' }}</td>
    </tr>

    {{-- Ligne 5: Pays Origine | Année Académique | Classe --}}
    <tr>
        <td style="padding: 3px; font-size: 14px;"><strong>Pays Origine:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $country }}</td>
        <td style="padding: 3px 0; font-size: 14px;"><strong>Année Académique:</strong></td>
        <td colspan="3" style=" font-size: 14px; padding: 3px 0;">{{ $academic_year }}</td>

    </tr>
</table>