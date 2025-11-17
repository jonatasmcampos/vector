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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_material_id')->index();
            $table->string('material');
            $table->unsignedBigInteger('unit_amount');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedTinyInteger('quantity');
            $table->unsignedBigInteger('purchase_order_id')->index();
            $table->timestamps();

            $table->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
