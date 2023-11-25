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
        Schema::table('community_posts', function (Blueprint $table) {
            $table->rename('community_messages', 'community_posts');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_posts', function (Blueprint $table) {
            $table->rename('community_posts', 'community_messages');
        });
    }
};
