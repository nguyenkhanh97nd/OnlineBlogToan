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
            $table->string('username',20);
            $table->string('password',60);
            $table->string('name')->nullable();
            $table->tinyInteger('gender');
            $table->string('avatar')->nullable();
            $table->string('info')->nullable();
            $table->string('email');
            $table->integer('point_activity')->default(50);
            $table->float('gpa', 4, 2)->default(0);
            $table->integer('level')->default(3);
            $table->tinyInteger('status')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
