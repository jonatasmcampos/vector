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
        Schema::create('credit_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('authorized_amount');
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('credit_usage_type_id');
            $table->unsignedBigInteger('credit_modality_id');
            $table->unsignedBigInteger('credit_period_type_id');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');

            $table->foreign('credit_usage_type_id')
                ->references('id')
                ->on('credit_usage_types');

            $table->foreign('credit_modality_id')
                ->references('id')
                ->on('credit_modalities');

            $table->foreign('credit_period_type_id')
                ->references('id')
                ->on('credit_period_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_limits');
    }
};
