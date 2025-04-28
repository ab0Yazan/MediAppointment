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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_schedule_id')
                ->constrained('doctor_schedules')
                ->onDelete('cascade');

            $table->enum('week_day', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri']);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_reserved')->default(false);

            $table->timestamps();

            $table->unique(['doctor_schedule_id', 'date', 'start_time', 'end_time'], 'unique_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
