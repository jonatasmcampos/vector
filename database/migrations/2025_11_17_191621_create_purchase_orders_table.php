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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('external_identifier')->index();
            $table->unsignedBigInteger('purchase_order_type_id')->index();
            $table->unsignedBigInteger('credit_limit_id')->index();
            $table->unsignedBigInteger('contract_id')->index();
            $table->unsignedBigInteger('external_display_id');
            $table->unsignedBigInteger('status_id')->index();
            $table->unsignedTinyInteger('total_items');
            $table->unsignedInteger('cif');
            $table->unsignedInteger('fob');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('supplier_id')->index();
            $table->unsignedInteger('discount');
            $table->unsignedBigInteger('payment_nature_id')->index();
            $table->unsignedBigInteger('payment_method_id')->index();
            $table->unsignedTinyInteger('installments_number');
            $table->timestamps();


            $table->foreign('purchase_order_type_id')
                ->references('id')
                ->on('purchase_order_types');

            $table->foreign('credit_limit_id')
                ->references('id')
                ->on('credit_limits');

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');

            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers');

            $table->foreign('payment_nature_id')
                ->references('id')
                ->on('payment_natures');
        
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
