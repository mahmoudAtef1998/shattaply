<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comp_description');
//            $table->integer("admin_id")->unsigned();
//            $table->foreign("admin_id")->references('id')->on("admins")->onDelete('cascade');
            $table->integer("job_id")->unsigned()->nullable();
            $table->foreign("job_id")->references('id')->on("jobs")->onDelete('cascade');
            $table->string('complainant');
            $table->boolean('solved')->default(0);
            $table->boolean('counted')->default(1);
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
        Schema::dropIfExists('complains');
    }
}
