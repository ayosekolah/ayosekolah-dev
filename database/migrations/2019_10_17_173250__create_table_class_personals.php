<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClassPersonals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('clas_id')->nullable();
            $table->bigInteger('personal_busines_id');
            $table->integer("is_aprroved")->default(0);
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
        Schema::dropIfExists('class_personals');
    }
}
