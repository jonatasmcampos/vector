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
        Schema::create('credit_limit_balance_histories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->bigInteger('used_amount');
            $table->bigInteger('old_used_amount');
            $table->bigInteger('new_used_amount');
            $table->bigInteger('old_balance');
            $table->bigInteger('new_balance');
            $table->unsignedBigInteger('credit_limit_balance_id');
            $table->unsignedBigInteger('history_id');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();


            $table->foreign('credit_limit_balance_id')
                ->references('id')
                ->on('credit_limit_balances');
            
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
        Schema::dropIfExists('credit_limit_balance_histories');
    }
};
