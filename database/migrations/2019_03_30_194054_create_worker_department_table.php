<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_department', function (Blueprint $table) {
            $table->integer("worker_id")->unsigned();
            $table->foreign("worker_id")->references('id')->on("workers")->onDelete('cascade');
            $table->integer("dep_id")->unsigned();
            $table->foreign("dep_id")->references('id')->on("departments")->onDelete('cascade');
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
        Schema::dropIfExists('worker_department');
    }
}
