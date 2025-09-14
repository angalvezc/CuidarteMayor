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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique();
            $table->string('name');

            $table->date('birth_date');
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro']);
            $table->text('medical_history')->nullable();
            $table->string('allergies')->nullable();
            $table->string('mood')->nullable();
            
            $table->unsignedBigInteger('contact_user_id')->nullable();
            $table->foreign('contact_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
