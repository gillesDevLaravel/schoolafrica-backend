<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\InfosGeneralesEcoleSurTrimestreRequest;
use App\Models\Classes;
use App\Models\School;
use App\Models\Section;
use App\Models\Trimestre;
use App\Traits\BulletinSecondaireTrait;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class InfosEcoleController extends BaseController
{
    use BulletinSecondaireTrait;
    public function infosTrimestre(InfosGeneralesEcoleSurTrimestreRequest $request)
    {
//        try {
//            /**
//             * On récupére toutes les classes concernées.
//             * Pour chaque classe, on va récupérer la liste ses moyennes, on s'en sert pour avoir la MG et le %S
//             *
//             * A la fin de la boucle, on obtient aussi la MG de l'école et le %S de l'école!
//             */
//
//            $nameTrimestre = $request['nameTrimestre'];
//
//            $school = School::select('id', 'name','logo')->find($request->idSchool);
////            $section = Section::select('name')->find($request->idSection);
//
//            $sections = Section::select('id', 'name')
//                ->where('idSchool', $request->idSchool)
//                ->when(!is_null($request['idSection']), function($query) use ($request) {
//                    $query->where('id', $request['idSection']);
//                })
//                ->get();
//
//            $infos_ecole = array(); // ['name', 'moy_gen_ecole', '%r_ecole', 'sections' =>[] ]
//            $moyenne_generale_ecole = $pourcentage_reussite_ecole = array(); // on va faire un safeArraySum à la fin
//            $infos_sections = array(); // ['name', 'moy_gen_section', '%r_section', 'classes' =>[] ]
//
//            foreach ($sections as $section) {
//                $infos_classe = array(); // ['name', 'moy_gen_classe', '%r_classe']
//                $tmp_moy_gen_section = array();
//                $tmp_pour_reus_section = array();
//
//                $trimestre = Trimestre::select('id', 'name')
//                    ->where([
//                        'idSchool' => $request->idSchool,
//                        'idSection' => $section->id
//                    ])->when(!is_null($request['idTrimestre']), function($query) use ($nameTrimestre) {
//                        $query->where('name', 'like', "%$nameTrimestre%");
//                    })
//                    ->first();
//
//                $classes = Classes::select('id','name')
//                    ->where([
//                        'idSchool' => $request->idSchool,
//                        'idSection' => $section->id
//                    ])
////                ->orderBy('name')
//                    ->get();
//
//                $sequences = $this->getSequences($trimestre->id);
//
//                if(count($sequences) <= 0){
//                    continue;
//                    return $this->sendError("Les évaluations que vous avez spécifiées sont inexistantes");
//                }
//
//                foreach ($classes as $classe) {
//                    if(count($this->getMatiereEvalueesParGroupe($classe->id)) == 0){
//                        continue;
//                        return $this->sendError("Aucun groupe de matière trouvé pour cette classe");
//                    }
//
//                    $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $classe->id);
//
//                    $resultatsClasse = $this->calculeNotesTotales($evaluationEleves, $classe->id, array_column($sequences, "id"));
//
//                    $mg_classe = []; // on stocke les moyennes des enfants dans un tab puis on fat un safeArraySum
//                    foreach ($resultatsClasse['eleves'] as $idUser => $resultat) {
//                        if($resultat['isEvalue']){
//                            $mg_classe[] = $resultat['moyenne'];
//                        }
//                    }
//
//                    $tmp_moy_gen_classe = safeArraySum($mg_classe, true);
//                    $tmp_pourcentage_reussite = (!empty($mg_classe))
//                        ? count(array_filter($mg_classe, function($moyenne){
//                            return $moyenne >=10;
//                        })) * 100 / count($mg_classe)
//                        : null;
//
//                    if(!is_null($tmp_moy_gen_classe)) $tmp_pour_reus_section[] = $tmp_moy_gen_classe;
//                    if(!is_null($tmp_pourcentage_reussite)) $tmp_pour_reus_section[] = $tmp_pourcentage_reussite;
//
//                    $infos_classe[] = [
//                        'id' => $classe->id,
//                        'name' => $classe->name,
//                        'moyenne_generale_classe' => $tmp_moy_gen_classe,
//                        'pourcentage_reussite_classe' => $tmp_pourcentage_reussite,
//                        'moyennes' => $mg_classe,
//                    ];
//                }
//
//                $tmp_infos_sections = [
//                    'id' => $section->id,
//                    'name' => $section->name,
//                    'moyenne_generale_section' => "wip", //safeArraySum($tmp_pour_reus_section, true),
//                    'pourcentage_reussite_section' => "wip", //safeArraySum($tmp_pour_reus_section, true),
//                    'classes' => $infos_classe
//                ];
//
//                $moyenne_generale_ecole[] = $tmp_infos_sections['moyenne_generale_section'];
//                $pourcentage_reussite_ecole[] = $tmp_infos_sections['pourcentage_reussite_section'];
//
//                $infos_sections[] = $tmp_infos_sections;
//            }
//
//            $infos_ecole = [
//                'id' => $school->id,
//                'name' => $school->name,
//                'logo' => $school->logo,
//                'moyenne_generale_ecole' => "wip", //safeArraySum($moyenne_generale_ecole, true),
//                'pourcentage_reussite_ecole' => "wip", //safeArraySum($pourcentage_reussite_ecole, true),
//                'sections' => $infos_sections
//            ];
//
//
//            return $infos_ecole;
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//            die;
//
////            $moyennes_generales_par_classe = array();
////            $moyenne_generale_ecole = $pourcentage_reussite_ecole = array(); // on va faire un safeArraySum à la fin
////            $infos_par_section = array();
//
//            $moyenne_generale_par_section = array();
//            $pourcentage_reussite_par_section = array();
//
////            foreach ($sections as $section) {
////                $trimestre = Trimestre::select('id', 'name')
////                    ->where([
////                        'idSchool' => $request->idSchool,
////                        'idSection' => $section->id
////                    ])->when(!is_null($request['idTrimestre']), function($query) use ($nameTrimestre) {
////                        $query->where('name', 'like', "%$nameTrimestre%");
////                    })
////                    ->first();
////
////                $classes = Classes::select('id','name')
////                    ->where([
////                        'idSchool' => $request->idSchool,
////                        'idSection' => $section->id
////                    ])
//////                ->orderBy('name')
////                    ->get();
////
////                $sequences = $this->getSequences($trimestre->id);
////
////                foreach ($classes as $classe) {
////
////                    if(count($sequences) <= 0){
////                        continue;
////                        return $this->sendError("Les évaluations que vous avez spécifiées sont inexistantes");
////                    }
////
////                    if(count($this->getMatiereEvalueesParGroupe($classe->id)) == 0){
////                        continue;
////                        return $this->sendError("Aucun groupe de matière trouvé pour cette classe");
////                    }
////
////                    $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $classe->id);
////
////                    $resultatsClasse = $this->calculeNotesTotales($evaluationEleves, $classe->id, array_column($sequences, "id"));
////
////                    $mg_classe = []; // on stocke les moyennes des enfants dans un tab puis on fat un safeArraySum
////                    foreach ($resultatsClasse['eleves'] as $idUser => $resultat) {
////                        if($resultat['isEvalue']){
////                            $mg_classe[] = $resultat['moyenne'];
////                        }
////                    }
////
////                    $tmp_moy_gen_classe = safeArraySum($mg_classe, true);
////                    $tmp_pourcentage_reussite = (!empty($mg_classe))
////                        ? count(array_filter($mg_classe, function($moyenne){
////                            return $moyenne >=10;
////                        })) * 100 / count($mg_classe)
////                        : null;
////
////                    $classes_infos[] = [
////                        'id' => $classe->id,
////                        'name' => $classe->name,
////                        'moyenne_generale_classe' => $tmp_moy_gen_classe,
////                        'pourcentage_reussite_classe' => $tmp_pourcentage_reussite,
//////                    'moyennes' => $mg_classe,
////                    ];
////
////                    if(!is_null($tmp_moy_gen_classe)) $moyenne_generale_ecole[] = $tmp_moy_gen_classe;
////                    if(!is_null($tmp_pourcentage_reussite)) $pourcentage_reussite_ecole[] = $tmp_pourcentage_reussite;
////                }
////
////                $infos_par_section[] = [
////                    'name' => $section->name,
////                    'classes' => $classes_infos,
////                    'moyenne_generale_section' => safeArraySum($moyenne_generale_ecole, true),
////                    'pourcentage_reussite_section' => safeArraySum($pourcentage_reussite_ecole, true),
////                ];
////            }
//
//            $data = [
//                "ecole" => $school,
////                "trimestre" => $trimestre,
//                'infos_ecole' => [
//                    'moyenne_generale' => safeArraySum($moyenne_generale_ecole, true),
//                    'pourcentage_reussite' => safeArraySum($pourcentage_reussite_ecole, true),
//                ],
//                'moyennes_generales_par_classe' => $moyennes_generales_par_classe,
//                "couleurs" => $this->getCodeCouleur(),
//                "route" => $request->route
//            ];
//
//            return $data;
//
//            $dompdf = new Dompdf();
//
//            // Récupérer la vue
//            $view = View::make("documents.create-documents.infos-generale-ecole-trimestre")->with($data);
//
//            // Récupérer le contenu de la vue
//            $html = $view->render();
//
//            // Charger le contenu HTML dans Dompdf
//            $dompdf->loadHtml($html);
//
//            // (Optionnel) Définir la taille et l'orientation du papier
//            $dompdf->setPaper('A4', 'portrait');
//
//            // Exécuter le rendu du PDF
//            $dompdf->render();
//
//            $filename = "infos-generale-ecole-trimestre.pdf";
//
//            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());
//
//            return $this->sendResponse(asset("pdfs/" . $filename), "Infos générales de l'école sur trimestre.");
//
////            return $this->genererDocuments($data, 'documents.pv.pv-secondaire');
//
//            return response()->json([
//                'moy_gen_ecole' => safeArraySum($moyenne_generale_ecole, true),
//                'pourcentage_reussite_ecole' => safeArraySum($pourcentage_reussite_ecole, true),
//                'moyennes_generales_par_classe' => $moyennes_generales_par_classe,
//            ]);
//        }


        try {
            /**
             * On récupére toutes les classes concernées.
             * Pour chaque classe, on va récupérer la liste ses moyennes, on s'en sert pour avoir la MG et le %S
             *
             * A la fin de la boucle, on obtient aussi la MG de l'école et le %S de l'école!
             */

            $trimestre = Trimestre::select('name')->find($request->idTrimestre);

            $classes = Classes::select('id','name')
                ->where([
                    'idSchool' => $request->idSchool,
                    'idSection' => $request->idSection,
                ])->get();

//            return $classes;

            $sequences = $this->getSequences($request["idTrimestre"]);

            $evaluation = Trimestre::where("id", $request["idTrimestre"])->first();

            $moyennes_generales_par_classe = array();
            $moyenne_generale_ecole = $pourcentage_reussite_ecole = array(); // on va faire un safeArraySum à la fin

            foreach ($classes as $classe) {

                if(count($sequences) <= 0){
                    return $this->sendError("Les évaluations que vous avez spécifiées sont inexistantes");
                }

                if(count($this->getMatiereEvalueesParGroupe($classe->id)) == 0){
                    return $this->sendError("Aucun groupe de matière trouvé pour cette classe");
                }

                $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $classe->id);

                $resultatsClasse = $this->calculeNotesTotales($evaluationEleves, $classe->id, array_column($sequences, "id"));

                $mg_classe = []; // on stocke les moyennes des enfants dans un tab puis on fat un safeArraySum
                foreach ($resultatsClasse['eleves'] as $idUser => $resultat) {
                    if($resultat['isEvalue']){
                        $mg_classe[] = $resultat['moyenne'];
                    }
                }

                $tmp_moy_gen_classe = safeArraySum($mg_classe, true);
                $tmp_pourcentage_reussite = (!empty($mg_classe))
                    ? count(array_filter($mg_classe, function($moyenne){
                        return $moyenne >=10;
                    })) * 100 / count($mg_classe)
                    : null;

                $moyennes_generales_par_classe[$classe->id] = [
                    'name' => $classe->name,
                    'moyenne_generale_classe' => $tmp_moy_gen_classe,
                    'pourcentage_reussite_classe' => $tmp_pourcentage_reussite,
//                    'moyennes' => $mg_classe,
                ];

                $moyenne_generale_ecole[] = $tmp_moy_gen_classe;
                $pourcentage_reussite_ecole[] = $tmp_pourcentage_reussite;

            }

            $school = School::select('name','logo')->find($request->idSchool);
            $section = Section::select('name')->find($request->idSection);

            $data = [
                "ecole" => $school,
                "trimestre" => $trimestre,
                "section" => $section,
                'infos_ecole' => [
                    'moyenne_generale' => safeArraySum($moyenne_generale_ecole, true),
                    'pourcentage_reussite' => safeArraySum($pourcentage_reussite_ecole, true),
                ],
                'moyennes_generales_par_classe' => $moyennes_generales_par_classe,
                "couleurs" => $this->getCodeCouleur(),
                "route" => $request->route
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make("documents.create-documents.infos-generale-ecole-trimestre")->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "infos-generale-ecole-trimestre.pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Infos générales de l'école sur trimestre.");

//            return $this->genererDocuments($data, 'documents.pv.pv-secondaire');

            return response()->json([
                'moy_gen_ecole' => safeArraySum($moyenne_generale_ecole, true),
                'pourcentage_reussite_ecole' => safeArraySum($pourcentage_reussite_ecole, true),
                'moyennes_generales_par_classe' => $moyennes_generales_par_classe,
            ]);
        }
        catch (\Exception $e){
            Log::info("Error: " . $e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
