<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_order_item_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history_id')->index();
            $table->unsignedBigInteger('external_material_id')->index();
            $table->string('material');
            $table->unsignedBigInteger('unit_amount');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedTinyInteger('quantity');
            $table->unsignedBigInteger('purchase_order_item_id')->index();
            $table->unsignedBigInteger('purchase_order_id')->index();
            $table->unsignedBigInteger('contract_id')->index();
            $table->timestamps();

            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders');

            $table->foreign('purchase_order_item_id')
                ->references('id')
                ->on('purchase_order_items');
            
            $table->foreign('history_id')
                ->references('id')
                ->on('histories');

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_item_histories');
    }
};
