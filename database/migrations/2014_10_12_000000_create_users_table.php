<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aquabe_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut_user')->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nacionality')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('aquabe_users_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('pretentions')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('comune')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('objectives')->nullable();
            $table->timestamps();
        });

        Schema::create('aquabe_users_experience', function (Blueprint $table) {
            $table->increments('id_experience');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('business_name');
            $table->string('business_activity');
            $table->string('business_position');
            $table->string('experience_level');
            $table->string('month_from')->nullable();
            $table->string('year_from')->nullable();
            $table->string('month_to')->nullable();
            $table->string('year_to')->nullable();
            $table->boolean('to_present')->nullable();
            $table->string('area');
            $table->string('sub_area');
            $table->string('description');
            $table->integer('dependents')->nullable();
            $table->timestamps();
        });

        Schema::create('aquabe_users_education', function(Blueprint $table) {
            $table->increments('id_education');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('country');
            $table->string('studies');
            $table->string('condition');
            $table->string('title');
            $table->string('area');
            $table->string('month_from')->nullable();
            $table->string('year_from')->nullable();
            $table->string('month_to')->nullable();
            $table->string('year_to')->nullable();
            $table->boolean('to_present')->nullable();
            $table->text('institution');
            $table->timestamps();
        });

        Schema::create('aquabe_users_language', function (Blueprint $table) {
            $table->increments('id_language');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('language');
            $table->integer('level_written');
            $table->integer('level_spoken');
            $table->timestamps();
        });

        Schema::create('aquabe_users_skills', function (Blueprint $table) {
            $table->increments('id_skills');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('skill');
            $table->timestamps();
        });

        Schema::create('aquabe_users_references', function (Blueprint $table) {
            $table->increments('id_references');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('aquabe_users');
            $table->string('referencer_firstname');
            $table->string('referencer_surname');
            $table->string('referencer_email');
            $table->string('referencer_business');
            $table->string('referencer_phone');
            $table->string('referencer_type');
            $table->string('referencer_relation');
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
        Schema::dropIfExists('aquabe_users');
        Schema::dropIfExists('aquabe_users_meta');
        Schema::dropIfExists('aquabe_users_experience');
        Schema::dropIfExists('aquabe_users_education');
        Schema::dropIfExists('aquabe_users_language');
        Schema::dropIfExists('aquabe_users_skills');
        Schema::dropIfExists('aquabe_users_references');
    }
}
