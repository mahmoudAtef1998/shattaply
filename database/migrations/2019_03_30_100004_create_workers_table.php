<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("last_name");
            $table->string("user_name")->nullable();
            $table->string("password");
            $table->integer("age");
            $table->string("email");
            $table->string("work")->nullable();
            $table->string("phone")->unique();
            $table->string("region");
            $table->string('city');
            $table->boolean("status")->default(0);
            $table->boolean("accepted")->default(0);
            $table->boolean("ban")->default(0);
            $table->float("average_salary");
            $table->float("total_rate")->nullable();
            $table->float("total_service_time")->nullable();
            $table->float("total_moral")->nullable();
            $table->mediumText('image')->nullable();
            $table->timestamp('baned_at')->nullable();
            $table->string("national_card")->nullable();
            $table->string("fish_tashbih")->nullable();
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
        Schema::dropIfExists('workers');
    }
}
