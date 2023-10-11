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
        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('nim')->unique();
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('document')->unique();
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->enum('year_of_enrollment', ['2021','2022','2023']);
            $table->enum('faculty', ['FTE', 'FRI']);
            $table->string('major');
            $table->string('class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academies');
    }
};
