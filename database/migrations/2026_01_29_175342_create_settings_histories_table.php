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
        Schema::create('settings_histories', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value');
            $table->string('group_name');
            $table->unsignedBigInteger('history_id');
            $table->timestamps();

            $table->foreign('history_id')
                ->references('id')
                ->on('histories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_histories');
    }
};
