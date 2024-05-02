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
            $table->text('original_url');
            $table->string('short_url');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('clicks')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->dateTime('expiration_date')->nullable();
            $table->timestamps();
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


