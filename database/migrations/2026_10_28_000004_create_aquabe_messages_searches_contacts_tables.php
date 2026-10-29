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
        if (!Schema::hasTable('aquabe_messages')) {
            Schema::create('aquabe_messages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('subject')->nullable();
                $table->integer('offer_id');
                $table->integer('user_id');
                $table->integer('sender_id')->nullable();
                $table->longText('content')->nullable();
                $table->integer('message_id')->nullable();
                $table->tinyInteger('status')->nullable()->index('aquabe_messages_status_idx');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_searches')) {
            Schema::create('aquabe_searches', function (Blueprint $table) {
                // En producción esta tabla es utf8mb3 / utf8mb3_general_ci.
                $table->charset = 'utf8mb3';
                $table->collation = 'utf8mb3_general_ci';

                $table->increments('id');
                $table->string('search_term')->nullable()->default('');
                $table->integer('user_id')->nullable();
                $table->bigInteger('quantity')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('aquabe_searches');
        Schema::dropIfExists('aquabe_messages');
    }
};
