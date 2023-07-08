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
        Schema::create('notification_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->refrences('id')->on('users')->onDelete('cascade');
            $table->foreignId('notification_id')->refrences('id')->on('notifications')->onDelete('cascade');
            $table->string('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_responses');
    }
};
