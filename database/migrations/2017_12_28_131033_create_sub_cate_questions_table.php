<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_cate_questions', function (Blueprint $table) {
            $table->increments('id');
             $table->string('name');
            $table->string('slug');
            $table->integer('id_cate_question')->unsigned()->notnull();
            $table->foreign('id_cate_question')->references('id')->on('cate_questions');
            $table->text('description');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('sub_cate_questions');
    }
}
