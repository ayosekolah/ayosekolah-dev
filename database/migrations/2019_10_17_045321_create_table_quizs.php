<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuizs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("code")->unique()->nullable();
            $table->string("title");
            $table->text("description")->nullable();
            $table->string("image")->nullable();
            $table->string("file")->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('personals');
            $table->BigInteger('clas_id')->nullable();
            $table->BigInteger('lesson_id')->nullable();
            $table->integer("is_active")->default(1);
            $table->integer("is_clas")->default(0);
            $table->string("durations")->nullable();
            $table->bigInteger('busines_id')->nullable();
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
        Schema::dropIfExists('quizs');
    }
}
