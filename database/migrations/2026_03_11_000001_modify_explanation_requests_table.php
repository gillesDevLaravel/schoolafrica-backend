<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExplanationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explanation_requests', function (Blueprint $table) {
            // Supprimer les anciennes colonnes
            $table->dropColumn([
                'idSchool',
                'reason', 
                'explanation',
                'status'
            ]);
            
            // Ajouter les nouvelles colonnes
            $table->text('description')->after('name');
            $table->unsignedBigInteger('idUser')->after('description');
            $table->unsignedBigInteger('idResponsable')->after('idUser');
            $table->string('image')->nullable()->after('idResponsable');
            $table->text('comments')->nullable()->after('image');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('explanation_requests', function (Blueprint $table) {  
            // Supprimer les nouvelles colonnes
            $table->dropColumn([
                'description',
                'idUser',
                'idResponsable', 
                'image',
                'comments'
            ]);
            
            // Restaurer les anciennes colonnes
            $table->unsignedBigInteger('idSchool')->after('id');
            $table->text('reason')->after('name');
            $table->text('explanation')->nullable()->after('reason');
            $table->string('status')->default('pending')->after('explanation');
        });
    }
}
