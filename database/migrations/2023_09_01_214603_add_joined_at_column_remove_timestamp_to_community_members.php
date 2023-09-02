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
            $table->timestamp('joined_at')->after('user_id');
            $table->dropTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropColumn('joined_at');
            $table->timestamps();
        });
    }
};
