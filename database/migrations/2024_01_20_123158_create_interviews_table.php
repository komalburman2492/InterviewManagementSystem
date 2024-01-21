<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interviewer_id')->constrained('users');
            $table->foreignId('candidate_id')->constrained('users');
            $table->dateTime('scheduled_at');
            $table->string('interview_type');
            $table->text('feedback_strengths')->nullable();
            $table->text('feedback_weaknesses')->nullable();
            $table->integer('feedback_recommendation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
};
