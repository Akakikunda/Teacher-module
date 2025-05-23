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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('student_id');
        $table->string('subject');
        $table->integer('mark');
        $table->string('grade')->nullable();
        $table->timestamps();

        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
      });
    }   
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};