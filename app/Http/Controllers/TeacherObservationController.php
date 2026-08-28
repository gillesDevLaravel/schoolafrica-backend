<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherObservationGetRequest;
use App\Models\Establishment;
use App\Models\Notification;
use App\Models\School;
use App\Models\User;
use App\Traits\NotificationsTrait;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\TeacherObservationResource;
use App\Http\Requests\Staffs\TeacherObservationRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\TeacherObservation;
use Google\Service\Classroom\Student;
use Illuminate\Support\Facades\Log;

/**
 * @group Teacher Observation
 */
class TeacherObservationController extends BaseController
{
    use NotificationsTrait;

    /**
     * Afficher la liste des observations des enseignants
     *
     * @param TeacherObservationGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(TeacherObservationGetRequest $request)
    {
        try {
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idAssessment = $request['idAssessment'] ?? null;
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $teacherObservations = TeacherObservation::where('idSchool',$request['idSchool']);

            if(!is_null($idSection)) $teacherObservations = $teacherObservations->where('idSection',$request['idSection']);
            if(!is_null($idClasse)) $teacherObservations = $teacherObservations->where('idClasse',$request['idClasse']);
            if(!is_null($idTeacher)) $teacherObservations = $teacherObservations->where('idTeacher',$request['idTeacher']);
            if(!is_null($idStudent)) $teacherObservations = $teacherObservations->where('idStudent',$request['idStudent']);
            if(!is_null($idTeacher)) $teacherObservations = $teacherObservations->where('idTeacher',$request['idTeacher']);
            if(!is_null($idAssessment)) $teacherObservations = $teacherObservations->where('idAssessment',$request['idAssessment']);
            if (!is_null($date_start) && !is_null($date_end)) {
              // Filtrer entre les deux dates
            $teacherObservations = $teacherObservations->whereBetween('created_at', [$date_start, $date_end]);
            } elseif (!is_null($date_start)) {
             // Filtrer à partir de la date de début
            $teacherObservations = $teacherObservations->whereDate('created_at', '>=', $date_start);
            } elseif (!is_null($date_end)) {
             // Filtrer jusqu'à la date de fin
            $teacherObservations = $teacherObservations->whereDate('created_at', '<=', $date_end);
            }

            

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $teacherObservations->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return TeacherObservationResource::collection(
                $teacherObservations
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une observation
     *
     * @param TeacherObservationRequest $request
     * @return TeacherObservationResource|\Illuminate\Http\Response
     */
    public function store(TeacherObservationRequest $request)
    {
        try {
            $validated = $request->validated();

            // Cas 1 : un seul élève ciblé
            if ($request->idStudent) {
                $student = User::find($request->idStudent);
                if (!$student) {
                    return $this->sendError(__('app.student_not_found'), null, 404);
                }

                $observation = $this->createObservationForStudent($student, $validated, $request);
                return new TeacherObservationResource($observation);
            }

            // Cas 2 : une classe entière
            if ($request->idClasse) {
                $students = User::select('users.*')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('roles.id', 8) // rôle élèves
                    ->where('users.idClasse', $request->idClasse)
                    ->where('users.deleted', 0)
                    ->get();

                if ($students->isEmpty()) {
                    return $this->sendError(__('app.no_students_in_class'), null, 404);
                }

                $observations = [];
                foreach ($students as $student) {
                    $observations[] = $this->createObservationForStudent($student, $validated, $request);
                }

                return TeacherObservationResource::collection($observations);
            }

            return $this->sendError(__('app.missing_parameters'), null, 400);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée une observation et notifie pour un élève donné
     */
    private function createObservationForStudent(User $student, array $validated, $request)
    {
        $observation = TeacherObservation::create([
            'description'  => isset($validated['description']) ? $validated['description'] : null,
            'answer'       => isset($validated['answer']) ? $validated['answer'] : null,
            'idAssessment' => $request->idAssessment,
            'idStudent'    => $student->id,
            'idClasse'     => $student->idClasse,
            'idSchool'     => $student->idSchool,
            'idSection'    => $student->idSection,
            'idTeacher'    => $request->idTeacher,
            'created_by'   => auth()->id(),
        ]);

        // Infos école + fondateur
        $school    = School::find($student->idSchool);
        $idFounder = $school ? Establishment::find($school->idEstablishment)->idFounder : null;

        // Infos professeur + destinataire
        $teacher       = User::find($request->idTeacher);
        $teacher_name  = $teacher ? $teacher->name : 'Unknown';
        $recipient_id  = ($school && in_array($school->scholar_level, ["University", "CF"]))
            ? $student->id
            : ($student->idParent ? optional(User::find($student->idParent))->id : null);

        // Notification
        $grouped_users = array_filter([$idFounder, $recipient_id]);
        if (!empty($grouped_users)) {
            Notification::create([
                'notificationable_type' => TeacherObservation::class,
                'notificationable_id'   => $observation->id,
                'title'       => __('notifs.observation_title', [
                    'student_name' => $student->name,
                    'student_classe' => $student->idClasse,
                    'teacher_name' => $teacher_name
                ]),
                'description' => $observation->description,
                'answer'      => $observation->answer,
                'user_id'     => null,
                'grouped_users' => json_encode($grouped_users)
            ]);
        }

        return $observation;
    }

    /**
     * Afficher les détails d'une observation
     *
     * @param TeacherObservation $teacherObservation
     * @param $id
     * @return TeacherObservationResource|\Illuminate\Http\Response
     */
    public function show(TeacherObservation $teacherObservation,$id)
    {
        try {
            $teacherObservation = TeacherObservation::find($id);
            return new TeacherObservationResource($teacherObservation);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une observation
     *
     * @param TeacherObservationRequest $request
     * @param TeacherObservation $teacherObservation
     * @param $id
     * @return TeacherObservationResource|\Illuminate\Http\Response
     */
    public function update(TeacherObservationRequest $request,TeacherObservation $teacherObservation, $id)
    {
        try {
            $teacherObservation = TeacherObservation::find($id);
            $student = User::find($request->idStudent);

            $isAnswer = $teacherObservation->answer !== $request->answer;

            $teacherObservation->description = $request['description'] ?? $teacherObservation['description'];
            $teacherObservation->answer = $request['answer'] ?? $teacherObservation['answer'];
            $teacherObservation->idAssessment = $request['idAssessment'] ?? $teacherObservation['idAssessment'];
            $teacherObservation->idStudent = $request['idStudent'] ?? $teacherObservation['idStudent'];
            $teacherObservation->idClasse = $request['idClasse'] ?? $teacherObservation['idClasse'];
            $teacherObservation->idSchool = $student->idSchool;
            $teacherObservation->idSection = $student->idSection;
            $teacherObservation->idTeacher = $request['idTeacher'] ?? $teacherObservation['idTeacher'];
            $teacherObservation->updated_by = auth()->user()->id;

            $teacherObservation->save();

            if ($isAnswer){
                $user = User::find(auth()->id());
                Notification::create([
                    'notificationable_type' => TeacherObservation::class,
                    'notificationable_id'   => $teacherObservation->id,
                    'title'       => __('notifs.observation_title', [
                        'student_name' => $student->name,
                        'user_name' => $user->name
                    ]),
                    'description' => $teacherObservation->description,
                    'answer'      => $teacherObservation->answer,
                    'user_id'     => $teacherObservation->idTeacher,
                ]);
            }
            return new TeacherObservationResource($teacherObservation);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une observation
     *
     * @param TeacherObservation $teacherObservation
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(TeacherObservation $teacherObservation, $id)
    {
        try {
            $teacherObservation = TeacherObservation::findOrFail($id);
            $teacherObservation->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
