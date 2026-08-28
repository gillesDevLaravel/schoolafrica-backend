<?php

namespace App\Traits;

trait DeletePDFTmpFilesTrait{

    /**
     * Supprimer les PDF temporaires vu qu'on ne les stocke pas sur le serveur
     * @param $files
     * @return void
     */
    public function deletePDFTempFiles($files = array())
    {
        foreach ($files as $path) {
            @unlink($path);
        }
    }
}
