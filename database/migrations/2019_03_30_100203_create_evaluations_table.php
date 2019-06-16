<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->float('rate')->nullable();
            $table->float("service_time")->nullable();
            $table->text("service_description")->nullable();
            $table->float("worker_moral")->nullable();
            $table->integer("worker_id")->unsigned();
            $table->foreign("worker_id")->references('id')->on("workers")->onDelete('cascade');
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references('id')->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('evaluations');
    }
}
