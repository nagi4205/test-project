<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * まずulidカラムをpostsテーブルに追加する。
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->ulid('ulid')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('ulid');
        });
    }
};
