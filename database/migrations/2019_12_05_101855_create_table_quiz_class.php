<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuizClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizclasses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('clas_id')->nullable();
            $table->bigInteger('quiz_id')->nullable();
            $table->integer('is_publish')->default(0);
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
        Schema::dropIfExists('quizclasses');
    }
}
