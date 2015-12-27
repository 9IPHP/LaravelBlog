<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('thumb')->nullable();
            $table->text('excerpt');
            $table->text('body');
            $table->boolean('comment_status')->default(0);
            $table->integer('comment_count')->unsigned()->default(0);
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('like_count')->unsigned()->default(0);
            $table->integer('collect_count')->unsigned()->default(0);
            $table->integer('report_count')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            // 生成外键，并且指定在删除用户时同时删除该用户的所有文章
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
