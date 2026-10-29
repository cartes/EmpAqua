<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Estructura calcada de la base de datos de producción (MariaDB).
 * Cada tabla se crea solo si no existe.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('aquabe_users')) {
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
                $table->string('path')->nullable();
                $table->string('picture')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_meta')) {
            Schema::create('aquabe_users_meta', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_user')->index('aquabe_users_meta_id_user_foreign');
                $table->string('pretentions')->nullable()->default('');
                $table->string('phone')->nullable()->default('');
                $table->string('address')->nullable()->default('');
                $table->string('comune')->nullable()->default('');
                $table->string('city')->nullable()->default('');
                $table->string('country')->nullable()->default('');
                $table->string('state')->nullable()->default('');
                $table->longText('objectives')->nullable();
                $table->string('path')->nullable();
                $table->string('filename')->nullable();
                $table->string('extra_path')->nullable();
                $table->string('extra_filename')->nullable();
                $table->string('support_doc_path', 191)->nullable();
                $table->string('support_doc_name', 191)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_experience')) {
            Schema::create('aquabe_users_experience', function (Blueprint $table) {
                $table->increments('id_experience');
                $table->unsignedInteger('id_user')->index('aquabe_users_experience_id_user_foreign');
                $table->string('business_name');
                $table->string('business_activity')->nullable();
                $table->string('business_position');
                $table->string('business_country')->nullable();
                $table->string('experience_level');
                $table->string('month_from')->nullable();
                $table->string('year_from');
                $table->string('month_to')->nullable()->default('');
                $table->string('year_to')->nullable()->default('');
                $table->boolean('to_present')->nullable()->default(0);
                $table->string('area')->nullable();
                $table->string('sub_area')->nullable();
                $table->longText('description');
                $table->integer('dependents')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_education')) {
            Schema::create('aquabe_users_education', function (Blueprint $table) {
                $table->increments('id_education');
                $table->unsignedInteger('id_user')->index('aquabe_users_education_id_user_foreign');
                $table->string('country')->nullable();
                $table->string('studies')->nullable();
                $table->string('condition');
                $table->string('title');
                $table->string('area')->nullable();
                $table->string('month_from')->nullable();
                $table->string('year_from')->nullable();
                $table->string('month_to')->nullable();
                $table->string('year_to');
                $table->boolean('to_present')->nullable();
                $table->string('institution');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_language')) {
            Schema::create('aquabe_users_language', function (Blueprint $table) {
                $table->increments('id_language');
                $table->unsignedInteger('id_user')->index('aquabe_users_language_id_user_foreign');
                $table->string('language');
                $table->integer('level_written');
                $table->integer('level_spoken');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_skills')) {
            Schema::create('aquabe_users_skills', function (Blueprint $table) {
                $table->increments('id_skills');
                $table->unsignedInteger('id_user')->index('aquabe_users_skills_id_user_foreign');
                $table->string('skill');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_users_references')) {
            Schema::create('aquabe_users_references', function (Blueprint $table) {
                $table->increments('id_references');
                $table->unsignedInteger('id_user')->index('aquabe_users_references_id_user_foreign');
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
    }

    public function down(): void
    {
        Schema::dropIfExists('aquabe_users_references');
        Schema::dropIfExists('aquabe_users_skills');
        Schema::dropIfExists('aquabe_users_language');
        Schema::dropIfExists('aquabe_users_education');
        Schema::dropIfExists('aquabe_users_experience');
        Schema::dropIfExists('aquabe_users_meta');
        Schema::dropIfExists('aquabe_users');
    }
};
