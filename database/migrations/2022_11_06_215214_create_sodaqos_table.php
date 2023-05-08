<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSodaqosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sodaqos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("owner_id")->nullable();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->bigInteger("fundraising_target")->nullable();
            $table->double("admin_fee_percentage")->nullable();
            $table->text("name")->nullable();
            $table->text("time_limit")->nullable();
            $table->longText("story")->nullable();
            $table->string('status')->nullable();
            $table->string('photo')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->foreign("owner_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("category_id")->references("id")->on("sodaqo_categories")->nullOnDelete();
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
        Schema::dropIfExists('sodaqos');
    }
}
