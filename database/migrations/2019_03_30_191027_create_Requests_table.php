<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jop_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->text("description");
            $table->string("location");
            $table->string("state");
            $table->integer("worker_id")->unsigned();
            $table->foreign("worker_id")->references('id')->on("workers")->onDelete('cascade');
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references('id')->on("users")->onDelete('cascade');
            $table->date("started")->nullable();
            $table->date("finished")->nullable();
            $table->boolean("ended_user")->nullable();
            $table->boolean("ended_worker")->nullable();

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
        Schema::dropIfExists('jop_requests');
    }
}
