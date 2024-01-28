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
        Schema::table("users", function (Blueprint $table) {
            $table->string("username", 50)->nullable()->index()->after("name");
            $table->tinyInteger("role_id")->unsigned()->default(3)->index()->after("password");
            $table->integer('no_of_tabs')->unsigned()->nullable(false)->default(0)->index()->after("role_id");
            $table->integer('no_of_artists')->unsigned()->nullable(false)->default(0)->index()->after("no_of_tabs");
            $table->integer('no_of_views')->unsigned()->nullable(false)->default(0)->index()->after("no_of_artists");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("username");
            $table->dropColumn("role_id");
            $table->dropColumn("no_of_tabs");
            $table->dropColumn("no_of_chords");
            $table->dropColumn("no_of_artists");
            $table->dropColumn("no_of_views");
        });
    }
};
