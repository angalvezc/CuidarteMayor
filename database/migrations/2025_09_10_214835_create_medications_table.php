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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('health_record_id');
            $table->unsignedBigInteger('user_id'); // médico que administró
            $table->string('name'); // nombre del medicamento
            $table->string('dosage')->nullable(); // dosis
            $table->text('instructions')->nullable(); // instrucciones
            $table->date('administration_date');
            $table->timestamps();

            $table->foreign('health_record_id')->references('id')->on('health_records')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
