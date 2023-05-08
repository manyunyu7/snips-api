<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('payment_merchant_id')->nullable();
            $table->string("payment_merchant_name")->nullable();
            $table->string('name')->nullable();
            $table->string('account_number')->nullable();
            $table->text('m_description')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_merchant_id')->references('id')->on('payment_merchants')->onDelete('cascade');
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
        Schema::dropIfExists('donation_accounts');
    }
}
