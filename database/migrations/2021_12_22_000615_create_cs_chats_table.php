<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger("sender_id")->nullable();
            $table->unsignedBigInteger("recepient_id")->nullable();
            $table->string("type")->nullable();
            $table->string("photo")->nullable();
            $table->text("message")->nullable();
            $table->boolean("is_read")->nullable();
            $table->foreign("topic_id")->references("id")->on("chat_topics")->onDelete("cascade");
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
        Schema::dropIfExists('cs_chats');
    }
}
