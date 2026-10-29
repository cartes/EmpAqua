<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Offers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aquabe_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_business');
            $table->foreign('id_business')->references('id')->on('aquabe_business');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->boolean('handicapped')->nullable();
            $table->string('area');
            $table->string('sub_area');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('comune')->nullable();
            $table->string('country')->nullable();
            $table->integer('salary')->nullable();
            $table->string('position')->nullable();
            $table->string('experience')->nullable();
            $table->string('views')->nullable()->default(0);
            $table->longText('requirements')->nullable();
            $table->integer('period');
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamp('expirated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('aquabe_offers_candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_offer');
            $table->foreign('id_offer')->references('id')->on('aquabe_offers');
            $table->unsignedInteger('id_candidate');
            $table->foreign('id_candidate')->references('id')->on('aquabe_users');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('aquabe_offers');
        Schema::dropIfExists('aquabe_offers_candidates');
    }
}
