<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('article_id');
            $table->text('reason')->nullable();
            $table->text('description')->nullable();

            $table->integer('exit_quantity');
            $table->integer('entry_quantity')->default(0);

            $table->dateTime('exit_date');
            $table->dateTime('entry_date')->nullable();

            $table->string('exit_condition')->nullable();
            $table->string('entry_condition')->nullable();

            $table->string('exit_image')->nullable();
            $table->string('entry_image')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('rentals');
    }
}
