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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_type_id');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('origin_entity_id');
            $table->unsignedBigInteger('origin_entity_identifier');
            $table->unsignedBigInteger('payment_nature_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedTinyInteger('installments_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contract_id');
            $table->dateTime('date');
            $table->unsignedBigInteger('parent_transaction_id')->nullable();
            $table->timestamps();

            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('payment_nature_id')->references('id')->on('payment_natures');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('parent_transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
