<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificat_transferts', function (Blueprint $table) {
            $table->id();
            $table->integer('idStudent');
            $table->string('to'); // là où l'enfant a été transféré
            $table->string('reason'); // raison du transfert
            $table->date('on')->nullable(); // le jour du transfert
            $table->string('academic_year'); // ...
            $table->integer('created_by'); // celui qui a effectué le transfert
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificat_transferts');
    }
}
