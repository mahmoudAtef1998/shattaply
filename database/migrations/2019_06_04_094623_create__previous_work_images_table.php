<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviousWorkImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_work_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("previousWork_id")->unsigned();
            $table->foreign("previousWork_id")->references('id')->on("previous_works")->onDelete('cascade');
            $table->mediumText('image')->nullable();

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
        Schema::dropIfExists('_previous_work_images');
    }
}
