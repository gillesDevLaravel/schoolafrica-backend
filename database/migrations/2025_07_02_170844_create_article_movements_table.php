<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('stock');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->enum('operation_type', ['entry', 'exit']); // e.g. 'entree', 'sortie'
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('purchase_order_id')->nullable();

            $table->unsignedInteger('created_by');
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
        Schema::dropIfExists('article_movements');
    }
}
