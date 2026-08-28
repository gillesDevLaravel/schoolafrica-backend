<?php

use App\Enums\MoratoriumStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyStatusEnumInMoratoriumTable extends Migration
{
    public function up()
    {
        // Générer la liste des valeurs SQL depuis l'Enum PHP + 'valid'
        $enumValues = "'" . implode("','", MoratoriumStatusEnum::values()) . "','valid'";

        // Modifier la colonne ENUM pour inclure 'valid' avant update
        DB::statement("
            ALTER TABLE moratoriums
            MODIFY COLUMN status ENUM($enumValues)
            NOT NULL DEFAULT 'valid'
        ");

        // Mettre toutes les valeurs existantes à 'valid'
        DB::table('moratoriums')->update(['status' => 'valid']);
    }

    public function down()
    {
        // 1️⃣ Mettre toutes les lignes existantes à une valeur valide de l'ancien ENUM
        DB::table('moratoriums')->update(['status' => 'pending_approval']);

        // 2️⃣ Définir l'ancien ENUM
        $oldEnumValues = "'pending_approval','in_progress','approved','rejected'";

        // 3️⃣ Modifier la colonne
        DB::statement("
            ALTER TABLE moratoriums
            MODIFY COLUMN status ENUM($oldEnumValues)
            NOT NULL DEFAULT 'pending_approval'
        ");
    }
}
