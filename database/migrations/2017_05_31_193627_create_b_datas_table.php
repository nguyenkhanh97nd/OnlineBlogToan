<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
            $table->integer('submit')->default(0);
            $table->integer('id_post')->unsigned()->notnull();;
            $table->foreign('id_post')->references('id')->on('posts');
            $table->integer('id_user')->unsigned()->notnull();;
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('ans_data');
            $table->dateTime('time_started');
            $table->time('time_did');
            $table->float('point_exam', 4, 2)->default(0);
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
        Schema::dropIfExists('b_datas');
    }
}
