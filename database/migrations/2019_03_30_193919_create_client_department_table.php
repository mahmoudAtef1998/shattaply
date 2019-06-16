<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_department', function (Blueprint $table) {
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references('id')->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('client_department');
    }
}
