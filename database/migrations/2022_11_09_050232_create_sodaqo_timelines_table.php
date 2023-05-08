<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSodaqoTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sodaqo_timelines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sodaqo_id")->nullable();
            $table->foreign("sodaqo_id")->references("id")->on("sodaqos")->nullOnDelete();
            $table->longText('content')->nullable();
            $table->string("title")->nullable();
            $table->string("subtitle")->nullable();
            $table->string("expense")->nullable();
            $table->string("expense_admin")->nullable();
            $table->string("expense_desc")->nullable();
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
        Schema::dropIfExists('sodaqo_timelines');
    }
}
