<?php

use App\Models\Article;
use App\Models\SupplyDemand;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

if (! function_exists('assessmentTypeName')) {

    function assessmentTypeName($chaine){
        $chaineSansAccent = strtr($chaine, [
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            // Ajoutez d'autres remplacements si nécessaire
        ]);

        $chaine = str_replace('^', '', $chaineSansAccent);

        return strtolower(str_replace(' ', '_', $chaine));
    }
}

if (! function_exists('getAppreciationSticker')) {

    function getAppreciationSticker($noteObtenue, $noteTotale){

        $noteToCheck = $noteObtenue;
        $notemaxToCkech = $noteTotale;

        if($noteToCheck < $notemaxToCkech/2)
        {
            $grade_img = "appreciation1.png";
        }
        else if($notemaxToCkech/2 <= $noteToCheck && $noteToCheck < $notemaxToCkech * (3/4)){
            $grade_img = "appreciation2.png";
        }
        else if($notemaxToCkech * (3/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (9/10)){
            $grade_img = "appreciation3.png";
        }else{
            $grade_img = "appreciation4.png";
        }

        return $grade_img;
    }

    //by Ibrah
    function getAppreciationStickerWithNull($noteObtenue, $noteTotale){
        if($noteObtenue === null){
            return "appreciation0.png";
        }
        else{
            return getAppreciationSticker($noteObtenue, $noteTotale);
        }
    }
}

if (! function_exists('getAppreciationStickerForMaternelle')) {

    function getAppreciationStickerForMaternelle($noteObtenue, $isMoyenne = false){

        $noteToCheck = $noteObtenue;

        if($isMoyenne){
            if($noteToCheck == 0 || is_null($noteToCheck))
            {
                $grade_img = "appreciation0.png";
            }
            else if($noteToCheck < 1.5)
            {
                $grade_img = "appreciation1.png";
            }
            else if($noteToCheck >= 1.5 && $noteToCheck < 2.5){
                $grade_img = "appreciation2.png";
            }
            else if($noteToCheck >= 2.5 && $noteToCheck < 3.5){
                $grade_img = "appreciation3.png";
            }else{
                $grade_img = "appreciation4.png";
            }
        }else{
            if($noteToCheck == 0 || is_null($noteToCheck))
            {
                $grade_img = "appreciation0.png";
            }
            else if($noteToCheck <= 1)
            {
                $grade_img = "appreciation1.png";
            }
            else if($noteToCheck <= 2){
                $grade_img = "appreciation2.png";
            }
            else if($noteToCheck <= 3){
                $grade_img = "appreciation3.png";
            }else{
                $grade_img = "appreciation4.png";
            }
        }

        return $grade_img;
    }
}

if (! function_exists('getAppreciationColorForMaternelle')) {

    function getAppreciationColorForMaternelle($noteObtenue, $isMoyenne = false){

        $noteToCheck = $noteObtenue;

        if(!$isMoyenne){
            if($noteToCheck <= 1)
            {
                $grade_color = "nye_color";
                $appreciation_txt = __('bulletin_primaire.appr_nye_txt');
            }
            else if($noteToCheck <= 2){
                $grade_color = "ae_color";
                $appreciation_txt = __('bulletin_primaire.appr_ae_txt');
            }
            else if($noteToCheck <= 3){
                $grade_color = "me_color";
                $appreciation_txt = __('bulletin_primaire.appr_me_txt');
            }else{
                $grade_color = "abe_color";
                $appreciation_txt = __('bulletin_primaire.appr_abe_txt');
            }
        }else{
            if($noteToCheck <= 1.5)
            {
                $grade_color = "nye_color";
                $appreciation_txt = __('bulletin_primaire.appr_nye_txt');
            }
            else if($noteToCheck <= 2.5){
                $grade_color = "ae_color";
                $appreciation_txt = __('bulletin_primaire.appr_ae_txt');
            }
            else if($noteToCheck <= 3.5){
                $grade_color = "me_color";
                $appreciation_txt = __('bulletin_primaire.appr_me_txt');
            }else{
                $grade_color = "abe_color";
                $appreciation_txt = __('bulletin_primaire.appr_abe_txt');
            }
        }

        return [
            $grade_color,
            $appreciation_txt
        ];
    }
}

if (! function_exists('getAppreciationGradeAndColor')) {

    function getAppreciationGradeAndColor($noteObtenue, $noteTotale, $forMaternelle = null){

        $noteToCheck = $noteObtenue;
        $notemaxToCkech = $noteTotale;

        if($forMaternelle){
            if($noteToCheck < $notemaxToCkech * (1.5/4))
            {
                $grade = __('bulletin_primaire.appr_nye');
                $grade_color = "nye_color";
                $grade_txt = __('bulletin_primaire.appr_nye_txt');
            }
            else if($notemaxToCkech * (1.5/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (2.5/4)){
                $grade = __('bulletin_primaire.appr_ae');
                $grade_color = "ae_color";
                $grade_txt = __('bulletin_primaire.appr_ae_txt');
            }
            else if($notemaxToCkech * (2.5/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (3.5/4)){
                $grade = __('bulletin_primaire.appr_me');
                $grade_color = "me_color";
                $grade_txt = __('bulletin_primaire.appr_me_txt');
            }else{
                $grade = __('bulletin_primaire.appr_abe');
                $grade_color = "abe_color";
                $grade_txt = __('bulletin_primaire.appr_abe_txt');
            }

            return [$grade, $grade_color, $grade_txt];
        }

        if($noteToCheck < $notemaxToCkech/2)
        {
            $grade = __('bulletin_primaire.appr_nye');
            $grade_color = "nye_color";
            $grade_txt = __('bulletin_primaire.appr_nye_txt');
        }
        else if($notemaxToCkech/2 <= $noteToCheck && $noteToCheck < $notemaxToCkech * (3/4)){
            $grade = __('bulletin_primaire.appr_ae');
            $grade_color = "ae_color";
            $grade_txt = __('bulletin_primaire.appr_ae_txt');
        }
        else if($notemaxToCkech * (3/4) <= $noteToCheck && $noteToCheck < $notemaxToCkech * (9/10)){
            $grade = __('bulletin_primaire.appr_me');
            $grade_color = "me_color";
            $grade_txt = __('bulletin_primaire.appr_me_txt');
        }else{
            $grade = __('bulletin_primaire.appr_abe');
            $grade_color = "abe_color";
            $grade_txt = __('bulletin_primaire.appr_abe_txt');
        }

        return [$grade, $grade_color, $grade_txt];
    }
}

if (! function_exists('legendOfGrade')) {

    function legendOfGrade(){

        return [
//                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                    return $moyenneStud < 10;
//                })),
            'nye_color' => "db0b32",
//                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                    return $moyenneStud >= 10 && $moyenneStud < 15;
//                })),
            'ae_color' => "fdaa3e",
//                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                    return $moyenneStud >= 15 && $moyenneStud < 18;
//                })),
            'me_color' => "0080ff",
//                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                    return $moyenneStud >= 18;
//                })),
            'abe_color' => "008000",
        ];
    }
}


if (! function_exists('couleurEnteteTableauBulletinJunior')) {

    function couleurEnteteTableauBulletinJunior(){
        return [
            'bg' => "c0c0c0",
            'txt' => "000000"
        ];
    }
}


if (! function_exists('getStudentRankFR')) {
    function getStudentRankFR(int $rang){
        $suffix = "e";

        if ($rang == 1) $suffix = "er";

        return $rang . "<sup>$suffix</sup>";
    }
}
if (! function_exists('getStudentRankEN')) {
    function getStudentRankEN(int $rang){
        $suffix = __('bulletin_primaire.def_suf_rank');  // ces valeurs sont différentes uniquement pour la langue anglaises

        if ($rang % 100 < 11 || $rang % 100 > 13) {
            switch ($rang % 10) {
                case 1:
                    $suffix = __('bulletin_primaire.first_suf_rank');
                    break;
                case 2:
                    $suffix = __('bulletin_primaire.second_suf_rank'); // ces valeurs sont différentes uniquement pour la langue anglaises
                    break;
                case 3:
                    $suffix = __('bulletin_primaire.third_suf_rank'); // ces valeurs sont différentes uniquement pour la langue anglaises
                    break;
            }
        }
        return $rang . "<sup style='font-size: 6px;'>$suffix</sup>";
    }
}

if (! function_exists('getStudentRank')) {
    function getStudentRank(int $rang){
        $lang = App::getLocale();

        switch ($lang){
            case 'fr':
                return getStudentRankFR($rang);
                break;
            case 'en':
                return getStudentRankEN($rang);
                break;
            default:
                return $rang;
                break;
        }
    }
}


if (! function_exists('safeArraySum')) {
    /**
     * Sommer les éléments d'un tableau mais renvoyer null si jamais le tableau est vide
     *
     * @param array $tab
     * @param bool $diviser: Savoir si on renvoie la moyenne des éléments du tableau
     * @return float|int|null
     */
    function safeArraySum(array $tab, bool $diviser = false)
    {
        if(empty($tab)){
            return null;
        }

        return ($diviser)
            ? array_sum($tab) / count($tab)
            : array_sum($tab);
    }
}

if (! function_exists('countNonNull')) {
    /**
     * Retourne le nombre d'éléments non nulls du tableau
     *
     * @param $array
     * @return int
     */
    function countNonNull($array) {

        if(!is_array($array))
            throw new Exception("The variable is not a valid array");

        $count = 0;
        foreach ($array as $element) {
            if ($element !== null) {
                $count++;
            }
        }
        return $count;
    }
}

if (! function_exists('number_format_if_float')) {
    /**
     * Afficher la partie décimale si elle existe
     *
     * @param $var
     * @param $precision
     */
    function number_format_if_float($var, $precision=0)
    {
        if(floor($var) == $var){
            return (int)$var;
        }else{
            return number_format($var, $precision);
        }
    }
}



if(! function_exists('getAppreciation0')){
    /**
     * Afficher la partie décimale si elle existe
     *
     * @param $moyenneStudents
     * @param $isMoyenne
     * @param $isSimple
     */
    function getAppreciation0($moyenneStudents, $isSimple){
        // Vérification de la condition pour les moyennes inférieures à 8
        if ($moyenneStudents < 8)    {
            return [
                'appreciation' => __('bulletin_secondaire.mediocre'), // Non acquis
                'couleur' => '#FF0000' // Rouge
            ];
        }

        // Vérification de la condition pour les moyennes entre 8 et 9
        elseif ($moyenneStudents >= 8 && $moyenneStudents < 10) {
            return [
                'appreciation' => __('bulletin_secondaire.insuffisant'), // En cours d'acquisition
                'couleur' => '#FF0000' // Rouge
            ];
        }

        // Vérification de la condition pour les moyennes entre 10 et 11
        elseif ($moyenneStudents >= 10 && $moyenneStudents < 12) {
            return [
                'appreciation' => __('bulletin_secondaire.passable'), // En cours d'acquisition
                'couleur' => $isSimple ? '#0000FF' : 'orange' // Noir ou orange
            ];
        }

        // Vérification de la condition pour les moyennes entre 12 et 14
        elseif ($moyenneStudents >= 12 && $moyenneStudents < 14) {
            return [
                'appreciation' => __('bulletin_secondaire.assez_bien'), // En cours d'acquisition
                'couleur' => $isSimple ? '#0000FF' : 'orange' // Noir ou orange
            ];
        }

        // Vérification de la condition pour les moyennes entre 14 et 16
        elseif ($moyenneStudents >= 14 && $moyenneStudents < 16) {
            return [
                'appreciation' => __('bulletin_secondaire.bien'), // En cours d'acquisition
                'couleur' => $isSimple ? '#0000FF' : 'blue' // Noir ou bleu
            ];
        }

        // Vérification de la condition pour les moyennes entre 16 et 17
        elseif ($moyenneStudents >= 16 && $moyenneStudents <= 18) {
            return [
                'appreciation' => __('bulletin_secondaire.tres_bien'), // En cours d'acquisition
                'couleur' => $isSimple ? '#0000FF' : 'green'  // Noir ou vert
            ];
        }

        // Vérification de la condition pour les moyennes entre 18 et 20
        elseif ($moyenneStudents >= 18 && $moyenneStudents <= 20) {
            return [
                'appreciation' => __('bulletin_secondaire.excellent'), // En cours d'acquisition
                'couleur' => $isSimple ? '#0000FF' : 'green'  // Noir ou vert
            ];
        }

        // Retour par défaut pour une moyenne invalide
        return [
            'appreciation' => null,
            'couleur' => '#000000' // Noir pour les moyennes invalides
        ];
    }
    function getAppreciationAbrev($moyenneStudents, $isSimple){
        $app = strtoupper(preg_replace('/\b(\w)\w*/u', '$1', getAppreciation0($moyenneStudents, $isSimple)["appreciation"]));

        return str_replace(' ', '', $app);
    }

    /**
     * Afficher la partie décimale si elle existe
     *
     * @param $moyenneStudents
     * @param $bareme
     */
    function getAppreciationBareme($moyenneStudents, $bareme){
        //Appreciations simples (echec/reussite)
        if ($moyenneStudents < $bareme/2) {
            return '#FF0000';
        }else{
            return '#0000FF';
        }
    }

}

if (! function_exists('getAcademicYear')) {
    /**
     * Retourne l'année académique actuelle
     *
     * @param $separator
     * @return int|string
     */
    function getAcademicYear($separator = "-")
    {
        $currentYear = date('Y');
        $currentMonth = date('n'); // Récupère le mois courant (1 à 12)

        if ($currentMonth >= 9) { // Septembre (9) et au-delà
            $nextYear = $currentYear + 1;
            return $currentYear . $separator . $nextYear; // Année académique en cours
        } else {
            $previousYear = $currentYear - 1;
            return $previousYear . $separator . $currentYear; // Année académique précédente
        }
    }
}


if (! function_exists('generateReferenceNumber')) {
    /**
     * Générer un numéro de reférence unique
     *
     * @param $table
     * @param $columnName
     * @param $nbrCaracter
     * @return string
     */
    function generateReferenceNumber($table, $columnName, $nbrCaracter): string
    {
        // Récupérer la dernière référence
        $lastReference = $table::withTrashed()->orderBy($columnName, 'desc')->value($columnName);

        // Générer la nouvelle référence
        if ($lastReference) {
            $lastNumber = (int) $lastReference; // Convertir en entier
            $newNumber = $lastNumber + 1; // Incrémenter
        } else {
            $newNumber = 1; // Première référence
        }

        // Formater la référence pour qu'elle ait toujours $nbrCaracter caractères
        $newReference = Str::padLeft($newNumber, $nbrCaracter, '0');

        return  $newReference;
    }
}



if (! function_exists('uploadSingleImage')) {
    /**
     * telechargement d'une image dans le dossier "public/dirName"
     *
     * @param $image
     * @param $dirName
     * @return string
     */
    function uploadSingleImage(\Illuminate\Http\UploadedFile $image, $dirName) //Tableau d'image de la request
    {
        if(!$image->isValid()) {
            return null;
        }
        // Définir le chemin cible
        $lessonSummary = public_path("public/$dirName");

        // Vérifier si le répertoire existe, sinon le créer
        if (!File::exists($lessonSummary)) {
            File::makeDirectory($lessonSummary, 0755, true);
        }

        // Générer un nom unique pour le fichier
        $fileName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();

        // Déplacer le fichier vers le dossier public
        $image->move($lessonSummary, $fileName);

        // Générer le chemin relatif pour l'URL
        return "public/$dirName/$fileName";
    }
}


if (! function_exists('uploadMultipleImages')) {
    /**
     * telechargement multiple d'images
     *
     * @param $images
     * @param $dirName
     * @return array
     */
    function uploadMultipleImages(array $images, $dirName) //Tableau d'image de la request
    {
        $imagesPath = [];  //Liens d'acces aux images

        foreach ($images as $image){
            $imagesPath[] = uploadSingleImage($image, $dirName);
        }

        return $imagesPath;
    }
}

if (!function_exists('factoryCreateOneByOne')) {
    /**
     * Exécute une factory Eloquent modèle par modèle en générant une référence unique.
     *
     * @param string $modelClass
     * @param int $count
     * @param string $column
     * @param int $length
     * @param string|null $prefix
     * @return Collection
     */
    function factoryCreateOneByOne(string $modelClass, int $count, string $column = 'reference', int $length = 6, ?string $prefix = null)
    {
        $collection = collect();

        for ($i = 0; $i < $count; $i++) {
            $instance = factory($modelClass)->make();
            $instance->{$column} = generateReferenceNumber($modelClass, $column, $length, $prefix);
            $instance->save();
            $collection->push($instance);
        }

        return $collection;
    }
}

if (!function_exists('attachArticlesToSupplyDemand')) {
    function attachArticlesToSupplyDemand(SupplyDemand $supplyDemand, Faker\Generator $faker = null)
    {
        $faker = $faker ?: Factory::create();

        $articles = factoryCreateOneByOne(Article::class, $faker->numberBetween(1, 5));

        $pivotData = [];
        foreach ($articles as $article) {
            $pivotData[$article->id] = [
                'quantity' => $faker->numberBetween(1, 10),
                'unit_price' => $faker->randomFloat(2, 10, 1000),
                'supplier_id' => factory(User::class)->create()->id,
            ];
        }

        $supplyDemand->articles()->sync($pivotData);
    }
}

if (!function_exists('apply_exif_orientation')) {
    /**
     * Apply EXIF orientation to a GD image resource.
     *
     * @param resource $image
     * @param int $orientation
     * @param bool $changed
     * @return resource
     */
    function apply_exif_orientation($image, $orientation, &$changed = false)
    {
        $changed = false;
        if (!$image) {
            return $image;
        }

        switch ((int) $orientation) {
            case 2: // Horizontal flip
                if (function_exists('imageflip')) {
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    $changed = true;
                }
                break;
            case 3: // Rotate 180
                $rotated = imagerotate($image, 180, 0);
                if ($rotated) {
                    imagedestroy($image);
                    $image = $rotated;
                    $changed = true;
                }
                break;
            case 4: // Vertical flip
                if (function_exists('imageflip')) {
                    imageflip($image, IMG_FLIP_VERTICAL);
                    $changed = true;
                }
                break;
            case 5: // Vertical flip + rotate 90 right
                if (function_exists('imageflip')) {
                    imageflip($image, IMG_FLIP_VERTICAL);
                    $changed = true;
                }
                $rotated = imagerotate($image, -90, 0);
                if ($rotated) {
                    imagedestroy($image);
                    $image = $rotated;
                    $changed = true;
                }
                break;
            case 6: // Rotate 90 right
                $rotated = imagerotate($image, -90, 0);
                if ($rotated) {
                    imagedestroy($image);
                    $image = $rotated;
                    $changed = true;
                }
                break;
            case 7: // Horizontal flip + rotate 90 right
                if (function_exists('imageflip')) {
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    $changed = true;
                }
                $rotated = imagerotate($image, -90, 0);
                if ($rotated) {
                    imagedestroy($image);
                    $image = $rotated;
                    $changed = true;
                }
                break;
            case 8: // Rotate 90 left
                $rotated = imagerotate($image, 90, 0);
                if ($rotated) {
                    imagedestroy($image);
                    $image = $rotated;
                    $changed = true;
                }
                break;
        }

        return $image;
    }
}

if (!function_exists('normalize_image_orientation')) {
    /**
     * Normalize image orientation in-place for JPEG files with EXIF data.
     *
     * @param string $path
     * @return bool
     */
    function normalize_image_orientation($path)
    {
        if (!is_string($path) || !is_file($path)) {
            return false;
        }

        if (!function_exists('exif_read_data') || !function_exists('imagecreatefromjpeg')) {
            return false;
        }

        $info = function_exists('getimagesize') ? @getimagesize($path) : null;
        $mime = $info['mime'] ?? null;
        if ($mime !== 'image/jpeg') {
            return false;
        }

        $exif = @exif_read_data($path);
        $orientation = $exif['Orientation'] ?? null;
        if (!$orientation || (int) $orientation === 1) {
            return false;
        }

        $image = @imagecreatefromjpeg($path);
        if (!$image) {
            return false;
        }

        $changed = false;
        $image = apply_exif_orientation($image, (int) $orientation, $changed);

        if (!$changed) {
            if ($image) {
                imagedestroy($image);
            }
            return false;
        }

        $result = imagejpeg($image, $path, 90);
        imagedestroy($image);

        return $result ? true : false;
    }
}

if (!function_exists('image_data_uri')) {
    /**
     * Return a data URI for an image, normalizing EXIF orientation for JPEGs in memory.
     *
     * @param string $path
     * @param string $defaultMime
     * @return string|null
     */
    function image_data_uri($path, $defaultMime = 'image/jpeg')
    {
        if (!is_string($path) || !is_file($path)) {
            return null;
        }

        $mime = null;
        if (function_exists('mime_content_type')) {
            $mime = @mime_content_type($path);
        }
        if (!$mime && function_exists('getimagesize')) {
            $info = @getimagesize($path);
            if ($info && isset($info['mime'])) {
                $mime = $info['mime'];
            }
        }
        if (!$mime) {
            $mime = $defaultMime;
        }

        $data = null;
        if ($mime === 'image/jpeg' && function_exists('exif_read_data') && function_exists('imagecreatefromjpeg')) {
            $exif = @exif_read_data($path);
            $orientation = $exif['Orientation'] ?? null;

            if ($orientation && (int) $orientation !== 1) {
                $image = @imagecreatefromjpeg($path);
                if ($image) {
                    $changed = false;
                    $image = apply_exif_orientation($image, (int) $orientation, $changed);
                    if ($changed && $image) {
                        ob_start();
                        imagejpeg($image, null, 90);
                        $data = ob_get_clean();
                    }
                    imagedestroy($image);
                }
            }
        }

        if ($data === null) {
            $data = @file_get_contents($path);
        }

        if ($data === false || $data === null) {
            return null;
        }

        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }
}
