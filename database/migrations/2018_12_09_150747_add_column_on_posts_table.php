<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function (Blueprint $table) {
                $table->tinyInteger('view_count')->default(0);

                if(config('database.default') == 'mysql'){
                    DB::statement('ALTER TABLE posts ADD FULLTEXT search(title, content)');
                }
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('view_count');
            });
        });
    }
}
