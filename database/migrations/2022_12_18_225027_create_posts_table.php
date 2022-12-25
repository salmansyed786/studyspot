<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string(column: 'author');
                $table->string(column: 'title');
                $table->longText(column: 'description');
                $table->integer(column: 'comments')->default('0');
                $table->integer(column: 'likes')->default('0');
                $table->integer(column: 'dislikes')->default('0');
                $table->integer(column: 'views')->default('0');
                $table->string(column: 'image')->nullable();
                $table->string(column: 'color')->default('#FFFF99');
                $table->string(column: 'textColor')->default('#000000');
                $table->string(column: 'tags')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId(column: 'community_id')->nullable()->constrained(table: 'communities')->cascadeOnDelete();
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
};