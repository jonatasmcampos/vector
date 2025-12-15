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
        Schema::create('installment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('installment_id');
            $table->bigInteger('installment_amount');
            $table->date('due_day');
            $table->unsignedTinyInteger('order');
            $table->dateTime('paid_at')->nullable();
            $table->bigInteger('amount_paid')->nullable();
            $table->unsignedBigInteger('external_identifier');
            $table->unsignedBigInteger('installment_amount_type_id');
            $table->unsignedBigInteger('installment_type_id');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();
            
            $table->foreign('installment_id')
                ->references('id')
                ->on('installments');

            $table->foreign('history_id')
                ->references('id')
                ->on('histories');

            $table->foreign('installment_amount_type_id')
                ->references('id')
                ->on('installment_amount_types');

            $table->foreign('installment_type_id')
                ->references('id')
                ->on('installment_types');

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
        Schema::dropIfExists('installment_histories');
    }
};
