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
            $table->morphs('transaction_entity');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('transaction_type_id');
            $table->dateTime('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('credit_limit_id');
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->morphs('balance_history');
            
            $table->timestamps();

            $table->foreign('installment_id')->references('id')->on('installments');
            $table->foreign('credit_limit_id')->references('id')->on('credit_limits');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
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
