<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuizParticipantAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_participant_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizs');

            $table->unsignedBigInteger('quiz_question_id');
            $table->foreign('quiz_question_id')->references('id')->on('quiz_questions');

            $table->unsignedBigInteger('quiz_participant_id');
            $table->foreign('quiz_participant_id')->references('id')->on('quiz_participants');

            $table->unsignedBigInteger('quiz_question_answer_id');
            $table->foreign('quiz_question_answer_id')->references('id')->on('quiz_question_answers');

            $table->integer("is_true");
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
        Schema::dropIfExists('quiz_participant_answers');
    }
}
