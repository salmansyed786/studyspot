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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->nullable()->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId(column: 'post_id')->nullable()->constrained(table: 'posts')->cascadeOnDelete();
            $table->longText('description');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime("updated_at")->useCurrent();
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
};