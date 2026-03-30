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
        Schema::create('monthly_credit_limit_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_used_amount');
            $table->bigInteger('balance');
            $table->unsignedBigInteger('credit_limit_id');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');

            $table->foreign('credit_limit_id')
                ->references('id')
                ->on('credit_limits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_limit_balances');
    }
};
