<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSodaqosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sodaqos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sodaqo_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("payment_id")->nullable();

            $table->string("photo")->nullable();
            $table->bigInteger("nominal")->nullable();
            $table->bigInteger("nominal_net")->nullable();


            $table->foreign("sodaqo_id")->references("id")->on("sodaqos")->nullOnDelete();
            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("payment_id")->references("id")->on("donation_accounts")->nullOnDelete();

            $table->string("is_anonym")->nullable();
            $table->string("is_whatsapp_enabled")->nullable();

            $table->longText("doa")->nullable();

            $table->longText("notes_admin")->nullable();
            $table->string("status")->nullable();

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
        Schema::dropIfExists('user_sodaqos');
    }
}
