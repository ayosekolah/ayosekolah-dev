<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('file');
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('ekstensi')->nullable();
            $table->string('mime')->nullable();
            $table->string('clas_id')->nullable();
            $table->bigInteger('teacher_id')->nullable();
            $table->bigInteger('busines_id')->nullable();
            $table->bigInteger('lesson_id')->nullable();
            $table->integer('is_publish')->default(1);
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
        Schema::dropIfExists('curriculums');
    }
}
