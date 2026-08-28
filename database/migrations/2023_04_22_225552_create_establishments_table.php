<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('rib')->nullable(); 
            $table->string('banque')->nullable();            
            $table->integer('om')->unsigned()->nullable();
            $table->integer('idFounder')->unsigned()->nullable();
            $table->integer('idPrefetEtude')->unsigned()->nullable();
            $table->integer('idSecretaire')->unsigned()->nullable();
            $table->string('country');
            $table->string('email');
            $table->integer('idPackage')->unsigned();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('cle')->nullable();
            $table->string('route')->nullable();
            $table->string('administrative_status')->nullable();
            $table->string('religious_status')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idFounder')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idPackage')->references('id')->on('packages')->onDelete('restrict')->onUpdate('restrict');
            
        });

        Schema::create('establishments_has_users', function(Blueprint $table){
            $table->increments('id');
            $table->integer('establishment_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('establishments');
    }
}
