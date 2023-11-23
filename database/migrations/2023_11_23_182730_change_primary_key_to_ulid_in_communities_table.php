<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->ulid('temp_ulid')->after('id')->nullable();

            $table->unsignedBigInteger('id')->autoIncrement(false)->change();

            $table->dropPrimary();

            $table->dropColumn('id');

            $table->renameColumn('temp_ulid', 'id');

            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropPrimary();

            $table->dropColumn('id');

            $table->unsignedBigInteger('id')->autoIncrement();

            $table->primary('id');
        });
    }
};

