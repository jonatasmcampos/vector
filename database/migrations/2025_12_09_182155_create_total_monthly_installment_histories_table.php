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
        Schema::create('total_monthly_installment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('installment_id');
            $table->unsignedBigInteger('total_monthly_installment_id');
            $table->unsignedBigInteger('gross_amount');
            $table->unsignedBigInteger('old_gross_amount');
            $table->unsignedBigInteger('new_gross_amount');
            $table->unsignedBigInteger('amount_paid');
            $table->unsignedBigInteger('old_amount_paid');
            $table->unsignedBigInteger('new_amount_paid');
		    $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->unsignedBigInteger('contract_id');

            $table->timestamps();

            $table->foreign('total_monthly_installment_id', 'tmih_tmi_id_fk')
                ->references('id')
                ->on('total_monthly_installments');

            $table->foreign('installment_id')
                ->references('id')
                ->on('installments');

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
        Schema::dropIfExists('total_monthly_installment_histories');
    }
};
