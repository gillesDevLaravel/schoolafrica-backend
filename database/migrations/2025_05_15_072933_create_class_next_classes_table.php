<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassNextClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_next_classes', function (Blueprint $table) {
            $table->id();

            // Clés étrangères vers la table classes
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('next_class_id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_next_classes');
    }
}
