<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('default_voiceover_language')->nullable();
            $table->string('default_voiceover_voice')->nullable();
            $table->integer('total_chars')->default(0);
            $table->integer('available_chars')->default(0);
            $table->integer('available_chars_prepaid')->default(0);
            $table->decimal('total_minutes', 15, 3)->default(0);
            $table->decimal('available_minutes', 15, 3)->default(0);
            $table->decimal('available_minutes_prepaid', 15, 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_chars');
            $table->dropColumn('available_chars');
            $table->dropColumn('available_chars_prepaid');
            $table->dropColumn('total_minutes');
            $table->dropColumn('available_minutes');
            $table->dropColumn('available_minutes_prepaid');
            $table->dropColumn('default_voiceover_language');
            $table->dropColumn('default_voiceover_voice');
        });
    }
};
