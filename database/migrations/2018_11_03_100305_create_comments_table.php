<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_num');
            $table->unsignedInteger('root_comment');
            $table->string('root_writer_name',20);
            $table->unsignedInteger('parent_comment');
            $table->unsignedInteger('sequence');
            $table->text('comment');
            $table->string('writer');
            $table->string('name',20);
            $table->timestamps();

            $table->foreign('post_num')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
