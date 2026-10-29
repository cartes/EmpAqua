<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aquabe_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->unsignedInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('aquabe_offers');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('aquabe_users');
            $table->integer('sender_id');
            $table->text('content');
            $table->text('message_id')->nullable();
            $table->tinyInteger('staus');
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
        Schema::dropIfExists('aquabe_messages');
    }
}
