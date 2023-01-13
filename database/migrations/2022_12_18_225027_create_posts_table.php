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
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string(column: 'title');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                // $table->string(column: 'author');
                $table->longText(column: 'description');
                $table->integer(column: 'comments')->default('0');
                $table->integer(column: 'likes')->default('0');
                $table->integer(column: 'dislikes')->default('0');
                $table->integer(column: 'views')->default('0');
                $table->string(column: 'image')->nullable();
                $table->string(column: 'color')->default('#FFFF99');
                $table->string(column: 'textColor')->default('#000000');
                $table->string(column: 'tags')->nullable();
                $table->foreignId(column: 'community_id')->nullable()->constrained(table: 'communities')->cascadeOnDelete();
                $table->timestamps();
    
                // $table->foreign('author')->references('username')->on('users')->onDelete('cascade');
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