<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('adresse')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('niu')->nullable();
            $table->enum('type', ['entreprise', 'personnel']);
            $table->string('rc')->nullable();
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('customers');
    }
}
