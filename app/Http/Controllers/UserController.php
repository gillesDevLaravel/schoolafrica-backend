<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bulletins\BulletinPrimaireController;
use App\Http\Controllers\Bulletins\BulletinSecondaireController;
use App\Http\Requests\Admin\FinanceDetailsFounderPerTrancheRequest;
use App\Http\Requests\Admin\FinanceDetailsFounderRequest;
use App\Http\Requests\Admin\SwitchUsersClasseRequest;
use App\Http\Requests\AfficherNotesPrimaireRequest;
use App\Http\Requests\AnnualDecisionRequest;
use App\Http\Requests\StudentSolvencyRequest;
use App\Http\Requests\Admin\SwitchUsersClasseSecondaireRequest;
use App\Http\Requests\UpdateDeviceTokenRequest;
use App\Http\Requests\User\UserPaymentRequest;
use App\Http\Requests\UsersStudentRequest;
use App\Http\Requests\UserDeleteBulkRequest;
use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Http\Resources\StudentSolvability\ClassResource;
use App\Http\Resources\StudentSolvability\StudentResource;
use App\Models\AnnualDecision;
use App\Models\Bourse;
use App\Models\Establishment;
use App\Models\FeeHasLevel;
use App\Models\MobileBuildVersion;
use App\Models\Section;
use App\Models\Tranche;
use App\Services\PensionUserService;
use App\Traits\CheckIfRegistrationFeeIsPaidTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\Admin\UserAllResource;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\DashFounderRequest;
use App\Http\Requests\Admin\UserPasswordRequest;
use App\Http\Requests\Staffs\DashParentRequest;
use App\Http\Requests\Staffs\DashTeacherRequest;
use App\Http\Resources\Admin\FounderResource;
use App\Http\Resources\Admin\UserLoginGetResource;
use App\Http\Resources\Admin\StudentGroupedResource;
use App\Http\Resources\Staffs\InscriptionResource;
use App\Http\Resources\Staffs\ParentResource;
use App\Http\Resources\Staffs\PreinscriptionResource;
use App\Http\Resources\Staffs\StaffResource;
use App\Http\Resources\Staffs\TeacherResource;
use App\Models\Absence;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Event;
use App\Models\Fee;
use App\Models\FeeUser;
use App\Models\Homework;
use App\Models\Level;
use App\Models\Matter;
use App\Models\Requete;
use App\Models\ScanReceipt;
use App\Models\Suggestion;
use App\Models\TransportUser;
use App\Models\TeacherObservation;
use App\Models\SchoolDelay;
use App\Models\Pension;
use App\Models\PensionUser;
use App\Models\Rating;
use App\Models\Sanction;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\Withdrawal;

/**
 * @group Users
 */
class UserController extends BaseController
{
    /**
     * Lister les utilisateurs
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection|Response|void
     */

    use CheckIfRegistrationFeeIsPaidTrait;

    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'];
            $idSection = $request['idSection'];
            $idRole = $request['idRole'];
            $idParent = $request['idParent'];
            $idLevel = $request['idLevel'];
            $idClasse = $request['idClasse'];
            $idClasse2 = $request['idClasse2'];
            $typeRole = $request['typeRole'];
            $idBourse = $request['idBourse'];
            $hasBourse = $request['hasBourse'];
            $ordre = $request['ordre'];
            $deleted = $request['deleted'] ?? false;
            $filter_value = $request['filter_value'];

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            if(!is_null($typeRole)){
                $users = User::select('users.id as id')
                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereIn('roles.type', $typeRole)
                    ->where('users.deleted',0);

                if(!is_null($idSchool)) $users = $users->where('users.idSchool', $idSchool);
                if(!is_null($idSection)) $users = $users->where('users.idSection', $idSection);

                if(!is_null($filter_value)){
                    $users->where(function($query) use ($filter_value) {
                        $query->where('users.name', 'like', "%$filter_value%")
                            ->orWhere('users.username', 'like', "%$filter_value%")
                            ->orWhere('users.matricule', 'like', "%$filter_value%")
                            ->orWhere('users.gender', 'like', "%$filter_value%")
                            ->orWhere('users.phone', 'like', "%$filter_value%")
                            ->orWhere('users.phone_2', 'like', "%$filter_value%")
                            ->orWhere('users.phone_3', 'like', "%$filter_value%")
                            ->orWhere('roles.description', 'like', "%$filter_value%");
                    });
                }

                $users_ids = $users->pluck('id')->toArray();


                $users3 = [];
                if(!is_null($idRole)){
                    $users3 = User::select('users.id as id')
                        ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('roles.id', $idRole);

                    if(!is_null($idSchool)) $users3 = $users3->where('users.idSchool', $idSchool);


                    $users3 = $users3->pluck('id')
                        ->toArray();
                }

                $users = array_merge($users_ids, $users3);

                $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.whatsapp_number as whatsapp_number', 'users.cat as cat', 'users.ech as ech', 'users.hiring_date as hiring_date', 'users.niu as niu')
                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->orderBy("users.name")
                    ->whereIn('users.id', $users);

                return StaffResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
            }

//            if(is_null($idRole)){
//                $this->validate($request, [
//                    'typeRole' => ['required', 'exists:roles,type']
//                ]);
//
//                $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.whatsapp_number as whatsapp_number')
//                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
//                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
//                    ->where('roles.type', $typeRole)
//                    ->where('users.deleted',0)
//                    ->orderBy("users.name");
//
//                if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
//                if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
//                if(!is_null($idSection)) $users->where('users.idSchool', $idSection);
//
//                if(!is_null($filter_value)){
//                    $users->where(function($query) use ($filter_value) {
//                        $query->where('users.name', 'like', "%$filter_value%")
//                            ->orWhere('users.gender', 'like', "%$filter_value%")
//                            ->orWhere('roles.name', 'like', "%$filter_value%");
//                    });
//                }
//
//                return StaffResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
//            }
            if(!is_null($idRole)){
                switch ($idRole) {
                    case 2:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.whatsapp_number as whatsapp_number','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->where('roles.id',2)
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        if(!is_null($idSchool)) $users = $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users = $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.matricule', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%");
                            });
                        }

                        return FounderResource::collection($users->simplePaginate($nbreItems, ['*'], 'page', $pageItems));
                        break;

                    case 3:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle', 'signature', 'users.cat', 'users.num_cnps','users.ech', 'users.hiring_date', 'users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->where('roles.id', 3);

                        if(!is_null($idSchool)) $users = $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users = $users->where('users.idSection', $idSchool);
                        if(!is_null($idParent)) $users = $users->where('users.idParent', $idSchool);

                        $users = $users->where('users.deleted',0)
                            ->orderBy("users.name")
                            ->get();

                        return StaffResource::collection($users);
                        break;

                    case 5:
                        $users =  User::select('users.id as id','users.grade as grade','users.anciennete as anciennete','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number','users.idClassePrincipal as idClassePrincipal', 'signature', 'users.cat', 'users.ech', 'users.hiring_date', 'users.num_cnps', 'users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
//                            ->join('matter','matter.id','=','users.idMatter')
                            ->where('roles.id',5)
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.matricule', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%");
//                                    ->orWhere('matter.name', 'like', "%$filter_value%");
                            });
                        }

                        return TeacherResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
                        break;

                    case 7:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number',
                            'users.mother as mother','users.tutor as tutor','users.phone_2 as phone_2','users.phone_3 as phone_3','users.phone_4 as phone_4','users.phone_5 as phone_5','users.phone_6 as phone_6','users.adresse_2','users.adresse_tutor','users.gender_2','users.gender_tutor','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
                            ->where('roles.id',7)
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        // Si il y'a idClasse, ça veut dire qu'il veut les parents dont les enfants sont dans cette classe là
                        if(!is_null($idClasse)) {
                            $parentsID = User::where(['deleted' => 0, 'idClasse' => $idClasse])
                                ->pluck('idParent')
                                ->toArray();

                            $users = $users->whereIn('users.id', $parentsID);
                        }

                        if(!is_null($idSchool)) $users = $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.matricule', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%");
                            });
                        }

                        return ParentResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
                        break;

                    case 8:
                        $users = User::select('users.id as id','users.scholar_type as scholar_type', 'users.idBourse as idBourse','users.isBourseUsed as isBourseUsed','users.name as name','users.phone as phone','users.nationality as nationality','users.codeun as codeun',
                            'users.codedeux as codedeux','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password',
                            'users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by',
                            'users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel',
                            'roles.id as idRole',
                            'users.repeater as repeater','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.idClasse2 as idClasse2','users.old_classe as old_classe','users.firstname as firstname','users.placeofbirth as placeofbirth','users.situation as situation',
                            'users.repeater as repeater','users.matricule as matricule','users.phone as phone','schools.scholar_level as scholar_level', 'classes.name as classe_name','users.whatsapp_number as whatsapp_number',
                            'users.annualDecision','users.deleted','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
                            ->join('classes', 'classes.id', "=", "users.idClasse")
//                            ->join('option_level','option_level.id','=','users.idOptionLevel')
                            ->where('roles.id',$request['idRole'])
                            ->where('users.deleted', $deleted);

                        if ($deleted){
                            $users->withoutGlobalScope('isDeleted');
                        }

                        //TODO #08/10/2024: Si dans le payload il y'a idClasse, on ne gère pas idSchool et idSection
                        if(!is_null($idClasse)){
                            $users->where('users.idClasse', $idClasse);
                        }
                        else{
                            if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
                            if(!is_null($idSection)) $users->where('users.idSection', $idSection);
                        }
                        if (!is_null($idLevel)) {
                            $users->where('classes.idLevel', $idLevel);
                        }
                        //filtre situation
                        if(!is_null($request['situation'])){
                            $users->where('users.situation', $request['situation']);
                        }
                        //filtre repeater
                        if(!is_null($request['repeater'])){
                            $users->where('users.repeater', $request['repeater']);
                        }
                        if(!is_null($idParent)) $users->where('users.idParent', $idParent);
                        if(!is_null($idClasse2)) $users->where('users.idClasse2', $idClasse2);
                        if (!is_null($idBourse)) $users->where('users.idBourse', $idBourse);
                        if ($hasBourse === true) $users->whereNotNull('users.idBourse');
                        elseif ($hasBourse === false) $users->whereNull('users.idBourse');

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.matricule', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%")
                                    ->orWhere('classes.name', "like", "%$filter_value%");
                            })
                            ->orwhereHas('optionLevel', function($q) use ($filter_value) {
                                $q->where('name', 'like', "%$filter_value%");
                            });
                        }

                        if($request['hasBourse']){
                            $montantTotalBourses = 0;

                            foreach ($users->orderBy("users.name")->get() as $boursier){
                                $montantTotalBourses += Bourse::find($boursier->idBourse)->amount;
                            }
                        }


                        //NOUVEAU SYSTEME DE FILTRE POUR POUVOIR RAJOUTER UN CHAMP
                        $paginated = $users->orderBy("users.name")->paginate($nbreItems, ['*'], 'page', $pageItems);

                        $enriched = $paginated->getCollection()->map(function ($user) {
                            $user->registrationPaid = $this->isRegistrationPaid($user->id);
                            $user->fees_required = $this->hasUnpaidRequiredFees($user->id);
                            return $user;
                        });

                        if (isset($request['registrationPaid']) && is_bool($request['registrationPaid'])) {
                            $filtered = $enriched->filter(function ($user) use ($request) {
                                return $user->registrationPaid === $request['registrationPaid'];
                            })->values(); // réindexe les clés
                        } else {
                            $filtered = $enriched;
                        }
                        $paginated->setCollection($filtered);

                        $students = InscriptionResource::collection($paginated);


