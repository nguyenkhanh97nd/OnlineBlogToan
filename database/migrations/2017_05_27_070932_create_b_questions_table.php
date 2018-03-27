<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('id_post')->unsigned()->notnull();;
            $table->foreign('id_post')->references('id')->on('posts');
            $table->text('ans_a');
            $table->text('ans_b');
            $table->text('ans_c');
            $table->text('ans_d');
            $table->string('ans_true');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('b_questions');
    }
}
