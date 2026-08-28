<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname')->nullable();
            $table->string('placeofbirth')->nullable();
            $table->string('situation')->nullable();
            $table->boolean('repeater')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('gender');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('fit')->nullable();
            $table->string('desease')->nullable();
            $table->string('matricule')->nullable();
            $table->string('photo')->nullable();
            $table->string('profession')->nullable();
            $table->date('birthday')->nullable();
            $table->longText('device_key')->nullable();
            $table->string('cni')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('salary')->unsigned()->nullable();
            $table->integer('hourlyPrice')->unsigned()->nullable();
            $table->integer('idMatter')->unsigned()->nullable();
            $table->integer('idParent')->unsigned()->nullable();
            $table->integer('idLevel')->unsigned()->nullable();
            $table->integer('idOptionLevel')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('idCycle')->unsigned()->nullable();
            $table->integer('idClasse')->unsigned()->nullable();
            $table->rememberToken();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('idMatter')->references('id')->on('matter')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idParent')->references('id')->on('users')->onDelete('set null');
            $table->foreign('idLevel')->references('id')->on('levels')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idOptionLevel')->references('id')->on('option_level')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idCycle')->references('id')->on('cycles')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
            
        });

        Schema::create('matter_has_user', function(Blueprint $table){
            $table->increments('id');
            $table->integer('matter_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('matter_id')->references('id')->on('matter')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('classe_has_user', function(Blueprint $table){
            $table->increments('id');
            $table->integer('classes_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
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
        Schema::dropIfExists('classe_has_user');
        Schema::dropIfExists('matter_has_user');
        Schema::dropIfExists('users');
    }
}
