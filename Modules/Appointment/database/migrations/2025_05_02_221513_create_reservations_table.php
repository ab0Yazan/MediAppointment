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
        Schema::create('reservations', function (Blueprint $table) {
            //columns
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('slot_id');
            $table->string('status', 20);
            $table->timestamps();

            //keys
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('slot_id')->references('id')->on('slots');
            $table->unique(['slot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
