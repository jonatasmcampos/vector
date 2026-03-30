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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            
            $table->foreign('action_id')
                ->references('id')
                ->on('actions');
            
            $table->foreign('process_id')
                ->references('id')
                ->on('processes');

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
        Schema::dropIfExists('histories');
    }
};
