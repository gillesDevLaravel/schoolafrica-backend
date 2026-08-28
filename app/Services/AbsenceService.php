<?php

namespace App\Services;
use App\Models\Absence;
use App\Models\Course;

class AbsenceService
{
  public function getTotalAbsenceHoursByStudent(int $idStudent): float
  { 
    // 1. Récupérer les idCourse liés aux absences de l'élève
    $courseIds = Absence::where('idStudent', $idStudent)
        ->whereNotNull('idCourse')
        ->pluck('idCourse')
        ->unique();

    if ($courseIds->isEmpty()) {
        return 0;
    }

    // 2. Somme des durées (en minutes)
    $totalMinutes = Course::whereIn('id', $courseIds)
        ->sum('duration');

    // 3. Conversion en heures
    return round($totalMinutes / 60, 2);
  }
}