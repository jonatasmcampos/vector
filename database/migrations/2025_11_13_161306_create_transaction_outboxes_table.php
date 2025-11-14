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
        Schema::create('transaction_outboxes', function (Blueprint $table) {
            $table->id();
            $table->json('payload');
            $table->json('header')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->dateTime('received_at')->nullable();
            $table->dateTime('committed_at')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->text('last_error')->nullable();
            $table->dateTime('last_attempted_at')->nullable();
            $table->dateTime('processing_at')->nullable();
            $table->timestamps();
            
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_outboxes');
    }
};
