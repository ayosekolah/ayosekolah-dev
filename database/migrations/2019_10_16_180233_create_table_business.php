<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("image", 90)->nullable();
            $table->string("name", 60);
            $table->text("description")->nullable();
            $table->string("username", 60)->nullable();
            $table->string("email", 70)->unique();
            $table->string("password", 200);
            $table->text("address")->nullable();
            $table->string("phone", 50)->nullable();
            $table->string("fax", 20)->nullable();
            $table->json("social")->nullable();
            $table->integer("is_valid")->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('business');
    }
}
