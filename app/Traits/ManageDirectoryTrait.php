<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ManageDirectoryTrait{
    public function createDirectory($path, $mode = 0755, $recursive = true){

        $directoryPath = public_path($path);

        // Vérifiez si le dossier existe, sinon créez-le
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
    }

    public function deleteDirectory($path, $mode = 0755, $recursive = true){

        $directoryPath = public_path($path);

        // Supprimer le dossier lorsqu'il n'est plus nécessaire
        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        }
    }
}
