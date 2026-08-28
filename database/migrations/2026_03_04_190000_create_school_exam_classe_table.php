<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolExamClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table pivot pour la relation many-to-many entre school_exam et classes
        Schema::create('school_exam_classe', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('school_exam_id');  // ID du school exam
            $table->unsignedInteger('classe_id');  // ID de la classe
            $table->timestamps();
            
            // Unique constraint pour éviter les doublons
            $table->unique(['school_exam_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_exam_classe');
    }
}
