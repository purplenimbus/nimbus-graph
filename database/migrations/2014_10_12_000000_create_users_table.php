<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
            $table->string('fname');
			$table->string('lname');
			$table->string('access_level');
			//$table->string('displayName')->nullable();
			$table->date('dob')->nullable();
			$table->char('sex',1)->nullable();
            $table->string('email')->unique();
            $table->string('address')->unique();
            $table->string('password')->nullable();
			$table->integer('tenant_id')->nullable();
			$table->string('image_url')->nullable();
			$table->json('meta');
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
        Schema::dropIfExists('users');
    }
}