//                        $students = InscriptionResource::collection($users->orderBy("users.name")->paginate($nbreItems, ['*'], 'page', $pageItems));

                        return response()->json([
                            'montantTotalBourses' => $montantTotalBourses ?? 0,
                            'data' => $students->items(),
                            'meta' => [
                                'current_page' => $students->currentPage(),
                                'from' => $students->firstItem(),
                                'to' => $students->lastItem(),
                                'per_page' => $students->perPage(),
                                'total' => $students->total(),
                                'last_page' => $students->lastPage(),
                            ],
                        ]);
                        break;

                    case 13:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number', 'users.cat', 'users.ech', 'users.hiring_date','users.num_cnps','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
                            ->where('roles.id',$request['idRole'])
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%");
                            });
                        }

                        return StaffResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
                        break;

                    case 14:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number', 'users.cat', 'users.ech', 'users.hiring_date','users.num_cnps','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
                            ->where('roles.id',$request['idRole'])
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%");
                            });
                        }

                        return StaffResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
                        break;
                    default:
                        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number', 'users.cat', 'users.ech', 'users.hiring_date','users.num_cnps','users.niu as niu')
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->join('schools','schools.id','=','users.idSchool')
                            ->where('roles.id',$request['idRole'])
                            ->where('users.deleted',0)
                            ->orderBy("users.name");

                        if(!is_null($idSchool)) $users->where('users.idSchool', $idSchool);
                        if(!is_null($idSection)) $users->where('users.idSection', $idSection);

                        if(!is_null($filter_value)){
                            $users->where(function($query) use ($filter_value) {
                                $query->where('users.name', 'like', "%$filter_value%")
                                    ->orWhere('users.username', 'like', "%$filter_value%")
                                    ->orWhere('users.phone', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_2', 'like', "%$filter_value%")
                                    ->orWhere('users.phone_3', 'like', "%$filter_value%")
                                    ->orWhere('users.gender', 'like', "%$filter_value%");
                            });
                        }

                        return StaffResource::collection($users->paginate($nbreItems, ['*'], 'page', $pageItems));
                        break;
                }
            }

        }
        catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'un utilisateur
     *
     * @param User $user
     * @param $id
     * @return UserAllResource|Response
     */
    public function show(User $user,$id)
    {
        try {
            $user = User::find($id);
            $user->build_number = MobileBuildVersion::orderBy('id', 'desc')->first()->build_number;
            return new UserAllResource($user);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un utilisateur
     *
     * @param Request $request
     * @param $id
     * @return UserAllResource|Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Vérifier si l'élève a des enregistrements dans la table pension
            $hasPension = PensionUser::where('idStudent', $user->id)->exists();

            if ($hasPension) {

                if (isset($request['idClasse']) && $request['idClasse'] != $user->idClasse) {

            // Récupérer la nouvelle classe
               $newClasse = Classes::find($request['idClasse']);

                  if (!$newClasse) {
                   return $this->sendError("Classe invalide.", null, 404);
                  }

                  // Vérifier si le niveau change réellement
                  if ($newClasse->idLevel != $user->idLevel) {
                      return $this->sendError("Impossible de modifier vers une classe d'un niveau différent pour un élève ayant déjà des pensions.",null,403);
                  }
              }
          }

            //Ne considerer que l'idSchool, idSection, idClasse de la classe de l'eleve
            if ($user->idClasse){
                if (!is_null($request['idSchool'])){
                    $request['idSchool'] = $user->classe->idSchool;
                }

                if (!is_null($request['idSection'])){
                    $request['idSection'] = $user->classe->idSection;
                }


                if (!is_null($request['idLevel'])){
                    $request['idLevel'] = $user->classe->idLevel;
                }
            }



            $user->name = $request['name'] ?? $user['name'];
            $user->firstname = $request['firstname'] ?? $user['firstname'];
            $user->placeofbirth = $request['placeofbirth'] ?? $user['placeofbirth'];
            $user->situation = $request['situation'] ?? $user['situation'];
            $user->repeater = $request['repeater'] ?? $user['repeater'];
            $user->cni = $request['cni'] ?? $user['cni'];
            $user->email = $request['email'] ?? $user['email'];
            $user->whatsapp_number = $request['whatsapp_number'] ?? $user['whatsapp_number'];

            /* switch ($user->photo) {
                case null:
                    $user->photo = Storage::disk('local')->put('avatars', $request->file('photo')) ?? null;
                    break;

                default:
                    if(Storage::disk('local')->exists($user->photo) != true){
                        Storage::delete($user->photo);
                        $user->photo = Storage::disk('local')->put('avatars', $request->file('photo')) ?? null;
                    }
                    break;
            } */

            $user->photo = $request['photo'] ?? $user['photo'];
            $user->signature = $request['signature'] ?? $user['signature'];
            $user->profession = $request['profession'] ?? $user['profession'];
            $user->bank_name = $request['bank_name'] ?? $user['bank_name'];
            $user->bank_rib = $request['bank_rib'] ?? $user['bank_rib'];
//            $user->number_days_off = $request['number_days_off'] ?? $user['number_days_off'];
            $user->password = !is_null($request['password']) ? bcrypt($request['password']) : $user['password'];
            $user->username = $request['username'] ?? $user['username'];
            $user->phone = $request['phone'] ?? $user['phone'];
            $user->adresse = $request['adresse'] ?? $user['adresse'];
            $user->nationality = $request['nationality'] ?? $user['nationality'];
            $user->mother = $request['mother'] ?? $user['mother'];
            $user->tutor = $request['tutor'] ?? $user['tutor'];
            $user->phone_2 = $request['phone_2'] ?? $user['phone_2'];
            $user->phone_3 = $request['phone_3'] ?? $user['phone_3'];
            $user->phone_4 = $request['phone_4'] ?? $user['phone_4'];
            $user->phone_5 = $request['phone_5'] ?? $user['phone_5'];
            $user->phone_6 = $request['phone_6'] ?? $user['phone_6'];
            $user->observation = $request['observation'] ?? $user['observation'];
            $user->gender = $request['gender'] ?? $user['gender'];
            $user->adresse_2 = $request['adresse_2'] ?? $user['adresse_2'];
            $user->adresse_tutor = $request['adresse_tutor'] ?? $user['adresse_tutor'];
            $user->gender_2 = $request['gender_2'] ?? $user['gender_2'];
            $user->gender_tutor = $request['gender_tutor'] ?? $user['gender_tutor'];
            $user->birthday = $request['birthday'] ?? $user['birthday'];
            $user->city = $request['city'] ?? $user['city'];
            $user->fit = $request['fit'] ?? $user['fit'];
            $user->desease = $request['desease'] ?? $user['desease'];
            $user->matricule = $request['matricule'] ?? $user['matricule'];
            $user->country = $request['country'] ?? $user['country'];
//            $user->idCampus = $request['idCampus'] ?? $user['idCampus'];
            $user->salary = $request['salary'] ?? $user['salary'];
            $user->hourlyPrice = $request['hourlyPrice'] ?? $user['hourlyPrice'];
            $user->grade = $request['grade'] ?? $user['grade'];
            $user->anciennete = $request['anciennete'] ?? $user['anciennete'];
            $user->num_cnps = $request['num_cnps'] ?? $user['num_cnps'];
            $user->cat = $request['cat'] ?? $user['cat'];
            $user->ech = $request['ech'] ?? $user['ech'];
            $user->hiring_date = $request['hiring_date'] ?? $user['hiring_date'];
            $user->niu = $request['niu'] ?? $user['niu'];
            $user->agence = $request['agence'] ?? $user['agence'];
            $user->service = $request['service'] ?? $user['service'];
            $user->categorie = $request['categorie'] ?? $user['categorie'];
            $user->num_dipe = $request['num_dipe'] ?? $user['num_dipe'];
            $user->date_embauche = $request['date_embauche'] ?? $user['date_embauche'];
            $user->idMatter = $request['idMatter'] ?? $user['idMatter'];
            $user->idParent = $request['idParent'] ?? $user['idParent'];
//            $user->idLevel = $request['idLevel'] ?? $user['idLevel']; // ceci sera modifié dans User::setIdClasseAttribute
            $user->idCycle = $request['idCycle'] ?? $user['idCycle'];
            $user->idClasse = $request['idClasse'] ?? $user['idClasse'];
            $user->idClasse2 = $request['idClasse2'] ?? $user['idClasse2'];
           /// $user->all_classe = $request['all_classe'] ?? $user['all_classe'];
            $user->old_classe = $request['old_classe'] ?? $user['old_classe'];
            $user->idClassePrincipal = $request['idClassePrincipal'] ?? $user['idClassePrincipal'];
            $user->idOptionLevel = $request['idOptionLevel'] ?? $user['idOptionLevel'];
            $user->idSchool = $request['idSchool'] ?? $user['idSchool'];
            $user->idSection = $request['idSection'] ?? $user['idSection'];
            $user->idBourse = $request['idBourse'] ?? $user['idBourse'];

            $user->codeun = $request['codeun'] ?? $user['codeun'];
            $user->codedeux = $request['codedeux'] ?? $user['codedeux'];
//            $user->gender = $request['gender'] ?? $user['gender'];
//            $user->adresse = $request['adresse'] ?? $user['adresse'];
            $user->updated_by = auth()->user()->id;

            $user->save();
            if(!empty($request['role'])){
                $user->syncRoles($request['role']);

                if($request['role'] == 8){
                    $classe = Classes::find($request['idClasse']);

                    $user->idSchool = $classe->idSchool;
                    $user->idSection = $classe->idSection;
                    $user->idLevel = $classe->idLevel;
                }
            }
            if(!empty($request['matter'])){
                $user->matters()->sync($request['matter']);
            }else{
                $user->matters()->sync([]);
            }
            if(!empty($request['classes'])){
                $user->classes()->sync($request['classes']);
            }else{
                $user->classes()->sync([]);
            }
            return new UserAllResource($user);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj du mot de passe d'un utilisateur
     *
     * @param UserPasswordRequest $request
     * @return Response
     */
    public function updatepassword(UserPasswordRequest $request)
    {
        try {

            $user = $request->validated();
            $user = User::find(auth()->user()->id);

            if (Hash::check($request->input('current_password'), $user->password)) {

                $user->password = bcrypt($request->input('new_password'));
                $user->save();
                Auth::user()->currentAccessToken()->delete();

                return $this->sendResponse('success', 'Mot de passe mis à jour avec succès, veuillez vous reconnecter');
            }else{
                return $this->sendError('Error', 'Mot de passe actuel incorrect');
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(User $user,$id)
    {
        try {
            $user = User::findOrFail($id);
            $role = $user->getRoleNames();

            foreach ($role as $key => $value) {
                switch ($value) {
                    case 'Teacher':
                        $courses = Course::where('idTeacher',$id)->get();
                        if(count($courses) != 0){
                            return $this->sendError('impossible, cours existant');
                        }else{
                            $user->tokens()->delete();
                            $user->syncRoles([]);
                            $user->matters()->sync([]);
                            $user->classes()->sync([]);

//                            $user->delete();
                            $user->update([
                                'deleted' => true,
                                'deleted_by' => auth()->user()->id,
                            ]);

                            return $this->sendResponses(null);
                        }
                        break;
                    case 'Inscription':
                        $studentPensions = PensionUser::where('idStudent',$id)
                                          ->first();

                        if(!empty($studentPensions)){
                            return $this->sendError('impossible, paiement pension existant');
                        }else{
                            $user->tokens()->delete();
                            $user->syncRoles([]);
                            $user->matters()->sync([]);
                            $user->classes()->sync([]);

//                            $user->delete();
                            $user->update([
                                'deleted' => true,
                                'deleted_by' => auth()->user()->id,
                            ]);
                            return $this->sendResponses(null);
                        }
                        break;
                    case 'Staff':
                        $task = Task::where('idUser',$id)->get();
                        if(count($task) != 0){
                            return $this->sendError('impossible, tache affecte à l\'utilisateur');
                        }else{
                            $user->tokens()->delete();
                            $user->syncRoles([]);
                            $user->matters()->sync([]);
                            $user->classes()->sync([]);

//                            $user->delete();
                            $user->update([
                                'deleted' => true,
                                'deleted_by' => auth()->user()->id,
                            ]);

                            return $this->sendResponses(null);
                        }

                        break;

                    default:
                        $user->tokens()->delete();
                        $user->syncRoles([]);
                        $user->matters()->sync([]);
                        $user->classes()->sync([]);

//                        $user->delete();
                        $user->update([
                            'deleted' => true,
                            'deleted_by' => auth()->user()->id,
                        ]);

                        return $this->sendResponses(null);
                        break;
                }
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function transferDataUser(Request $request)
    {
        try {

            if(!empty($request['idTeacher']) && !empty($request['idUser'])){
                DB::beginTransaction();
                $teacherInitial = User::find($request['idTeacher']);
                $teacherFinal = User::find($request['idUser']);

                if($teacherFinal && $teacherInitial){
                    if($teacherInitial['idMatter'] == $teacherFinal['idMatter']){
                        $teacherFinal->classes()->syncWithoutDetaching($teacherInitial->classes->pluck('id'));
                        $nombreLigneUpdate = Rating::where('idTeacher',$request['idTeacher'])
                                ->update(['idTeacher' => $request['idUser']]);

                        if($nombreLigneUpdate > 0){
                            $teacherInitial->classes()->sync([]);
                            DB::commit();
                            return $this->sendResponses("Transfert de classe et note réussie");
                        }else{
                            DB::rollBack();
                            return $this->sendError("Absence de notes, aucune données tranférées");
                        }
                    }else{
                        return $this->sendError("Les enseignants ne dispensent pas la même matière");
                    }

                }

            }else{
                return $this->sendError("Veuillez fournir idTeacher et idUser");
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }

    /**
     * Archiver un utilisateur
     *
     * @param Request $request
     * @param $id
     * @return UserAllResource|Response
     */
    public function archive(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->deleted = $request['archive'];

            $user->save();

            return new UserAllResource($user);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
    * Restaurer en bulk des utilisateurs (désarchiver)
    *
    * @param Request $request
    * @param array $ids
    * @return \Illuminate\Http\JsonResponse
    */
    public function restoreBulk(Request $request)
    {
        try {
            $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id'
        ]);

         User::withoutGlobalScope('isDeleted')->whereIn('id', $request->ids)
         ->update([
          'deleted' => 0,
           'deleted_by' => null,
      ]);


      Log::info('Utilisateurs restaurés', ['ids' => $request->ids]);

      return $this->sendResponse([], 'Utilisateurs restaurés avec succès', 200);
      } catch (\Throwable $th) {
      Log::error('Erreur lors de la restauration des utilisateurs : ' . $th->getMessage());
      return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
      }
    }


    public function insolvableInscription(Request $request)
    {
        $users =  User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.firstname as firstname','users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule')
                                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                                ->where('users.idSchool',$request['idSchool'])
                                                ->where('users.idSection',$request['idSection'])
                                                ->where('users.deleted',0)
                                                ->where('roles.id',6)
                                                ->orderBy("users.id", "desc")
                                                ->get();

        return PreinscriptionResource::collection($users);
    }
    public function getuser(Request $request)
    {
        try {
            $user = User::select('users.id as id', 'users.name as name','users.scholar_type as scholar_type','users.phone as phone', 'roles.name as role','users.adresse as adresse','users.photo as photo','users.idSchool as idSchool','users.idSection as idSection','users.idLevel as idLevel','users.idClasse as idClasse','users.idCycle as idCycle','roles.type as typeRole')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('users.id', auth()->user()->id)->first();

            if(!empty($user->idSchool)){
                $user = User::select('users.id as id', 'users.name as name','users.scholar_type as scholar_type','users.phone as phone', 'roles.name as role','users.adresse as adresse','users.photo as photo','users.idSchool as idSchool','users.idSection as idSection','users.idLevel as idLevel','users.idClasse as idClasse','users.idCycle as idCycle','roles.type as typeRole','schools.scholar_level as scholar_level')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->join('schools','schools.id','=','users.idSchool')
                        ->where('users.id', auth()->user()->id)->first();
            }

            $build = MobileBuildVersion::orderBy('id', 'desc')->first();
            $user->build_number = $build->build_number;
            $user->build_number_verified = $build->verified;
            $user->registrationPaid = $this->isRegistrationPaid($user->id);
            $user->pay_om_fees = Establishment::first()->pay_om_fees;

//            $user->build_number = MobileBuildVersion::orderBy('id', 'desc')->first()->build_number;
            return UserLoginGetResource::make($user);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function dashboardFounder(DashFounderRequest $request)
    {
        try {
            // 🔹 Validation des données reçues
            $dashfounder = $request->validated();
            $idSchool = isset($dashfounder['idSchool']) ? $dashfounder['idSchool'] : null;
            $idSection = isset($dashfounder['idSection']) ? $dashfounder['idSection'] : null;

            $tabDash = array();

            /**
             * ==========================================================
             * 1️⃣  COMPTAGE DES UTILISATEURS PAR RÔLE
             * ==========================================================
             */

            // Étudiants
            $tabDash['student'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.deleted', 0)
                ->count();

            // Enseignants
            $tabDash['teacher'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 5)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.deleted', 0)
                ->count();

            // Parents
            $tabDash['parent'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 7)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.deleted', 0)
                ->count();

            /**
             * ==========================================================
             * 2️⃣  ÉLÉMENTS ACADÉMIQUES
             * ==========================================================
             */

            $tabDash['course'] = Course::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->count();

            $tabDash['classes'] = Classes::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->count();

            $tabDash['event'] = Event::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->count();

            $tabDash['matter'] = Matter::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->count();

            /**
             * ==========================================================
             * 3️⃣  FINANCES GLOBALES
             * ==========================================================
             */
            $tabDash['pensionUser'] = PensionUser::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->sum('advancePayment');

            $tabDash['feeUsers'] = array();

            $fees = Fee::all();
            foreach ($fees as $index => $fee) {
                $feeSum = FeeUser::where('idSchool', $idSchool)
                    ->when($idSection, function ($q) use ($idSection) {
                        return $q->where('idSection', $idSection);
                    })
                    ->where('idFee', $fee->id)
                    ->sum('advancePayment');

                $tabDash['feeUsers'][$index][$fee->name] = $feeSum;
            }

            $tabDash['feeUser'] = FeeUser::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->sum('advancePayment');

            /**
             * ==========================================================
             * 4️⃣  PERSONNEL & ABSENCES
             * ==========================================================
             */
            $staffRoles = array('Direction', 'Staffs', 'Assistant', 'Secretary');

            $tabDash['staff'] = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->whereIn('roles.type', $staffRoles)
                ->where('users.deleted', 0)
                ->count();

            $tabDash['absence'] = Absence::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->count();

            /**
             * ==========================================================
             * 5️⃣  FACTURATION ET ENCAISSEMENTS
             * ==========================================================
             */
            // Somme totale des factures
            $tabDash['somme_invoices'] = \App\Models\Invoice::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->where('deleted_at', null)
                ->where('statut', 'paid')
                ->sum('amount');

            // Somme totale des encaissements
            $tabDash['somme_cashins'] = \App\Models\CashIn::sum('amount_received');

            /**
             * ==========================================================
             * 6️⃣  SOMMES PAR MODE DE PAIEMENT
             * ==========================================================
             */
            $paymentModes = array('Orange Money', 'Mobile Money', 'Cash', 'Bank');
            foreach ($paymentModes as $mode) {
                $pensionSum = PensionUser::where('idSchool', $idSchool)
                    ->when($idSection, function ($q) use ($idSection) {
                        return $q->where('idSection', $idSection);
                    })
                    ->where('payment_mode', $mode)
                    ->sum('advancePayment');

                $feeSum = FeeUser::where('idSchool', $idSchool)
                    ->when($idSection, function ($q) use ($idSection) {
                        return $q->where('idSection', $idSection);
                    })
                    ->where('payment_mode', $mode)
                    ->sum('advancePayment');

                $key = strtolower(str_replace(' ', '_', $mode)) . '_total';
                $tabDash[$key] = $pensionSum + $feeSum;
            }

            /**
             * ==========================================================
             * 6️⃣  DÉTAILS PAR BANQUE
             * ==========================================================
             */
            $tabDash['bank_types'] = array();

            $bankTypes = PensionUser::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->where('payment_mode', 'Bank')
                ->select('operator')
                ->distinct()
                ->pluck('operator');

            foreach ($bankTypes as $operator) {
                $pensionSum = PensionUser::where('idSchool', $idSchool)
                    ->when($idSection, function ($q) use ($idSection) {
                        return $q->where('idSection', $idSection);
                    })
                    ->where('payment_mode', 'Bank')
                    ->where('operator', $operator)
                    ->sum('advancePayment');

                $feeSum = FeeUser::where('idSchool', $idSchool)
                    ->when($idSection, function ($q) use ($idSection) {
                        return $q->where('idSection', $idSection);
                    })
                    ->where('payment_mode', 'Bank')
                    ->where('operator', $operator)
                    ->sum('advancePayment');

                $tabDash['bank_types'][$operator] = $pensionSum + $feeSum;
            }

            /**
             * ==========================================================
             * 7️⃣  STATISTIQUES ÉLÈVES
             * ==========================================================
             */
            $tabDash['girls_count'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.gender', 'Female')
                ->where('users.deleted', 0)
                ->count();

            $tabDash['boys_count'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.gender', 'Male')
                ->where('users.deleted', 0)
                ->count();

            $tabDash['total_anciens'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where('users.situation', 'old')
                ->where('users.deleted', 0)
                ->count();

            $tabDash['total_nouveaux'] = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('users.idSection', $idSection);
                })
                ->where(function ($q) {
                    $q->whereNull('users.situation')
                        ->orWhere('users.situation', 'new');
                })
                ->where('users.deleted', 0)
                ->count();

            /**
             * ==========================================================
             * 8️⃣  ENFANTS AYANT EFFECTUÉ UN PAIEMENT
             * ==========================================================
             */
            $pensionUserIds = PensionUser::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->distinct()
                ->pluck('idStudent')
                ->toArray();

            $feeUserIds = FeeUser::where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
                ->distinct()
                ->pluck('idStudent')
                ->toArray();

            $tabDash['children_with_payment'] = count(array_unique(array_merge($pensionUserIds, $feeUserIds)));

            // ✅ Réponse finale
            return $this->sendResponse($tabDash, 'Statistiques calculées avec succès.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function dashboardParent(DashParentRequest $request)
    {
        try {
            $validated = $request->validated();

            // Récupérer l'étudiant avec sa classe
            $student = User::with('classe')
                         ->find($validated['idStudent']);

            // Vérifier si l'étudiant existe
            if (!$student) {
                return $this->sendError('Étudiant non trouvé', null, 404);
            }

            // Vérifier si l'étudiant a une classe
            if (!$student->classe) {
                return $this->sendError('Aucune classe trouvée pour cet étudiant', null, 404);
            }

            // Récupération des informations depuis l'étudiant et sa classe
            $idStudent = $student->id;
            $idClasse = $student->idClasse;
            $idSchool = $student->classe->idSchool;
            $idSection = $student->classe->idSection;


            $tabDash = [];

           $tabDash['course'] = Course::where('idClasse', $idClasse)
                                    ->where('idSchool', $idSchool)
                                    ->when($idSection, function($query) use ($idSection) {
                                        return $query->where('idSection', $idSection);
                                    })
                                    ->count();


            $tabDash['absence'] = Absence::where('idStudent', $idStudent)
                                      ->where('idSchool', $idSchool)
                                      ->when($idSection, function($query) use ($idSection) {
                                          return $query->where('idSection', $idSection);
                                      })
                                      ->count();

            $tabDash['homework'] = Homework::where('idClasse', $idClasse)
                                        ->where('idSchool', $idSchool)
                                        ->when($idSection, function($query) use ($idSection) {
                                            return $query->where('idSection', $idSection);
                                        })
                                        ->count();


            $tabDash['sanction'] = Sanction::where('idUser', $idStudent)
                                         ->where('idSchool', $idSchool)
                                         ->when($idSection, function($query) use ($idSection) {
                                             return $query->where('idSection', $idSection);
                                         })
                                         ->count();

            // Ajout du nombre d'observations pour l'étudiant
            $tabDash['observations_count'] = TeacherObservation::where('idStudent', $idStudent)
                ->where('idSchool', $idSchool)
                ->when($idSection, function($query) use ($idSection) {
                    return $query->where('idSection', $idSection);
                })
                ->count();

            // Ajout du nombre de retards pour l'étudiant
            $tabDash['delays_count'] = SchoolDelay::where('idStudent', $idStudent)
            //  ->where('idSchool', $idSchool)
             /*/->when($idSection, function($query) use ($idSection) {
                    return $query->where('idSection', $idSection);
                })*/
                ->count();

            return $this->sendResponse($tabDash, 'Stat');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function dashboardTeacher(DashTeacherRequest $request)
    {
        try {
            $dashteacher = $request->validated();

            $tabDash = array();
            $course = Course::where('idTeacher',$dashteacher['idTeacher'])
                            ->where('idSchool',$dashteacher['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($dashteacher) {
                                $query->where('idSection', $dashteacher['idSection']);
                            })
                            ->count();

            $tabDash['course'] = $course;

            $assessment = Assessment::where('idTeacher',$dashteacher['idTeacher'])
                            ->where('idSchool',$dashteacher['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($dashteacher) {
                                $query->where('idSection', $dashteacher['idSection']);
                            })
                            ->count();

            $tabDash['assessment'] = $assessment;

            $studentClasse = User::join('classes', 'classes.id', '=', 'users.idClasse')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.id', 8)
                            ->where('users.idClasse',$dashteacher['idClasse'])
                            ->where('users.idSchool',$dashteacher['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($dashteacher) {
                                $query->where('users.idSection', $dashteacher['idSection']);
                            })
                            ->where('users.deleted',0)
                            ->count();

            $tabDash['studentClasse'] = $studentClasse;

            $homework = Homework::where('idTeacher',$dashteacher['idTeacher'])
                            ->where('idSchool',$dashteacher['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($dashteacher) {
                                $query->where('idSection', $dashteacher['idSection']);
                            })
                            ->count();

            $tabDash['homework'] = $homework;

            return $this->sendResponse($tabDash, 'Stat');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Affichage des détails de finance pour fondateur
     *
     * @param Request $request
     * @return Response
     */
    public function financeDetailFounder(FinanceDetailsFounderRequest $request)
    {
        try {
            $tabFinance = array();

            $idSection = $tabFinance['idSection'] ?? null;

            $sections = Section::where('idSchool', $request->idSchool)->get();

            $levels = Level::select('id','name')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('idSection', $request['idSection']);
                })
                ->where('idSchool', $request['idSchool'])
                ->get();

            $tabFinance['levels'] = $levels;

            $fees = Fee::select('fees.id as id', 'fees.name as name', 'fees.price as price')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('fees.idSection', $request['idSection']);
                })
                ->where('fees.idSchool', $request['idSchool'])
                ->when($request['idLevel'] !== null, function ($query) use ($request) {
                    $query->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
                        ->where('fee_has_level.level_id', $request['idLevel']);
                })
                ->get();

            $tabFinance['fees'] = $fees;
            $tabFinance['ecole']['name'] = School::find($request['idSchool'])->name;
            $tabFinance['ecole']['effectif'] = User::select('users.id as id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->join('schools', 'schools.id', '=', 'users.idSchool')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->where('roles.id', 8)
                ->where('users.deleted', 0)
                ->where('users.idSchool', $request['idSchool'])
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('users.idSection', $request['idSection']);
                })
                ->when($request['idClasse'] !== null, function ($query) use ($request) {
                    $query->where('users.idClasse', $request['idClasse']);
                })
                ->count();

            // On somme aussi le montant total de bourses octroyées dans l'école
            $tabFinance['ecole']['totalFeeAPercevoir'] = 0;
            $tabFinance['ecole']['totalFeeDejaPercu'] = 0;
            $tabFinance['ecole']['totalFeeRestant'] = 0;
            $tabFinance['ecole']['totalPensionApercevoir'] = 0;
            $tabFinance['ecole']['totalPensionDejaPercu'] = 0;
            $tabFinance['ecole']['totalPensionRestant'] = 0;
            $tabFinance['ecole']['scholarshipsComsumed'] = PensionUser::join('bourses', 'bourses.id', '=', 'pension_users.idBourse')
                ->whereNotNull('pension_users.idBourse')
                ->where('pension_users.idSchool', $request['idSchool'])
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('pension_users.idSection', $request['idSection']);
                })
                ->sum('bourses.amount');

            for ($i = 0; $i < $levels->count(); $i++) {
                $pension = Pension::select('id', 'name', 'price', 'nbrTranche')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('idSection', $request['idSection']);
                    })
                    ->where('idSchool', $request['idSchool'])
                    ->where('idLevel', $levels[$i]['id'])
                    ->get();

                $tabFinance['levels'][$i]['effectifLevel'] = User::select('users.id as id')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->join('schools', 'schools.id', '=', 'users.idSchool')
                    ->join('classes', 'classes.id', "=", "users.idClasse")
                    ->where('roles.id', 8)
                    ->where('users.idSchool', $request['idSchool'])
                    ->where('users.idLevel', $levels[$i]->id)
                    ->where('users.deleted', 0)
                    ->count();

                $tabFinance['levels'][$i]['pension'] = $pension;

                $totalApercevoirPension = null;
                $totalPercuPension = null;
                $totalRestantPension = null;

                for ($j = 0; $j < $pension->count(); $j++) {

                    $classes = Classes::select('id', 'name')
                        ->when($request['idSection'] !== null, function ($query) use ($request) {
                            $query->where('idSection', $request['idSection']);
                        })
                        ->where('idSchool', $request['idSchool'])
                        ->where('idLevel', $levels[$i]['id'])
                        ->get();

                    $tabFinance['levels'][$i]['pension'][$j]['classes'] = $classes;

                    for ($k = 0; $k < $classes->count(); $k++) {
                        $student = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.id', 8)
                            ->where('users.idSchool', $request['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('users.idSection', $request['idSection']);
                            })
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->where('users.deleted', 0)
                            ->count();

                        $pensionUserAPercevoir = $student * $pension[$j]['price'];
                        $totalApercevoirPension = $totalApercevoirPension + $pensionUserAPercevoir;

                        $pensionUserPercu = PensionUser::join('users', 'users.id', '=', 'pension_users.idStudent')
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('pension_users.idSection', $request['idSection']);
                            })
                            ->where('pension_users.idSchool', $request['idSchool'])
                            ->where('pension_users.idPension', $pension[$j]['id'])
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->where('users.deleted', 0)
                            ->sum('pension_users.advancePayment');

                        $pensionUserRestante = $pensionUserAPercevoir - $pensionUserPercu;
                        $totalPercuPension = $totalPercuPension + $pensionUserPercu;
                        $totalRestantPension = $totalRestantPension + $pensionUserRestante;


                        $pensionUserAPercevoir = number_format($pensionUserAPercevoir, 0, '.', ',');
                        $pensionUserPercu = number_format($pensionUserPercu, 0, '.', ',');
                        $pensionUserRestante = number_format($pensionUserRestante, 0, '.', ',');

                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['effectifClasse'] = $student;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserAPercevoir'] = $pensionUserAPercevoir;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserPercu'] = $pensionUserPercu;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserRestante'] = $pensionUserRestante;
                    }
                }

//                $totalApercevoirPension = number_format($totalApercevoirPension, 0, '.', ',');
//                $totalPercuPension = number_format($totalPercuPension, 0, '.', ',');
//                $totalRestantPension = number_format($totalRestantPension, 0, '.', ',');
                $tabFinance['levels'][$i]['totalApercevoirPension'] = $totalApercevoirPension;
                $tabFinance['levels'][$i]['totalPercuPension'] = $totalPercuPension;
                $tabFinance['levels'][$i]['totalRestantPension'] = $totalRestantPension;
                $tabFinance['levels'][$i]['scholarshipsComsumed'] = PensionUser::join('bourses', 'bourses.id', '=', 'pension_users.idBourse')
                    ->join('pensions', 'pensions.id', '=', 'pension_users.idPension')
                    ->join('levels', 'levels.id', '=', 'pensions.idLevel')
                    ->where('levels.id', $levels[$i]['id'])
                    ->whereNotNull('pension_users.idBourse')
                    ->where('pension_users.idSchool', $request['idSchool'])
                    ->sum('bourses.amount');

                $tabFinance['ecole']['totalPensionApercevoir'] += $tabFinance['levels'][$i]['totalApercevoirPension'];
                $tabFinance['ecole']['totalPensionDejaPercu'] += $tabFinance['levels'][$i]['totalPercuPension'];
                $tabFinance['ecole']['totalPensionRestant'] += $tabFinance['levels'][$i]['totalRestantPension'];
            }

            /**
             * Gestion des Fees
             */

            for ($p = 0; $p < $fees->count(); $p++) {

                // Récuperer tous les levels associés à ce frais
                // récuperer toutes les classes de ce level
                // récuperer le nbre d'élève de chaque classe
                // multiplier le montant de frais par le nbre d'élèves de la classe
                // remonter en sommant !

                $levelsHavingThisFee = Level::select('levels.id as id', 'levels.name as name')
                    ->join('fee_has_level', 'fee_has_level.level_id', '=', 'levels.id')
                    ->where('fee_has_level.fee_id', $fees[$p]->id)
                    ->get();

                $tabFinance['fees'][$p]['levels'] = $levelsHavingThisFee;

                foreach ($levelsHavingThisFee as $keyLevel => $level) {
                    $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] = 0;

                    $classes = Classes::select('classes.id as id', 'classes.name as name')
                        ->where('idLevel', $level->id)
                        ->when($request['idClasse'] !== null, function ($query) use ($request) {
                            $query->where('classes.id', $request['idClasse']);
                        })
                        ->get();


                    $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'] = $classes;

                    foreach ($classes as $keyClasse => $classe) {
                        $studentsInClasse = User::select('users.id as id')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->join('schools', 'schools.id', '=', 'users.idSchool')
                            ->join('classes', 'classes.id', "=", "users.idClasse")
                            ->where('roles.id', 8)
                            ->where('users.deleted', 0)
                            ->where('users.idSchool', $request['idSchool'])
                            ->where('users.idClasse', $classe->id)
                            ->pluck('id')
                            ->toArray();
//                        User::select('users.id as id')
//                            ->where('idClasse', $classe->id)
//                            ->where('users.deleted', 0)
//                            ->pluck('id')
//                            ->toArray();

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['effectif'] = count($studentsInClasse);
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] = count($studentsInClasse) * $fees[$p]->price;
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'] = FeeUser::where('idFee', $fees[$p]->id)->whereIn('idStudent', $studentsInClasse)->sum('advancePayment');
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'] = $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] - $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] += count($studentsInClasse);

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'];
                    }

                    $tabFinance['fees'][$p]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'];
                    $tabFinance['fees'][$p]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'];
                    $tabFinance['fees'][$p]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'];
                }

                $tabFinance['ecole']['totalFeeAPercevoir'] += $tabFinance['fees'][$p]['totalAPercevoir'];
                $tabFinance['ecole']['totalFeeDejaPercu'] += $tabFinance['fees'][$p]['totalDejaPercu'];
                $tabFinance['ecole']['totalFeeRestant'] += $tabFinance['fees'][$p]['totalRestant'];
            }

            return $this->sendResponse($tabFinance, 'Détails finance');
            die;
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function financeDetailFounderPerClasse(FinanceDetailsFounderRequest $request)
    {
        try {
            $tabFinance = array();

            $levels = Level::where('levels.idSchool', $request['idSchool'])
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('levels.idSection', $request['idSection']);
                })
                ->when($request['idClasse'] !== null, function ($query) use ($request) {
                    $query
                        ->join('classes', 'classes.idLevel', '=', 'levels.id')
                        ->where('classes.id', $request['idClasse']);
                })
                ->get();

            $tabFinance['levels'] = $levels;

            $fees = Fee::select('fees.id as id', 'fees.name as name', 'fees.price as price')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('fees.idSection', $request['idSection']);
                })
                ->where('fees.idSchool', $request['idSchool'])
                ->when($request['idLevel'] !== null, function ($query) use ($request) {
                    $query->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
                        ->where('fee_has_level.level_id', $request['idLevel']);
                })
                ->get();

            $tabFinance['fees'] = $fees;
            $tabFinance['ecole']['name'] = School::find($request['idSchool'])->name;
            $tabFinance['ecole']['effectif'] = User::where('idSchool', $request['idSchool'])->where('users.deleted', 0)->count();

            $tabFinance['ecole']['totalFeeAPercevoir'] = 0;
            $tabFinance['ecole']['totalFeeDejaPercu'] = 0;
            $tabFinance['ecole']['totalFeeRestant'] = 0;
            $tabFinance['ecole']['totalPensionApercevoir'] = 0;
            $tabFinance['ecole']['totalPensionDejaPercu'] = 0;
            $tabFinance['ecole']['totalPensionRestant'] = 0;

            for ($i = 0; $i < $levels->count(); $i++) {
                $pension = Pension::select('id', 'name', 'price', 'nbrTranche')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('idSection', $request['idSection']);
                    })
                    ->where('idSchool', $request['idSchool'])
                    ->where('idLevel', $levels[$i]['id'])
                    ->get();

                $tabFinance['levels'][$i]['effectifLevel'] = User::where('idLevel', $levels[$i]->id)->where('users.deleted', 0)->count();
                $tabFinance['levels'][$i]['pension'] = $pension;

                $totalApercevoirPension = null;
                $totalPercuPension = null;
                $totalRestantPension = null;

                for ($j = 0; $j < $pension->count(); $j++) {

                    $classes = Classes::select('id', 'name')
                        ->when($request['idSection'] !== null, function ($query) use ($request) {
                            $query->where('idSection', $request['idSection']);
                        })
                        ->when($request['idClasse'] !== null, function ($query) use ($request) {
                            $query->where('id', $request['idClasse']);
                        })
                        ->where('idSchool', $request['idSchool'])
                        ->where('idLevel', $levels[$i]['id'])
                        ->get();

                    $tabFinance['levels'][$i]['pension'][$j]['classes'] = $classes;

                    for ($k = 0; $k < $classes->count(); $k++) {
                        $students = User::select('users.id as id', 'users.idBourse as idBourse', 'users.isBourseUsed as isBourseUsed', 'users.name as name', 'users.phone as phone', 'users.nationality as nationality', 'users.codeun as codeun', 'users.codedeux as codedeux', 'users.city as city', 'users.country as country', 'users.email as email', 'users.gender as gender', 'users.username as username', 'users.birthday as birthday', 'users.password as password', 'users.cni as cni', 'users.idSchool as idSchool', 'users.idSection as idSection', 'users.photo as photo', 'users.created_at as created_at', 'users.updated_at as updated_at', 'users.created_by as created_by', 'users.updated_by as updated_by', 'users.adresse as adresse', 'users.salary as salary', 'users.hourlyPrice as hourlyPrice', 'users.idMatter as idMatter', 'users.idLevel as idLevel', 'users.idOptionLevel as idOptionLevel', 'roles.id as idRole', 'users.idCycle as idCycle', 'users.idParent as idParent', 'users.idClasse as idClasse', 'users.firstname as firstname', 'users.placeofbirth as placeofbirth', 'users.situation as situation', 'users.repeater as repeater', 'users.matricule as matricule', 'users.phone as phone', 'schools.scholar_level as scholar_level', 'classes.name as classe_name')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->join('schools', 'schools.id', '=', 'users.idSchool')
                            ->join('classes', 'classes.id', "=", "users.idClasse")
                            ->where('roles.id', 8)
                            ->where('users.deleted', 0)
                            ->where('users.idSchool', $request['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('users.idSection', $request['idSection']);
                            })
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->when($request['idClasse'] !== null, function ($query) use ($request) {
                                $query->where('users.idClasse', $request['idClasse']);
                            })
                            ->orderBy('users.name')
                            ->get();

                        $pensionUserAPercevoir = count($students) * $pension[$j]['price'];
                        $totalApercevoirPension = $totalApercevoirPension + $pensionUserAPercevoir;

                        $pensionUserPercu = PensionUser::join('users', 'users.id', '=', 'pension_users.idStudent')
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('pension_users.idSection', $request['idSection']);
                            })
                            ->where('pension_users.idSchool', $request['idSchool'])
                            ->where('pension_users.idPension', $pension[$j]['id'])
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->when($request['idClasse'] !== null, function ($query) use ($request) {
                                $query->where('users.idClasse', $request['idClasse']);
                            })
                            ->where('users.deleted', 0)
                            ->sum('pension_users.advancePayment');

                        $pensionUserRestante = $pensionUserAPercevoir - $pensionUserPercu;
                        $totalPercuPension = $totalPercuPension + $pensionUserPercu;
                        $totalRestantPension = $totalRestantPension + $pensionUserRestante;


                        $pensionUserAPercevoir = number_format($pensionUserAPercevoir, 0, '.', ',');
                        $pensionUserPercu = number_format($pensionUserPercu, 0, '.', ',');
                        $pensionUserRestante = number_format($pensionUserRestante, 0, '.', ',');

                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['effectifClasse'] = count($students);
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserAPercevoir'] = $pensionUserAPercevoir;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserPercu'] = $pensionUserPercu;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserRestante'] = $pensionUserRestante;

                        $sssss = array();
                        for ($st = 0; $st < count($students); $st++) {
                            $dejaPaye = PensionUser::where('idStudent', $students[$st]->id)->sum('advancePayment');

                            $sssss[] = [
                                'name' => $students[$st]->name,
                                'pensionUserAPercevoir' => $pension[$j]['price'],
                                'pensionUserPercu' => $dejaPaye,
                                'pensionUserRestante' => $pension[$j]['price'] - $dejaPaye,
                            ];
                        }

                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['students'] = $sssss;
                    }
                }

//                $totalApercevoirPension = number_format($totalApercevoirPension, 0, '.', ',');
//                $totalPercuPension = number_format($totalPercuPension, 0, '.', ',');
//                $totalRestantPension = number_format($totalRestantPension, 0, '.', ',');
                $tabFinance['levels'][$i]['totalApercevoirPension'] = $totalApercevoirPension;
                $tabFinance['levels'][$i]['totalPercuPension'] = $totalPercuPension;
                $tabFinance['levels'][$i]['totalRestantPension'] = $totalRestantPension;

                $tabFinance['ecole']['totalPensionApercevoir'] += $tabFinance['levels'][$i]['totalApercevoirPension'];
                $tabFinance['ecole']['totalPensionDejaPercu'] += $tabFinance['levels'][$i]['totalPercuPension'];
                $tabFinance['ecole']['totalPensionRestant'] += $tabFinance['levels'][$i]['totalRestantPension'];
            }

            /**
             * Gestion des Fees
             */

            for ($p = 0; $p < $fees->count(); $p++) {

                // Récuperer tous les levels associés à ce frais
                // récuperer toutes les classes de ce level
                // récuperer le nbre d'élève de chaque classe
                // multiplier le montant de frais par le nbre d'élèves de la classe
                // remonter en sommant !

                $levelsHavingThisFee = Level::select('levels.id as id', 'levels.name as name')
                    ->join('fee_has_level', 'fee_has_level.level_id', '=', 'levels.id')
                    ->where('fee_has_level.fee_id', $fees[$p]->id)
                    ->get();

                $tabFinance['fees'][$p]['levels'] = $levelsHavingThisFee;

                foreach ($levelsHavingThisFee as $keyLevel => $level) {
                    $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] = 0;

                    $classes = Classes::select('classes.id as id', 'classes.name as name')
                        ->where('idLevel', $level->id)
                        ->when($request['idClasse'] !== null, function ($query) use ($request) {
                            $query->where('classes.id', $request['idClasse']);
                        })
                        ->get();


                    $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'] = $classes;

                    foreach ($classes as $keyClasse => $classe) {
                        $studentsInClasse = User::select('users.id as id')
                            ->where('idClasse', $classe->id)
                            ->where('users.deleted', 0)
                            ->pluck('id')
                            ->toArray();

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['effectif'] = count($studentsInClasse);
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] = count($studentsInClasse) * $fees[$p]->price;
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'] = FeeUser::where('idFee', $fees[$p]->id)->whereIn('idStudent', $studentsInClasse)->sum('advancePayment');
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'] = $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] - $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] += count($studentsInClasse);

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'];
                    }

                    $tabFinance['fees'][$p]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'];
                    $tabFinance['fees'][$p]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'];
                    $tabFinance['fees'][$p]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'];
                }

                $tabFinance['ecole']['totalFeeAPercevoir'] += $tabFinance['fees'][$p]['totalAPercevoir'];
                $tabFinance['ecole']['totalFeeDejaPercu'] += $tabFinance['fees'][$p]['totalDejaPercu'];
                $tabFinance['ecole']['totalFeeRestant'] += $tabFinance['fees'][$p]['totalRestant'];
            }

            return $this->sendResponse($tabFinance, 'Détails finance');
            die;
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function financeDetailFounderPerOrdreTranche(FinanceDetailsFounderPerTrancheRequest $request)
    {
        //TODO: Le total à percevoir est montant * nbreStudents concernés

        try {
            $tabFinance = array();

            $tranches = Tranche::join('pensions', 'pensions.id', '=', 'tranches.idPension')
                ->join('levels', 'levels.id', '=', 'pensions.idLevel')
                ->where('tranches.name', $request->nameTranche)
                ->select('tranches.id as id', 'tranches.price as price', 'levels.id as idLevel', 'pensions.id as idPension')
                ->orderBy('idLevel')
                ->get();

//            return $tranches;

            $totalPercuPension = PensionUser::whereIn('idTranche', $tranches->pluck('id')->toArray())->sum('advancePayment');

            $tabFinance['totalPensionApercevoir'] = 0;
            $tabFinance['totalPensionDejaPercu'] = 0;
            $tabFinance['totalPensionRestant'] = 0;
            $tabFinance['effectif'] = 0;

            foreach ($tranches as $tranche) {
                $level = Level::find($tranche->idLevel);
                $nbreStudentsLevel = User::where('deleted', 0)->where('idLevel', $tranche->idLevel)->count();

                $totalPensionApercevoirLevel = $nbreStudentsLevel * $tranche->price;
                $totalPercuPensionLevel = PensionUser::where('idTranche', $tranche->id)->sum('advancePayment');
                $totalPensionRestantLevel = $totalPensionApercevoirLevel - $totalPercuPensionLevel;


                $tabFinance['totalPensionApercevoir'] += $totalPensionApercevoirLevel;
                $tabFinance['effectif'] += $nbreStudentsLevel;


                // On parcourt maintenant toutes les classes de ce level
                $classes = Classes::where('idLevel', $tranche->idLevel)->get();

                $tabPerClass = array();

                foreach ($classes as $classe) {
                    $effectifClasse = User::where('deleted', 0)->where('idClasse', $classe->id)->where('idLevel', $tranche->idLevel)->get();

                    $totalApercevoirPensionClasse = $effectifClasse->count() * $tranche->price;
                    $totalPercuPensionClasse = PensionUser::where('idTranche', $tranche->id)
                        ->whereIn('idStudent', $effectifClasse->pluck('id')->toArray())
                        ->sum('advancePayment');

                    $tabPerClass[] = [
                        'name' => $classe->name,
                        'effectif' => $effectifClasse->count(),
                        'totalPensionApercevoir' => $totalApercevoirPensionClasse,
                        'totalPensionDejaPercu' => $totalPercuPensionClasse,
                        'totalPensionRestant' => $totalApercevoirPensionClasse - $totalPercuPensionClasse,
                    ];
                }

                $tabFinance['levels'][] = [
                    'name' => $level->name,
                    'effectif' => $nbreStudentsLevel,
                    'totalPensionApercevoir' => $totalPensionApercevoirLevel,
                    'totalPensionDejaPercu' => $totalPercuPensionLevel,
                    'totalPensionRestant' => $totalPensionRestantLevel,
                    'classes' => $tabPerClass
                ];
            }


            // Pour avoir le total à verser, il faut savoir, pour chaque tranche, le nombre d'étudiants concernés (idLevel)
//            foreach ($tranches as $tranche) {
//                $nbreStudents = User::where('deleted', 0)->where('idLevel', $tranche->idLevel)->count();
//
//                $tabFinance['totalPensionApercevoir'] += $nbreStudents * $tranche->price;
//            }
            $tabFinance['totalPensionDejaPercu'] = $totalPercuPension;

            $tabFinance['totalPensionRestant'] = $tabFinance['totalPensionApercevoir'] - $totalPercuPension;

            return $this->sendResponse($tabFinance, 'Détails finance par tranches');
            die;

            $levels = Level::where('levels.idSchool', $request['idSchool'])
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('levels.idSection', $request['idSection']);
                })
                ->when($request['idClasse'] !== null, function ($query) use ($request) {
                    $query
                        ->join('classes', 'classes.idLevel', '=', 'levels.id')
                        ->where('classes.id', $request['idClasse']);
                })
                ->get();

            $tabFinance['levels'] = $levels;

            $fees = Fee::select('fees.id as id', 'fees.name as name', 'fees.price as price')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('fees.idSection', $request['idSection']);
                })
                ->where('fees.idSchool', $request['idSchool'])
                ->when($request['idLevel'] !== null, function ($query) use ($request) {
                    $query->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
                        ->where('fee_has_level.level_id', $request['idLevel']);
                })
                ->get();

            $tabFinance['fees'] = $fees;
            $tabFinance['ecole']['name'] = School::find($request['idSchool'])->name;
            $tabFinance['ecole']['effectif'] = User::where('idSchool', $request['idSchool'])->where('users.deleted', 0)->count();

            $tabFinance['ecole']['totalFeeAPercevoir'] = 0;
            $tabFinance['ecole']['totalFeeDejaPercu'] = 0;
            $tabFinance['ecole']['totalFeeRestant'] = 0;
            $tabFinance['ecole']['totalPensionApercevoir'] = 0;
            $tabFinance['ecole']['totalPensionDejaPercu'] = 0;
            $tabFinance['ecole']['totalPensionRestant'] = 0;

            for ($i = 0; $i < $levels->count(); $i++) {
                $pension = Pension::select('id', 'name', 'price', 'nbrTranche')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('idSection', $request['idSection']);
                    })
                    ->where('idSchool', $request['idSchool'])
                    ->where('idLevel', $levels[$i]['id'])
                    ->get();

                $tabFinance['levels'][$i]['effectifLevel'] = User::where('idLevel', $levels[$i]->id)->where('users.deleted', 0)->count();
                $tabFinance['levels'][$i]['pension'] = $pension;

                $totalApercevoirPension = null;
                $totalPercuPension = null;
                $totalRestantPension = null;

                for ($j = 0; $j < $pension->count(); $j++) {

                    $classes = Classes::select('id', 'name')
                        ->when($request['idSection'] !== null, function ($query) use ($request) {
                            $query->where('idSection', $request['idSection']);
                        })
                        ->when($request['idClasse'] !== null, function ($query) use ($request) {
                            $query->where('id', $request['idClasse']);
                        })
                        ->where('idSchool', $request['idSchool'])
                        ->where('idLevel', $levels[$i]['id'])
                        ->get();

                    $tabFinance['levels'][$i]['pension'][$j]['classes'] = $classes;

                    for ($k = 0; $k < $classes->count(); $k++) {
                        $students = User::select('users.id as id', 'users.idBourse as idBourse', 'users.isBourseUsed as isBourseUsed', 'users.name as name', 'users.phone as phone', 'users.nationality as nationality', 'users.codeun as codeun', 'users.codedeux as codedeux', 'users.city as city', 'users.country as country', 'users.email as email', 'users.gender as gender', 'users.username as username', 'users.birthday as birthday', 'users.password as password', 'users.cni as cni', 'users.idSchool as idSchool', 'users.idSection as idSection', 'users.photo as photo', 'users.created_at as created_at', 'users.updated_at as updated_at', 'users.created_by as created_by', 'users.updated_by as updated_by', 'users.adresse as adresse', 'users.salary as salary', 'users.hourlyPrice as hourlyPrice', 'users.idMatter as idMatter', 'users.idLevel as idLevel', 'users.idOptionLevel as idOptionLevel', 'roles.id as idRole', 'users.idCycle as idCycle', 'users.idParent as idParent', 'users.idClasse as idClasse', 'users.firstname as firstname', 'users.placeofbirth as placeofbirth', 'users.situation as situation', 'users.repeater as repeater', 'users.matricule as matricule', 'users.phone as phone', 'schools.scholar_level as scholar_level', 'classes.name as classe_name')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->join('schools', 'schools.id', '=', 'users.idSchool')
                            ->join('classes', 'classes.id', "=", "users.idClasse")
                            ->where('roles.id', 8)
                            ->where('users.deleted', 0)
                            ->where('users.idSchool', $request['idSchool'])
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('users.idSection', $request['idSection']);
                            })
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->when($request['idClasse'] !== null, function ($query) use ($request) {
                                $query->where('users.idClasse', $request['idClasse']);
                            })
                            ->orderBy('users.name')
                            ->get();

                        $pensionUserAPercevoir = count($students) * $pension[$j]['price'];
                        $totalApercevoirPension = $totalApercevoirPension + $pensionUserAPercevoir;

                        $pensionUserPercu = PensionUser::join('users', 'users.id', '=', 'pension_users.idStudent')
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('pension_users.idSection', $request['idSection']);
                            })
                            ->where('pension_users.idSchool', $request['idSchool'])
                            ->where('pension_users.idPension', $pension[$j]['id'])
                            ->where('users.idClasse', $classes[$k]['id'])
                            ->when($request['idClasse'] !== null, function ($query) use ($request) {
                                $query->where('users.idClasse', $request['idClasse']);
                            })
                            ->where('users.deleted', 0)
                            ->sum('pension_users.advancePayment');

                        $pensionUserRestante = $pensionUserAPercevoir - $pensionUserPercu;
                        $totalPercuPension = $totalPercuPension + $pensionUserPercu;
                        $totalRestantPension = $totalRestantPension + $pensionUserRestante;


                        $pensionUserAPercevoir = number_format($pensionUserAPercevoir, 0, '.', ',');
                        $pensionUserPercu = number_format($pensionUserPercu, 0, '.', ',');
                        $pensionUserRestante = number_format($pensionUserRestante, 0, '.', ',');

                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['effectifClasse'] = count($students);
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserAPercevoir'] = $pensionUserAPercevoir;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserPercu'] = $pensionUserPercu;
                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['pensionUserRestante'] = $pensionUserRestante;

                        $sssss = array();
                        for ($st = 0; $st < count($students); $st++) {
                            $dejaPaye = PensionUser::where('idStudent', $students[$st]->id)->sum('advancePayment');

                            $sssss[] = [
                                'name' => $students[$st]->name,
                                'pensionUserAPercevoir' => $pension[$j]['price'],
                                'pensionUserPercu' => $dejaPaye,
                                'pensionUserRestante' => $pension[$j]['price'] - $dejaPaye,
                            ];
                        }

                        $tabFinance['levels'][$i]['pension'][$j]['classes'][$k]['students'] = $sssss;
                    }
                }

