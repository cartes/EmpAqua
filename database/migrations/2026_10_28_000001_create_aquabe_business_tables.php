<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Estructura calcada de la base de datos de producción (MariaDB).
 * Cada tabla se crea solo si no existe, de modo que ejecutar la migración
 * sobre producción no modifica nada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('aquabe_business')) {
            Schema::create('aquabe_business', function (Blueprint $table) {
                $table->increments('id');
                $table->string('rut_user');
                $table->string('password');
                $table->string('firstname');
                $table->string('surname');
                $table->string('email_user');
                $table->string('position')->nullable()->default('');
                $table->string('phone_user');
                $table->boolean('migrated')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('aquabe_business_meta')) {
            Schema::create('aquabe_business_meta', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_business');
                $table->string('rut_business')->nullable()->unique();
                $table->string('business_name')->nullable();
                $table->string('fantasy_name')->nullable()->default('');
                $table->string('email')->nullable();
                $table->string('activity')->nullable();
                $table->string('address')->nullable()->default('');
                $table->string('comune')->nullable()->default('');
                $table->string('city')->nullable()->default('');
                $table->string('state')->nullable()->default('');
                $table->string('country')->nullable();
                $table->string('phone')->nullable();
                $table->string('logo')->nullable()->default('');
                $table->string('entry')->nullable()->default('');
                $table->integer('employees')->nullable();
                $table->string('rotation')->nullable()->default('');
                $table->string('path')->nullable();
                $table->string('picture')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_business')->references('id')->on('aquabe_business')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('aquabe_roles')) {
            Schema::create('aquabe_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_business');
                $table->string('role');
                $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('created_at')->nullable();

                $table->foreign('id_business')->references('id')->on('aquabe_business');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('aquabe_roles');
        Schema::dropIfExists('aquabe_business_meta');
        Schema::dropIfExists('aquabe_business');
    }
};
