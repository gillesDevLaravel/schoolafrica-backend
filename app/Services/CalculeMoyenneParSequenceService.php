<?php

namespace App\Services;

use App\Http\Resources\Staffs\AssessmentResource;
use App\Http\Resources\Staffs\AssessmentTypeResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Models\Rating;
use App\Models\AssessmentType;
use App\Models\User;

class CalculeMoyenneParSequenceService
{
    /**
     * Calcul moyenne séquentielle pour élève au secondaire
     *
     * @param array $request
     * @return array
     */
    public function calculMoyenneEtudiantSecondaire(array $request, array $students_list)
    {
        $ratingsOfStudent = Rating::select('ratings.id as id','ratings.value as value','ratings.observation as observation','ratings.idSchool as idSchool','ratings.idSection as idSection',
            'ratings.idClasse as idClasse','ratings.idTeacher as idTeacher','ratings.idMatter as idMatter','ratings.idCoeficient as idCoeficient','ratings.idAssessment as idAssessment',
            'ratings.idAssessmentType as idAssessmentType','ratings.idTypeEvaluation as idTypeEvaluation','ratings.notemax as notemax','coefficients.value as coeffValue')
            ->join('assessments','ratings.idAssessment','=','assessments.id')
            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
            ->join('coefficients','coefficients.id','=','ratings.idCoeficient')
            ->where('ratings.idSchool', $request['idSchool'])
            ->where('ratings.idStudent',$request['idStudent'])
            ->where('ratings.idAssessmentType',$request['idAssessmentType'])
            ->get();

        $totalNote = 0;
        $totalCoef = 0;

        foreach ($ratingsOfStudent as $rating){
            $totalCoef += $rating->coeffValue;
            $totalNote += $rating->value * $rating->coeffValue;
        }

        return [
            'moyenne' => $totalNote / $totalCoef,
            'assessmentType' => AssessmentTypeResource::make(AssessmentType::find($request['idAssessmentType'])),
            'student' => InscriptionSimpResource::make(User::find($request['idStudent']))
        ];
    }

    /**
     * Calcul moyenne pour élève de maternelle
     *
     * Sum(notes) / nombre de matiere
     * @param array $request
     * @return array
     */
    public function calculMoyenneEleveMaternelle(array $request, array $students_list)
    {
        $ratingsOfStudent = Rating::select('ratings.id as id','ratings.value as value','ratings.observation as observation','ratings.idSchool as idSchool','ratings.idSection as idSection',
            'ratings.idClasse as idClasse','ratings.idTeacher as idTeacher','ratings.idMatter as idMatter','ratings.idCoeficient as idCoeficient','ratings.idAssessment as idAssessment',
            'ratings.idAssessmentType as idAssessmentType','ratings.idTypeEvaluation as idTypeEvaluation','ratings.notemax as notemax','coefficients.value as coeffValue',
            'assessment_type.name as assessment_type_name')
            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
            ->join('coefficients','coefficients.id','=','ratings.idCoeficient')
            ->where('ratings.idSchool', $request['idSchool'])
            ->where('ratings.idStudent',$request['idStudent'])
            ->where('ratings.idAssessmentType',$request['idAssessmentType'])
            ->get();

        $moyenne = 0;
        $nbre = 0;

        foreach ($ratingsOfStudent as $rating){
            $moyenne += $rating->value;
            $nbre++;
        }

        return [
            'moyenne' => $moyenne / $nbre,
            'assessmentType' => AssessmentTypeResource::make(AssessmentType::find($request['idAssessmentType'])),
            'student' => InscriptionSimpResource::make(User::find($request['idStudent']))
        ];
    }

    /**
     * Calcul moyenne séquence pour élève au primaire
     *
     * (Sum(note de eleve) * 20 )/Sum(notemax des assessents)
     * @param array $request
     * @return array`
     */
    public function calculMoyenneElevePrimaire(array $request, array $students_list)
    {
        $moyennes = [];

        foreach ($students_list as $student){
            $ratingsOfStudent = Rating::select('ratings.id as id','ratings.value as value','ratings.observation as observation','ratings.idSchool as idSchool','ratings.idSection as idSection',
                'ratings.idClasse as idClasse','ratings.idTeacher as idTeacher','ratings.idMatter as idMatter','ratings.idCoeficient as idCoeficient','ratings.idAssessment as idAssessment',
                'ratings.idAssessmentType as idAssessmentType','ratings.idTypeEvaluation as idTypeEvaluation','ratings.notemax as notemax','coefficients.value as coeffValue',
                'assessment_type.name as assessment_type_name','assessments.notemax as notemax')
                ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                ->join('assessments','ratings.idAssessment','=','assessments.id')
                ->join('coefficients','coefficients.id','=','ratings.idCoeficient')
                ->where('ratings.idSchool', $request['idSchool'])
                ->where('ratings.idStudent',$student)
                ->where('ratings.idAssessmentType',$request['idAssessmentType'])
                ->get();

            $notes = 0;
            $notemax = 0;

            foreach ($ratingsOfStudent as $rating) {
                $notemax += $rating->notemax;
                $notes += $rating->value;
            }

            $moyennes[] = [
                'student' => $student,
                'moyenne' => ($notemax != 0) ? ($notes*20) / $notemax : 0,
            ];

            // si on arrive sur notre utilisateur, on garde sa moyenne à côté pour faciliter le return
            if($student == $request['idStudent']){
                $moyenneStudent = ($notemax != 0) ? ($notes*20) / $notemax : 0;
            }
        }

        return [
            'moyenne' => $moyenneStudent,
            'rang' => $this->getStudentRank($moyennes, $request['idStudent']),
            'assessmentType' => AssessmentTypeResource::make(AssessmentType::find($request['idAssessmentType'])),
            'student' => InscriptionSimpResource::make(User::find($request['idStudent']))
        ];
    }

    public function calculMoyenneEleveUniversitaire(array $request, array $students_list)
    {
        throw new \Exception("Moyenne étudiant de l'Université pas encore géré");
    }

    protected function getStudentRank($students, $studentId) {
        // Trier le tableau par moyenne dans l'ordre décroissant
        usort($students, function($a, $b) {
            return $b['moyenne'] - $a['moyenne'];
        });

        $rank = 1;
        foreach ($students as $student) {
            if ($student['student'] == $studentId) {
                return $rank;
            }
            $rank++;
        }

        // Si l'étudiant n'est pas trouvé dans le tableau, retourner -1
        return -1;
    }
}
