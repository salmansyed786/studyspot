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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'community_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText(column: 'about');
            $table->integer(column: 'members')->default(1);
            $table->integer(column: 'posts')->default(0);
            $table->string(column: 'image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities');
    }
};