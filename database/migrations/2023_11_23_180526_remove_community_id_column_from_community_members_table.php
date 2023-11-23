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
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropForeign('community_members_community_id_foreign');
            $table->dropColumn('community_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
        });
    }
};
