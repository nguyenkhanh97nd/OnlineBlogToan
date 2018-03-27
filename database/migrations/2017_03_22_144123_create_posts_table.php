<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('brief');
            $table->longText('content');
            $table->string('image');
            $table->integer('count_views')->default(0);
            $table->dateTime('time_start');
            $table->time('time_do');
            $table->tinyInteger('status')->default(0);
            $table->integer('subcategory_id')->unsigned()->notnull();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->integer('author_id')->unsigned()->notnull();
            $table->foreign('author_id')->references('id')->on('users');
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
        Schema::dropIfExists('posts');
    }
}