//                $totalApercevoirPension = number_format($totalApercevoirPension, 0, '.', ',');
//                $totalPercuPension = number_format($totalPercuPension, 0, '.', ',');
//                $totalRestantPension = number_format($totalRestantPension, 0, '.', ',');
                $tabFinance['levels'][$i]['totalApercevoirPension'] = $totalApercevoirPension;
                $tabFinance['levels'][$i]['totalPercuPension'] = $totalPercuPension;
                $tabFinance['levels'][$i]['totalRestantPension'] = $totalRestantPension;

                $tabFinance['ecole']['totalPensionApercevoir'] += $tabFinance['levels'][$i]['totalApercevoirPension'];
                $tabFinance['ecole']['totalPensionDejaPercu'] += $tabFinance['levels'][$i]['totalPercuPension'];
                $tabFinance['ecole']['totalPensionRestant'] += $tabFinance['levels'][$i]['totalRestantPension'];
            }

            /**
             * Gestion des Fees
             */

            for ($p = 0; $p < $fees->count(); $p++) {

                // Récuperer tous les levels associés à ce frais
                // récuperer toutes les classes de ce level
                // récuperer le nbre d'élève de chaque classe
                // multiplier le montant de frais par le nbre d'élèves de la classe
                // remonter en sommant !

                $levelsHavingThisFee = Level::select('levels.id as id', 'levels.name as name')
                    ->join('fee_has_level', 'fee_has_level.level_id', '=', 'levels.id')
                    ->where('fee_has_level.fee_id', $fees[$p]->id)
                    ->get();

                $tabFinance['fees'][$p]['levels'] = $levelsHavingThisFee;

                foreach ($levelsHavingThisFee as $keyLevel => $level) {
                    $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] = 0;

                    $classes = Classes::select('classes.id as id', 'classes.name as name')
                        ->where('idLevel', $level->id)
                        ->when($request['idClasse'] !== null, function ($query) use ($request) {
                            $query->where('classes.id', $request['idClasse']);
                        })
                        ->get();


                    $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'] = $classes;

                    foreach ($classes as $keyClasse => $classe) {
                        $studentsInClasse = User::select('users.id as id')
                            ->where('idClasse', $classe->id)
                            ->where('users.deleted', 0)
                            ->pluck('id')
                            ->toArray();

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['effectif'] = count($studentsInClasse);
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] = count($studentsInClasse) * $fees[$p]->price;
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'] = FeeUser::where('idFee', $fees[$p]->id)->whereIn('idStudent', $studentsInClasse)->sum('advancePayment');
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'] = $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'] - $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['effectif'] += count($studentsInClasse);

                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalAPercevoir'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalDejaPercu'];
                        $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['classes'][$keyClasse]['totalRestant'];
                    }

                    $tabFinance['fees'][$p]['totalAPercevoir'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalAPercevoir'];
                    $tabFinance['fees'][$p]['totalDejaPercu'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalDejaPercu'];
                    $tabFinance['fees'][$p]['totalRestant'] += $tabFinance['fees'][$p]['levels'][$keyLevel]['totalRestant'];
                }

                $tabFinance['ecole']['totalFeeAPercevoir'] += $tabFinance['fees'][$p]['totalAPercevoir'];
                $tabFinance['ecole']['totalFeeDejaPercu'] += $tabFinance['fees'][$p]['totalDejaPercu'];
                $tabFinance['ecole']['totalFeeRestant'] += $tabFinance['fees'][$p]['totalRestant'];
            }

            return $this->sendResponse($tabFinance, 'Détails finance');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function statistiqueOM(Request $request)
    {
        try {
            $tab = array();
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $query_schoolName = School::select('id', 'name', 'scholar_level', 'idEstablishment')->get();
            $query_withdrawal = Withdrawal::select('montant_retrait_brut', 'mode_retrait', 'idUser', 'numero_retrait', 'rib', 'idSchool', 'idSection')
                ->whereIn('status', ['pending', 'success', 'completed']) // uniquement les retraits qui ont déjà été validés
                ->whereIn('type', ['Orange Money', 'OM'])
                ->get();
            if ($idSchool != null) {
                switch ($idSection) {
                    case null:
                        $withdrawal = $query_withdrawal->where('idSchool', $request['idSchool'])
                            ->sum('montant_retrait_brut');

                        $schoolName = $query_schoolName->where('id', $request['idSchool'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $request['idSchool'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $request['idSchool'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schoolName'] = $schoolName->name;
                        $tab['schoolLevel'] = $schoolName->scholar_level;
                        $tab['sommeSchool'] = $totalAmount;
                        $tab['sommeSchoolRetire'] = $withdrawal;
                        $tab['sommeSchoolEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['sommeSchoolDispo'] = ($totalAmount - $withdrawal); // * 0.98;
                        $tab['sommeTotal_1'] = $totalAmount; // * 0.98;
                        $tab['sommeRetire_1'] = $withdrawal; // * 0.98;

                        return $this->sendResponses($tab);
                        break;

                    default:
                        $withdrawal = $query_withdrawal->where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->sum('amount');

                        $schoolName = $query_schoolName->where('id', $request['idSchool'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schoolName'] = $schoolName->name;
                        $tab['schoolLevel'] = $schoolName->scholar_level;
                        $tab['sommeSchoolSection'] = $totalAmount;
                        $tab['sommeSchoolSectionRetire'] = $withdrawal;
                        $tab['sommeSchoolSectionEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['sommeSchoolSectionDispo'] = ($totalAmount - $withdrawal); //* 0.98;
                        $tab['sommeTotal_1'] = $totalAmount; //* 0.98;
                        $tab['sommeRetire_1'] = $withdrawal; //* 0.98;

                        return $this->sendResponses($tab);
                        break;
                }
            } else {
                $withdrawal = $query_withdrawal->sum('montant_retrait_brut');
                $pensionUsersAmount = PensionUser::where('payment_mode', 'Orange Money')
                    ->sum('advancePayment');

                $feeUsersAmount = FeeUser::where('payment_mode', 'Orange Money')
                    ->sum('advancePayment');

                $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                $tab['sommeTotal'] = $totalAmount;
                $tab['sommeRetire'] = $withdrawal;
                $tab['sommeEnCaisse'] = $totalAmount - $withdrawal;
                $tab['sommeTotalDisponible'] = ($totalAmount - $withdrawal); //* 0.98;
                $tab['sommeTotal_1'] = $totalAmount; //* 0.98;
                $tab['sommeRetire_1'] = $withdrawal; //* 0.98;

                $schools = School::select('id', 'name', 'scholar_level', 'idEstablishment')->get();
                $tab['schools'] = $schools;

                if ($schools->isNotEmpty()) {
                    for ($i = 0; $i < count($schools); $i++) {
                        $withdrawal = $query_withdrawal->where('idSchool', $schools[$i]['id'])
                            ->sum('montant_retrait_brut');

                        $schoolName = $query_schoolName->where('id', $schools[$i]['id'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $schools[$i]['id'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $schools[$i]['id'])
                            ->where('payment_mode', 'Orange Money')
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schools'][$i]['etablissment'] = $schoolName->establishment->name;
                        $tab['schools'][$i]['rib'] = $schoolName->establishment->rib;
                        $tab['schools'][$i]['banque'] = $schoolName->establishment->banque;
                        $tab['schools'][$i]['numero_retrait'] = $schoolName->establishment->om;
                        $tab['schools'][$i]['mobile_money_number'] = $schoolName->establishment->mobile_money_number;
                        $tab['schools'][$i]['idSchool'] = $schoolName->id;
                        $tab['schools'][$i]['schoolName'] = $schoolName->name;
                        $tab['schools'][$i]['schoolLevel'] = $schoolName->scholar_level;
                        $tab['schools'][$i]['sommeTotal'] = $totalAmount;
                        $tab['schools'][$i]['sommeRetire'] = $withdrawal;
                        $tab['schools'][$i]['sommeEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['schools'][$i]['sommeTotalDisponible'] = ($totalAmount - $withdrawal); //* 0.98;
                        $tab['schools'][$i]['sommeTotal_1'] = $totalAmount; //* 0.98;
                        $tab['schools'][$i]['sommeRetire_1'] = $withdrawal; //* 0.98;

                    }
                }


                return $this->sendResponses($tab);
            }


        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function dashboardComptable(DashFounderRequest $request)
    {
        try {
            $idSchool = $request['idSchool'];
            $idSection = $request['idSection'];

            /**
             * le total montant des frais payés au sein de l’établissement
             */
            $paid_fees = FeeUser::where('idSchool', $idSchool)
                ->when($request['idSection'] !== null, function ($query) use ($idSection) {
                    $query->where('idSection', $idSection);
                })
                ->sum('advancePayment');

            /**
             * le total montant des tranches payées au sein de l’établissement
             */
            $slices_paid = 0;

            /**
             * le total montant des pensions payées au sein de l’établissement
             */
            $pensions_paid = 0;

            /**
             * le nombre d’élèves insolvables
             * Je récupère tous les étudiants de l'école et je récupère ceux qui sont solvables et je compare les 2 tableaux pour ne garder que ceux qui n'ont pas fini
             */
            $all_students = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.id', 8)
                ->where('users.idSchool', $idSchool)
                ->when($request['idSection'] !== null, function ($query) use ($idSection) {
                    $query->where('users.idSection', $idSection);
                })
                ->where('users.deleted', 0)
                ->select('users.id')
                ->pluck('id')
                ->toArray();

            $users_solvable = DB::table('pension_users')
                ->join('users', 'users.id', '=', 'pension_users.idStudent')
                ->join('levels', 'levels.id', '=', 'users.idLevel')
                ->join('pensions', 'pensions.idLevel', '=', 'levels.id')
                ->select(
                    'pension_users.idStudent',
                    DB::raw('SUM(pension_users.advancePayment) as totalPaid'),
                    'users.name',
                    'users.id',
                    'pensions.price as totalToPay'
                )
                ->groupBy('pension_users.idStudent', 'users.name', 'users.id', 'pensions.price')
                ->havingRaw('SUM(pension_users.advancePayment) = pensions.price')
                ->pluck('users.id')
                ->toArray();

            $users_innsolvables = array_unique(array_diff($all_students, $users_solvable));

            /**
             * le montant total des frais restants à payer
             */
            $total_fees_to_be_paid = 0;

            /**
             * le montant total des tranches à payer
             */
            $total_slices_paid_to_be_paid = 0;

            return $this->sendResponses([
                'paid_fees' => $paid_fees,
                'slices_paid' => $slices_paid,
                'pensions_paid' => $pensions_paid,
                'nbre_eleves_involvables' => count($users_innsolvables),
                'total_fees_to_be_paid' => $total_fees_to_be_paid,
                'total_slices_paid_to_be_paid' => $total_slices_paid_to_be_paid,
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver/Restorer un groupe d'utilisateurs
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function deleteInBulk(UserDeleteBulkRequest $request)
    {
        try {
            $action = ($request->action == "restore") ? 0 : 1;

            $usersids = $request['usersids'];

            User::whereIn('id', $usersids)->update(['deleted' => $action]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier la classe (et infos associées) d'une liste d'utilisateurs
     *
     * @param SwitchUsersClasseRequest $request
     * @return Response|void
     */
    public function switchUserClasse(SwitchUsersClasseRequest $request)
    {
        try {
            DB::beginTransaction();

            $classe = Classes::findOrFail($request->idClasse);

            $users = User::select('users.id as id', 'users.name as name', 'users.idClasse as idClasse', 'users.idSchool as idSchool', 'users.idSection as idSection', 'users.idLevel as idLevel', 'users.idOptionLevel as idOptionLevel')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->join('schools', 'schools.id', '=', 'users.idSchool')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->where('roles.id', 8)
                ->where('users.deleted', 0)
                ->whereIn('users.id', $request->idUsers)
                ->get();

            $logs = array();

            foreach ($users as $user) {
                // Sauvegarde les anciennes valeurs pour le log après commit
                $oldIdClasse = $user->idClasse;

                $user->idClasse = $classe->id;
                $user->idSchool = $classe->idSchool;
                $user->idSection = $classe->idSection;
                $user->idLevel = $classe->idLevel;
                $user->idOptionLevel = $classe->idOptionLevel;

                $user->save();

                $logs[] = "idClasse d'un élève changé. idUser:{$user->id} --- old idClasse:{$oldIdClasse} --- new idClasse:{$classe->id}";
            }

            DB::commit();

            // Écrire les logs seulement après le commit
            foreach ($logs as $log) {
                Log::critical($log);
            }

            return $this->sendResponse($users, "Classe des élèves m.a.j avec succès!");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier la classe secondaire d'une liste d'utilisateurs
     *
     * @param SwitchUsersClasseSecondaireRequest $request
     * @return Response|void
     */
    public function switchUserClasseSecondaire(SwitchUsersClasseSecondaireRequest $request)
    {
        try {
            DB::beginTransaction();

            $classe = Classes::findOrFail($request->idClasseSecondaire);

            $users = User::select('users.id as id', 'users.name as name', 'users.idClasse2 as idClasse2')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
//                ->join('schools', 'schools.id', '=', 'users.idSchool')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->where('roles.id', 8)
                ->where('users.deleted', 0)
                ->whereIn('users.id', $request->idUsers)
                ->get();

            $logs = array();

            foreach ($users as $user) {
                // Sauvegarde les anciennes valeurs pour le log après commit
                $oldIdClasse = $user->idClasse2;

                $user->idClasse2 = $classe->id;
                $user->save();

                $logs[] = "idClasse2 d'un élève changé. idUser:{$user->id} --- old idClasse2:{$oldIdClasse} --- new idClasse2:{$classe->id}";
            }

            DB::commit();

            // Écrire les logs seulement après le commit
            foreach ($logs as $log) {
                Log::critical($log);
            }

            return $this->sendResponse($users, "Classe secondaire des élèves m.a.j avec succès!");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Vérifier la solvabilité d'un élève à une période donnée
     * @param $id
     * @return JsonResponse|void
     */
    public function solvency(StudentSolvencyRequest $request)
    {
        try {
            $studentSolvencyDetails = [];

            foreach ($request["ids"] as $id){
                $user = User::find($id);
                // Récupération des informations de la classe de l'utilisateur

                $classe = $user->idClasse
                    ? Classes::find($user->idClasse)
                    : null;

                if ($user && $classe){
                    $idSchool = $classe->idSchool;
                    $idSection = $classe->idSection;
                    $idLevel = $classe->idLevel;
                    $idOptionLevel = $classe->idOptionLevel;

                    // Date du jour sans heure
                    $today = Carbon::today();

                    // Récupération des frais échus
                    $fees = Fee::select("id", "name", "price", "deadline")
                        ->where('deadline', '<', $today)
                        ->where('idSchool', $idSchool)
                        ->where('idSection', $idSection)
                        ->when($idOptionLevel, function ($query, $idOptionLevel) {
                            return $query->where('idOptionLevel', $idOptionLevel);
                        })
                        ->when($idLevel, function ($query, $idLevel) {
                            return $query->whereHas('levels', function ($q) use ($idLevel) {
                                $q->where('levels.id', $idLevel);
                            });
                        })
                        ->get();

                    // Récupération des tranches échues
                    $tranches = Tranche::select("id", "name", "price", "deadline")
                        ->where('deadline', '<', $today)
                        ->where('idSchool', $idSchool)
                        ->where('idSection', $idSection)
                        ->whereHas('pension', function ($query) use ($idLevel, $idOptionLevel) {
                            $query->when($idOptionLevel, function ($q) use ($idOptionLevel) {
                                return $q->where('idOptionLevel', $idOptionLevel);
                            })
                                ->when(!$idOptionLevel, function ($q) use ($idLevel) {
                                    return $q->where('idLevel', $idLevel);
                                });
                        })
                        ->get();

                    // On vérifie que chaque frais a été soldé
                    $fees = collect($fees)->each(function ($fee) use ($id) {
                        // Vérifiez si le frais est soldé
                        $feeUsers = FeeUser::where('idStudent', $id)
                            ->where('idFee', $fee['id'])
                            ->get()
                            ->toArray();

                        if ($feeUsers && collect($feeUsers)->contains(function ($feeUser) {return $feeUser['solvable'] === 'terminé';})){
                            $fee['isSolvable'] = true;
                        }
                        else{
                            $fee['isSolvable'] = false;

                            $fee['deja_payer'] = array_sum(array_column($feeUsers, 'advancePayment'));
                            $fee['reste_a_payer'] = $fee['price'] - $fee['deja_payer'] ;
                        }
                        return $fee;
                    });

                    $isSolvable = true;

                    // On vérifie que chaque frais a été soldé
                    $tranches = collect($tranches)->each(function ($tranche) use ($id, &$isSolvable) {
                        // Vérifiez si le frais est soldé
                        $pensionUsers = PensionUser::where('idStudent', $id)
                            ->where('idTranche', $tranche['id'])
                            ->get()
                            ->toArray();

                        if ($pensionUsers && collect($pensionUsers)->contains(function ($pensionUser) {return $pensionUser['solvable'] === 'terminé';})){
                            $tranche['isSolvable'] = true;
                        }
                        else{
                            $isSolvable = false;

                            $tranche['isSolvable'] = false;

                            $tranche['deja_payer'] = array_sum(array_column($pensionUsers, 'advancePayment'));
                            $tranche['reste_a_payer'] = $tranche['price'] - $tranche['deja_payer'];
                        }

                        return $tranche;
                    });

                    $studentSolvencyDetails[] = [
                        'isSolvable' => $isSolvable,
                        'user' => new StudentResource($user),
                        'classe' => new ClassResource($classe),
                        'fees' => $fees,
                        'tranches' => $tranches,
                    ];
                }
            }

            if (count($studentSolvencyDetails) > 0){
                return $this->sendResponse($studentSolvencyDetails, "État de solvabilité récupéré avec succès.");
            }
            else{
                return $this->sendError("Aucun état de solvabilité trouvé");
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function modifyAnnualDecision(AnnualDecisionRequest $request){
        try {
            set_time_limit(600);

            $annualDecisions = $request['annualDecisions'] ?? [];
            $GeneralAnnualDecisions = [];
            $idClasse = $request['idClasse'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $successValue = $request['successValue'] ?? 10;
            $automatic = $request['automatic'] ?? false;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $admissionText = $request['admissionText'] ?? 'admitted';

            $repeatText = $request['repeatText'] ?? 'failed';

            //si automatique, on calcule la decision de tout le monde
            //dans le cas contraire, on applique les décisions qui ont été définis
            if (($idSchool || $idClasse) && $automatic){
                $annualDecisions = [] ; //refaire pour tout le monde lorsque c'est automatique

                //On applique le filtre pour recuperer les éleves consernés
                $classes = User::query()
                    ->whereHas('roles', function ($query) {
                        $query->where('id', 8); // Rôle élève
                    })
                    ->whereHas('classe', function ($query) use ($idClasse, $idSchool) {
                        if (!is_null($idClasse)) {
                            $query->where('id', $idClasse);
                        }
                        if (!is_null($idSchool)) {
                            $query->where('idSchool', $idSchool);
                        }
                    })
                    ->with(['classe', 'roles'])
                    ->get()
                    ->groupBy(function ($user) {
                        return $user->classe->id; // Grouper par ID de classe (ou autre champ comme name)
                    })
                    ->toArray();


                foreach ($classes as $idClasse => $students) {
                    $idOptionLevels = Assessment::where('idClasse', $idClasse)
                        ->whereHas('matter', function ($query) {
                            $query->whereNotNull('idOptionLevel');
                        })
                        ->with('matter:id,idOptionLevel') // Optimisation : charge uniquement les colonnes nécessaires
                        ->get()
                        ->pluck('matter.idOptionLevel')
                        ->unique()
                        ->values()
                        ->toArray();

                    if (empty($idOptionLevels)){
                        $idOptionLevels = [null];
                    }

                    foreach ($students as $student){
                        $scholarLevel =  User::find($student['id'])->school->scholar_level;

                        $request['primary'] = ($scholarLevel == "Primary" || $scholarLevel == "Nursery");

                        $moyenneAnnuelle = null;

                        //Pour chaque élève on récupère les evaluations annuelles sur toutes les options de niveau
                        foreach ($idOptionLevels as $idOptLev){
                            $newRequest = [
                                'idUser' => $student['id'],
                                'idOptionLevel' => $idOptLev
                            ];

                            $bulletinPrimaireController = new BulletinPrimaireController(
                                new PensionUserService()
                            );
                            $bulletinSecondaireController = new BulletinSecondaireController(
                                new PensionUserService()
                            );

                            if ($request['primary']) {
                                $moyenneAnnuelle = $bulletinPrimaireController->afficherNotesPrimaire2($newRequest)['moyenneAnnuelle'];
                            }else{
                                $moyenneAnnuelle = $bulletinSecondaireController->afficherNotesSecondaire2($newRequest)['moyenneAnnuelle'];
                            }

                            if ($moyenneAnnuelle >= $successValue){
                                $annualDecisions []= [
                                    'idOptionLevel' => $idOptLev,
                                    'idStudent' => $student['id'],
                                    'decision' => $admissionText
                                ];
                            }else{
                                $annualDecisions []= [
                                    'idOptionLevel' => $idOptLev,
                                    'idStudent' => $student['id'],
                                    'decision' => $repeatText
                                ];
                            }
                        }
                    }
                }
            }

            $studentIds = collect($annualDecisions)->pluck('idStudent')->unique();
            $users = User::whereIn('id', $studentIds)->get()->keyBy('id');

            foreach ($annualDecisions ?? [] as $annualDecision) {
                if (isset($users[$annualDecision['idStudent']]) && isset($annualDecision['decision'])) {
                    if (isset($idOptionLevel) || isset($annualDecision['idOptionLevel'])){
                        AnnualDecision::updateOrCreate(
                            [ // Critères de recherche
                                'idOptionLevel' => $annualDecision['idOptionLevel'] ?? $idOptionLevel,
                                'idUser' => $annualDecision['idStudent'],
                            ],
                            [ // Données à créer ou mettre à jour
                                'decision' => $annualDecision['decision'],
                                'created_by' => Auth()->id(),
                                'updated_by' => Auth()->id(),
                            ]
                        );
                    }else{
                        $users[$annualDecision['idStudent']]->update([
                            'annualDecision' => $annualDecision['decision']
                        ]);
                    }
                }
            }

            return StudentResource::collection($users);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modification des décisions annuelles avec calcul correct des moyennes
     * Utilise la même logique que genererBulletinPrimaireSmart/générerBulletinSecondaireSmart
     */
    public function modifyAnnualDecisionSmart(AnnualDecisionRequest $request)
    {
        try {
            set_time_limit(600);

            $annualDecisions = $request['annualDecisions'] ?? [];
            $idClasse = $request['idClasse'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $successValue = $request['successValue'] ?? 10;
            $automatic = $request['automatic'] ?? false;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $admissionText = $request['admissionText'] ?? 'admitted';
            $repeatText = $request['repeatText'] ?? 'failed';

            $bulletinPrimaireController = new BulletinPrimaireController(new PensionUserService());
            $bulletinSecondaireController = new BulletinSecondaireController(
                new PensionUserService()
            );

            //si automatique, on calcule la decision de tout le monde
            if (($idSchool || $idClasse) && $automatic) {
                $annualDecisions = [];

                //On applique le filtre pour recuperer les éleves consernés
                $elevesQuery = User::query()
                    ->whereHas('roles', function ($query) {
                        $query->where('id', 8); // Rôle élève
                    })
                    ->whereHas('classe', function ($query) use ($idClasse, $idSchool) {
                        if (!is_null($idClasse)) {
                            $query->where('id', $idClasse);
                        }
                        if (!is_null($idSchool)) {
                            $query->where('idSchool', $idSchool);
                        }
                    })
                    ->with(['classe.school', 'roles'])
                    ->get();

                foreach ($elevesQuery as $eleve) {
                    $idEleve = $eleve->id;
                    $idClasseEleve = $eleve->idClasse;
                    $scholarLevel = $eleve->school->scholar_level ?? 'Primary';

                    // Récupérer les idOptionLevel pour le bulletin
                    $idOptionLevels = Assessment::where('idClasse', $idClasseEleve)
                        ->whereHas('matter', function ($query) {
                            $query->whereNotNull('idOptionLevel');
                        })
                        ->with('matter:id,idOptionLevel')
                        ->get()
                        ->pluck('matter.idOptionLevel')
                        ->unique()
                        ->values()
                        ->toArray();

                    if (empty($idOptionLevels)) {
                        $idOptionLevels = [null];
                    }

                    foreach ($idOptionLevels as $idOptLev) {
                        // Calculer la moyenne avec la méthode appropriée selon le niveau
                        $isPrimary = in_array(strtolower($scholarLevel), ['primary', 'primaire', 'nursery', 'maternelle']);

                        if ($isPrimary) {
                            $moyenneAnnuelle = $bulletinPrimaireController->calculateAnnualMoyennePrimaire($idClasseEleve, $idEleve, $idOptLev);
                        } else {
                            $moyenneAnnuelle = $bulletinSecondaireController->calculateAnnualMoyenneForDecision($idClasseEleve, $idEleve, $idOptLev);
                        }

                        if ($moyenneAnnuelle !== null) {
                            if ($moyenneAnnuelle >= $successValue) {
                                $annualDecisions[] = [
                                    'idOptionLevel' => $idOptLev,
                                    'idStudent' => $idEleve,
                                    'decision' => $admissionText
                                ];
                            } else {
                                $annualDecisions[] = [
                                    'idOptionLevel' => $idOptLev,
                                    'idStudent' => $idEleve,
                                    'decision' => $repeatText
                                ];
                            }
                        }
                    }
                }
            }

            $studentIds = collect($annualDecisions)->pluck('idStudent')->unique();
            $users = User::whereIn('id', $studentIds)->get()->keyBy('id');

            foreach ($annualDecisions ?? [] as $annualDecision) {
                if (isset($users[$annualDecision['idStudent']]) && isset($annualDecision['decision'])) {
                    if (isset($idOptionLevel) || isset($annualDecision['idOptionLevel'])) {
                        AnnualDecision::updateOrCreate(
                            [
                                'idOptionLevel' => $annualDecision['idOptionLevel'] ?? $idOptionLevel,
                                'idUser' => $annualDecision['idStudent'],
                            ],
                            [
                                'decision' => $annualDecision['decision'],
                                'created_by' => Auth()->id(),
                                'updated_by' => Auth()->id(),
                            ]
                        );
                    } else {
                        $users[$annualDecision['idStudent']]->update([
                            'annualDecision' => $annualDecision['decision']
                        ]);
                    }
                }
            }

            return StudentResource::collection($users);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Lister les utilisateurs ayant déjà versé un certain montant
     * @param UserPaymentRequest $request
     * @return JsonResponse
     */
    public function payments(UserPaymentRequest $request)
    {
        try {
            $data = $request->validated();

            $idClasse  = isset($data['idClasse']) ? $data['idClasse'] : null;
            $idSection = isset($data['idSection']) ? $data['idSection'] : null;
            $idSchool  = isset($data['idSchool']) ? $data['idSchool'] : null;
            $filterHasPaid = isset($data['hasPaid']) ? $data['hasPaid'] : true;
            $paymentThreshold = isset($data['payment']) ? $data['payment'] : 0;

            // 🔹 Sous-requêtes paiements
            $pensionSub = PensionUser::selectRaw('idStudent, SUM(advancePayment) as totalPension')
                ->where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    $q->where('idSection', $idSection);
                })
                ->groupBy('idStudent');

            $feeSub = FeeUser::selectRaw('idStudent, SUM(advancePayment) as totalFee')
                ->where('idSchool', $idSchool)
                ->when($idSection, function ($q) use ($idSection) {
                    $q->where('idSection', $idSection);
                })
                ->groupBy('idStudent');

            // 🔹 Requête principale avec bourse
            $studentsQuery = User::students() // <-- ne prend que les étudiants
            ->selectRaw('users.*,
                     COALESCE(p.totalPension,0)+COALESCE(f.totalFee,0) as totalPaid,
                     bourses.id as bourse_id,
                     bourses.name as bourse_name,
                     COALESCE(bourses.amount,0) as bourse_amount')
                ->leftJoinSub($pensionSub, 'p', 'users.id', '=', 'p.idStudent')
                ->leftJoinSub($feeSub, 'f', 'users.id', '=', 'f.idStudent')
                ->leftJoin('bourses', 'users.idBourse', '=', 'bourses.id')
                ->where('users.idSchool', $idSchool)
                ->with('classe:id,name,idLevel,idOptionLevel')
                ->orderBy('users.name', 'asc');


            if ($idClasse) {
                $studentsQuery->where('users.idClasse', $idClasse);
            } elseif ($idSection) {
                $studentsQuery->where('users.idSection', $idSection);
            }

            // 🔹 Filtrage selon paiement
            if ($filterHasPaid) {
                $studentsQuery->havingRaw('totalPaid >= ?', [$paymentThreshold]);
            } else {
                $studentsQuery->havingRaw('totalPaid < ?', [$paymentThreshold]);
            }

            // 🔹 Requête complète pour statistiques (avant pagination)
            $studentsForTotalsQuery = clone $studentsQuery;

            // 🔹 Pagination
            $page    = isset($data['pageItems']) ? (int) $data['pageItems'] : 1;
            $perPage = isset($data['nbreItems']) ? (int) $data['nbreItems'] : 10000;
            $studentsPaginated = $studentsQuery->paginate($perPage, ['*'], 'page', $page);

            // 🔹 Totaux pensions par niveau
            $pensionTotals = Pension::selectRaw('idLevel, idOptionLevel, SUM(price) as total')
                ->where('idSchool', $idSchool)
                ->groupBy('idLevel', 'idOptionLevel')
                ->get();

            $pensionTotalsKeyed = [];
            foreach ($pensionTotals as $p) {
                $key = $p->idLevel . '-' . $p->idOptionLevel;
                $pensionTotalsKeyed[$key] = $p->total;
            }

            // 🔹 Totaux frais par niveau
            $feeTotals = Fee::join('fee_has_level', 'fees.id', '=', 'fee_has_level.fee_id')
                ->where('fees.idSchool', $idSchool)
                ->selectRaw('fee_has_level.level_id, SUM(fees.price) as total')
                ->groupBy('fee_has_level.level_id')
                ->get();

            $feeTotalsKeyed = [];
            foreach ($feeTotals as $f) {
                $feeTotalsKeyed[$f->level_id] = $f->total;
            }

            $computeAmounts = function ($student) use ($pensionTotalsKeyed, $feeTotalsKeyed) {

                $idLevel = isset($student->classe->idLevel) ? $student->classe->idLevel : null;
                $idOption = isset($student->classe->idOptionLevel) ? $student->classe->idOptionLevel : null;

                $keyPension = $idLevel . '-' . $idOption;
                $totalPension = isset($pensionTotalsKeyed[$keyPension]) ? $pensionTotalsKeyed[$keyPension] : 0;
                $totalFee = isset($feeTotalsKeyed[$idLevel]) ? $feeTotalsKeyed[$idLevel] : 0;

                $totalClasse = $totalPension + $totalFee;

                // 🔹 Application de la bourse
                $bourseId = !empty($student->bourse_id) ? (int) $student->bourse_id : null;
                $bourseName = !empty($student->bourse_name) ? $student->bourse_name : null;
                $bourseAmount = isset($student->bourse_amount) ? (float)$student->bourse_amount : 0;
                $isBourseUsed = !empty($student->isBourseUsed);

                $montantRestant = $totalClasse - $student->totalPaid;
                if ($montantRestant < 0) $montantRestant = 0;

                $montantReelRestant = $montantRestant;
                if ($bourseId && $isBourseUsed) {
                    $montantReelRestant = $montantRestant - $bourseAmount;
                    if ($montantReelRestant < 0) $montantReelRestant = 0;
                }
                return [
                    'totalClasse' => $totalClasse,
                    'montantRestant' => $montantRestant,
                    'montantReelRestant' => $montantReelRestant,
                    'bourseId' => $bourseId,
                    'bourseName' => $bourseName,
                    'bourseAmount' => $bourseAmount,
                ];
            };

            // 🔹 Transformation finale
            $studentsTransformed = $studentsPaginated->getCollection()->map(function ($student) use ($computeAmounts) {
                $amounts = $computeAmounts($student);
                return [
                    'student' => [
                        'id'     => $student->id,
                        'name'   => $student->name,
                        'classe' => [
                            'id'   => isset($student->classe->id) ? $student->classe->id : null,
                            'name' => isset($student->classe->name) ? $student->classe->name : null,
                        ],
                        'bourse' => $amounts['bourseId'] ? [
                            'id'     => $amounts['bourseId'],
                            'name'   => $amounts['bourseName'],
                            'amount' => $amounts['bourseAmount'],
                        ] : null,
                    ],
                    'montantPaye'     => (float) $student->totalPaid,
                    'totalClasse'     => (float) $amounts['totalClasse'],
                    'montantRestant'  => (float) $amounts['montantRestant'],
                    'montant_reel_restant' => (float) $amounts['montantReelRestant'],
                ];
            });

            $studentsPaginated->setCollection($studentsTransformed);

            // 🔹 Statistiques globales (tous les élèves)
            $stats = [
                'total_montant_paye' => 0.0,
                'total_montant_restant' => 0.0,
                'total_reel_montant_restant' => 0.0,
            ];

            $studentsForTotals = $studentsForTotalsQuery->get();
            foreach ($studentsForTotals as $student) {
                $amounts = $computeAmounts($student);
                $stats['total_montant_paye'] += (float) $student->totalPaid;
                $stats['total_montant_restant'] += (float) $amounts['montantRestant'];
                $stats['total_reel_montant_restant'] += (float) $amounts['montantReelRestant'];
            }

            $response = $studentsPaginated->toArray();
            $response['statistique'] = $stats;

            return response()->json($response);

        } catch (\Throwable $th) {
            \Log::critical('Erreur lors de la récupération des paiements : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('app.error_occured'),
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Afficher tous les informations d'un etudiant
     * @param UsersStudentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersstudent(UsersStudentRequest $request)
    {
        try {
            $data = $request->validated();

            $idStudent = $data['idStudent'];
            $idSchool = isset($data['idSchool']) ? $data['idSchool'] : null;
            $idSection = isset($data['idSection']) ? $data['idSection'] : null;

            $studentQuery = User::students()->with('classe');

            if (!is_null($idSchool)) {
                $studentQuery->where('users.idSchool', $idSchool);
            }
            if (!is_null($idSection)) {
                $studentQuery->where('users.idSection', $idSection);
            }

            $student = $studentQuery->where('users.id', $idStudent)->first();

            if (!$student) {
                return $this->sendError('Étudiant non trouvé', null, 404);
            }

            $classe = $student->classe;
            $idClasse = $student->idClasse;

            $groups = [
                'structure' => [
                    'classe' => $classe,
                ],
                'organisation' => [
                    'events' => Event::whereRaw("FIND_IN_SET(?, classes)", [$idClasse])->get(),
                    'suggestions' => Suggestion::where('user_id', $student->idParent)->get(),
                ],
                'finances' => [
                    'pensions' => PensionUser::where('idStudent', $student->id)->get(),
                    'totalpaid_pension' => PensionUser::where('idStudent', $student->id)->sum('advancePayment'),
                    'fees' => FeeUser::where('idStudent', $student->id)->get(),
                    'totalpaid_fee' => FeeUser::where('idStudent', $student->id)->sum('advancePayment'),
                    'totalpaid' => PensionUser::where('idStudent', $student->id)->sum('advancePayment') + FeeUser::where('idStudent', $student->id)->sum('advancePayment'),
                    'pension' => [
                        'totalamount' => $this->getTotalPensionAmount($student),
                        'totalpaid' => PensionUser::where('idStudent', $student->id)->sum('advancePayment'),
                        'totalrest' => $this->getTotalPensionRest($student),
                    ],
                    'feeinfo' => $this->getFeeInfo($student),
                   // 'withdrawals' => Withdrawal::where('idStudent', $student->id)->get(),
                    'scan_receipts' => ScanReceipt::where('idStudent', $student->id)->get(),
                ],
                
                'discipline' => [
                    'delays' => SchoolDelay::where('idStudent', $student->id)->get(),
                    'absences' => Absence::where('idStudent', $student->id)->get(),
                    'sanctions' => Sanction::where('idUser', $student->id)->get(),
                    'observations' => TeacherObservation::where('idStudent', $student->id)->get(),
                    'requetes' => Requete::where('idUser', $student->id)->get(),
                ],
                'pedagogy' => [
                    'courses' => Course::where('idClasse', $idClasse)->get(),
                    'homeworks' => Homework::where('idClasse', $idClasse)->get(),
                   // 'matters' => Matter::where('idClasse', $idClasse)->get(),
                ],
                'evaluations' => [
                    'assessments' => Assessment::where('idClasse', $idClasse)->get(),
                    'ratings' => Rating::where('idStudent', $student->id)->get(),
                ],
                'transport' => [
                    'transport_user' => TransportUser::where('student_id', $student->id)->get(),
                ],
            ];

            return $this->sendResponses((new StudentGroupedResource($student, $groups))->toArray($request));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


   
    private function getTotalPensionAmount($student)
    {
        $levelId = $student->classe->idLevel ?? null;
 
        if (!$levelId) {
            return 0;
        }
 
       
        $pension = Pension::where('idLevel', $levelId)
            ->where('idSchool', $student->idSchool)
            ->where('idSection', $student->idSection)
            ->first();
 
        return $pension ? $pension->price : 0;
    }

    private function getTotalPensionRest($student)
    {
        $totalAmount = $this->getTotalPensionAmount($student);
        $totalPaid = PensionUser::where('idStudent', $student->id)->sum('advancePayment');
 
        return max(0, $totalAmount - $totalPaid);
    }
 
   
    private function getFeeInfo($student)
    {
        
        $levelId = $student->classe->idLevel ?? null;
 
        if (!$levelId) {
            return [];
        }
 
       
        $fees = Fee::whereHas('levels', function($query) use ($levelId) {
            $query->where('level_id', $levelId);
        })
        ->where('idSchool', $student->idSchool)
        ->where('idSection', $student->idSection)
        ->get();
 
        $feeInfo = [];
 
        foreach ($fees as $fee) {
        
            $totalPaid = FeeUser::where('idStudent', $student->id)
                ->where('idFee', $fee->id)
                ->sum('advancePayment');
 
            $feeInfo[] = [
                'id' => $fee->id,
                'name' => $fee->name,
                'price' => $fee->price,
                'total_paid' => $totalPaid,
                'remaining' => max(0, $fee->price - $totalPaid),
            ];
        }
 
        return $feeInfo;
    }

}