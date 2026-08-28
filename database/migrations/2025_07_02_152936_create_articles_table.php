<?php

use App\Enums\ArticleTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('idSchool');
            $table->string('idSection')->nullable();
            $table->string('name');
            $table->enum('type', ArticleTypeEnum::values());
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->integer('alert_quantity')->nullable();
//            $table->unsignedBigInteger('service_id');
            $table->decimal('price', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->string('container')->nullable();
            $table->string('container_unit')->nullable();
            $table->unsignedInteger('container_quantity')->nullable();
            $table->text('detail')->nullable();

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('article_supplier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('supplier_id'); // fournisseur_id sur la table users
            //            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_supplier');
    }
}
