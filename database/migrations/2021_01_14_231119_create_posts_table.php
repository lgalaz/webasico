<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('post_id');
            $table->bigInteger('website_id')->unsigned();
            $table->bigInteger('parent_post_id')->unsigned()->nullable();
            $table->longText('content');
            $table->string('excerpt', 200);
            $table->string('name', 200);
            $table->string('password', 20);
            $table->integer('comment_couunt')->default(0);
            $table->boolean('allowComments')->default(false);
            $table->boolean('published')->default(false);
            $table->timestamps();

            $table->foreign('parent_post_id')
                ->references('post_id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('website_id')
                ->references('website_id')
                ->on('websites')
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
        Schema::dropIfExists('posts');
    }
}
