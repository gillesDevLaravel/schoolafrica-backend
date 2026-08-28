<?php

namespace App\Traits;

use App\Models\Fee;
use App\Models\FeeUser;
use App\Models\School;
use App\Models\User;
use function PHPUnit\Framework\isEmpty;

trait CheckIfRegistrationFeeIsPaidTrait{
    public function isRegistrationPaid($idStudent)
//    public function isRegistrationPaid($idSchool, $idStudent, $user_role, $idLevel)
    {
        $user = User::select('users.id as id','users.username as username','users.name as name','users.phone as phone','roles.id as role_id','roles.name as role','roles.description as role_description','users.adresse as adresse','users.photo as photo','users.idSchool as idSchool','users.idSection as idSection','users.idLevel as idLevel','users.idClasse as idClasse','users.idClasse as idClasse','users.idCycle as idCycle','roles.type as typeRole','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->join('schools','schools.id','=','users.idSchool')
            ->where('users.id', $idStudent)
            ->first();

        $registrationPaid = null; // par défaut

        if(is_null($user) || is_null($user->idSchool)){
            return null;
        }

        $school = School::find($user->idSchool);

        if($user->role == "Inscription"){
            // On vérifie s'il a terminé le paiement de l'inscription

            //Ancienne logique
//            $fee_user = FeeUser::join('fees', 'fees.id', '=', 'fee_user.idFee')
//                ->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
//                ->where(function($query) {
//                    $query->where('fees.order', '1')
//                        ->orWhere('fees.name', 'like', '%Inscription%');
//                })
//                ->where('fee_user.idSchool', $school->id)
//                ->where('fee_user.idStudent', $idStudent)
//                ->where('fee_has_level.level_id', $user->idLevel)
//                ->where('fee_user.solvable', 'terminé')
//                ->select('fee_user.solvable', 'fees.name')
//                ->first();
//            $registrationPaid = !is_null($fee_user);

            $fees = Fee::where('order', 1) // ou autre valeur d'ordre
            ->whereHas('levels', function ($query) use ($user) {
                $query->where('levels.id', $user->idLevel);
            })->get();

            if ($fees){
                $feeUsers = FeeUser::with(['fee', 'student']) // pour charger les relations
                ->where('idSchool', $school->id)
                    ->where('idStudent', $idStudent)
                    ->where('solvable', 'terminé')
                    ->whereHas('fee.levels', function ($query) use ($user) {
                        $query->where('levels.id', $user->idLevel);
                    })
                    ->get()->toArray();

                if ($feeUsers) {
                    $registrationPaid = true;
                }else{
                    $registrationPaid = false;
                }
            }
        }

        return $registrationPaid;
    }

    /**
     * Vérifie si l'étudiant a des frais obligatoires (required = true) non entièrement payés.
     * Retourne true si au moins un frais obligatoire n'est pas marqué comme solvable 'terminé' pour cet étudiant.
     */
    public function hasUnpaidRequiredFees($idStudent)
    {
        $user = User::find($idStudent);

        if (is_null($user) || is_null($user->idSchool) || is_null($user->idLevel)) {
            return false;
        }

        // Récupérer les frais requis pour l'école et le niveau de l'étudiant
        $requiredFees = Fee::where('required', true)
            ->where('idSchool', $user->idSchool)
            ->whereHas('levels', function ($query) use ($user) {
                $query->where('levels.id', $user->idLevel);
            })->get();

        if ($requiredFees->isEmpty()) {
            return false;
        }

        // Pour chaque frais requis, vérifier s'il existe un enregistrement fee_user avec solvable = 'terminé'
        foreach ($requiredFees as $fee) {
            $paid = FeeUser::where('idSchool', $user->idSchool)
                ->where('idStudent', $idStudent)
                ->where('idFee', $fee->id)
                ->where('solvable', 'terminé')
                ->exists();

            if (!$paid) {
                // Au moins un frais requis n'est pas payé
                return true;
            }
        }

        // Tous les frais requis sont payés
        return false;
    }
}
