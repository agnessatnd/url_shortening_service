<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('url', function (Blueprint $table) {
            $table->id();
            $table->string('original_url');
            $table->string('short_url');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('date')->default(DB::raw('NOW()'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url');
    }
};
