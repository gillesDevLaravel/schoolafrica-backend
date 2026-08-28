<?php

use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();  // ID de la commande
            $table->string('reference')->unique();
            $table->unsignedBigInteger('supplier_id');  // Fournisseur
            $table->unsignedBigInteger('responsible_id');  // idResponsable

            $table->text('description')->nullable();  // Description

            $table->date('validation_date')->nullable();  // Date de validation de la commande
            $table->date('order_received_date')->nullable();  // Date de réception de la commande

            $table->enum('status', PurchaseOrderStatusEnum::values())->default(PurchaseOrderStatusEnum::REQUESTING_PRICE);
            $table->enum('priority', PurchaseOrderPriorityEnum::values());  // Priorité
            $table->string('quotation_file')->nullable();
            $table->enum('payment_method', PurchaseOrderPaymentMethodEnum::values())->nullable();

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->timestamps();  // Created at, Updated at
            $table->softDeletes();
        });

        // Table pivot pour la relation many-to-many
        Schema::create('article_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');  // ID de la commande d'achat
            $table->unsignedBigInteger('article_id');  // ID de l'article
            $table->decimal('unit_price', 10, 2)->nullable();  // Prix unitaire de l'article
            $table->integer('quantity')->default(1);  // Quantité de l'article

            // // Définir les clés étrangères
            // $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            // $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            // // Clé unique pour éviter les doublons dans la table pivot
            // $table->unique(['purchase_order_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_purchase_order');
        Schema::dropIfExists('purchase_orders');
    }
}
