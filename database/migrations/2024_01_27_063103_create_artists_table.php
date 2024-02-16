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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->string('name', 50)->nullable()->fulltext();
            $table->integer('no_of_views')->unsigned()->nullable(false)->default(0)->index();
            $table->integer('no_of_tabs')->unsigned()->nullable(false)->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
