<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceIdAssessmentWithIdMatterInSchoolsExams extends Migration
{
    public function up()
    {
        Schema::table('schools_exams', function (Blueprint $table) {
            // Ajouter la nouvelle colonne
            $table->unsignedInteger('idMatter')->nullable()->after('idAssessmentType');
        });

        // Copier les données de idAssessment vers idMatter si nécessaire
        // (Cette partie dépend de votre logique métier)
        
        Schema::table('schools_exams', function (Blueprint $table) {
            // Supprimer l'ancienne colonne
            $table->dropColumn('idAssessment');
        });
    }

    public function down()
    {
        Schema::table('schools_exams', function (Blueprint $table) {
            // Ajouter idAssessment à nouveau
            $table->unsignedInteger('idAssessment')->nullable()->after('idAssessmentType');
        });

        // Copier les données de idMatter vers idAssessment si nécessaire
        
        Schema::table('schools_exams', function (Blueprint $table) {
            // Supprimer idMatter
            $table->dropColumn('idMatter');
        });
    }
}
