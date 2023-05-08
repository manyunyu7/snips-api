<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("belongs_to")->nullable();
            $table->boolean("is_finished")->nullable();
            $table->string("notes")->nullable();
            $table->foreign("belongs_to")->references("id")->on("users")->cascadeOnDelete();
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
        Schema::dropIfExists('chat_topics');
    }
}
