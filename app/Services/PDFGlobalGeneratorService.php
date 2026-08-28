<?php

namespace App\Services;

use App\Traits\DeletePDFTmpFilesTrait;
use App\Traits\ManageDirectoryTrait;
use Dompdf\Dompdf;
use Google\Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PDFGlobalGeneratorService
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait;

    /**
     * Remplir un fichier blade avec les données fournies et transformer en PDF
     *
     * @param String $view
     * @param array $data
     * @param $filename
     * @param $sub_dir
     * @return string
     */
    public function generatePDF(String $view, array $data, $filename, $sub_dir=null)
    {
        try {
            $dompdf = new Dompdf();

            if (view()->exists($view)) {
                $vue = $view;
            } else {
                throw new Exception("View $view does not exist");
            }

            $view = View::make($vue)->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            if(!is_null($sub_dir)){
                $this->createDirectory("pdfs/$sub_dir");
                $filename = $sub_dir."/".$filename;
            }

            file_put_contents(public_path("pdfs/$filename.pdf"), $dompdf->output());

            return asset("pdfs/$filename.pdf");
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Permet de générer un ZIP contenant plusieurs fichiers PDFs
     *
     * @param array $pdfs
     * @param $zip_name
     * @return string
     */
    public function generateZIP(array $pdfs, $zip_name)
    {
        try {
            $tmp_folders = [];

            if(count($pdfs) == 0){
                throw new Exception("Cannot generate empty ZIP file");
            }

            $zip = new \ZipArchive();
            $zip->open("pdfs/" . $zip_name.".zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $tmp_filenames = [];
            foreach ($pdfs as $pdf) {
                $name = $pdf['name'];

                if(isset($pdf['folder'])){
                    $name = $pdf['folder']."/".$name;
                }

                //TODO: Il faut vérifier que le fichier est bien un PDF sinon 'continue;'
                $zip->addFile("pdfs/$name.pdf");

                $tmp_filenames[] = "pdfs/" . $name.".pdf";

                if(isset($pdf['folder'])){
                    $tmp_folders[] = "pdfs/" . $pdf['folder'];
                }
            }

            $zip->close();

            foreach ($tmp_folders as $tmp_folder) {
                $this->deleteDirectory($tmp_folder);
            }
            $this->deletePDFTempFiles($tmp_filenames);

            return asset("pdfs/" . $zip_name.".zip");
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
