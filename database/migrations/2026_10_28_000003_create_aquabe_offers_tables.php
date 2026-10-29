<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Estructura calcada de la base de datos de producción (MariaDB).
 * Cada tabla se crea solo si no existe.
 * Nota: en producción aquabe_offers no tiene claves foráneas, solo índices.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('aquabe_categories')) {
            Schema::create('aquabe_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->longText('description');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_offers')) {
            Schema::create('aquabe_offers', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_business')->index('aquabe_offers_id_business_foreign');
                $table->string('title');
                $table->string('slug')->nullable();
                $table->longText('description');
                $table->boolean('handicapped')->nullable();
                $table->string('area');
                $table->string('sub_area');
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('comune')->nullable();
                $table->string('country')->nullable();
                $table->string('salary', 50)->nullable();
                $table->string('salary_array')->nullable();
                $table->integer('category_id')->default(1);
                $table->string('position')->nullable();
                $table->string('experience')->nullable();
                $table->string('visit')->nullable();
                $table->longText('requirements')->nullable();
                $table->integer('period')->nullable();
                $table->string('status')->nullable()->default('1')->index('aquabe_offers_status_idx');
                $table->boolean('featured')->nullable()->default(0);
                $table->tinyInteger('published')->default(1);
                $table->integer('vacancy')->nullable();
                $table->timestamp('expirated_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('aquabe_offers_benefit')) {
            Schema::create('aquabe_offers_benefit', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('offer_id')->index('aquabe_offers_benefit_offer_id_foreign');
                $table->string('benefit');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_offers_candidates')) {
            Schema::create('aquabe_offers_candidates', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('id_offer')->index('aquabe_offers_candidates_id_offer_foreign');
                $table->unsignedInteger('id_user')->index('aquabe_offers_candidates_id_candidate_foreign');
                $table->tinyInteger('status')->nullable()->index('aquabe_offers_candidates_status_idx');
                $table->tinyInteger('favorite')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('aquabe_candidate_statuses')) {
            Schema::create('aquabe_candidate_statuses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('candidate_id')->index('candidate_id');
                $table->unsignedInteger('offer_id')->index('offer_id');
                $table->string('status')->index('aquabe_candidate_statuses_status_idx');
                $table->timestamps();

                $table->foreign('candidate_id', 'aquabe_candidate_statuses_ibfk_1')
                    ->references('id')->on('aquabe_users')->onDelete('cascade');
                $table->foreign('offer_id', 'aquabe_candidate_statuses_ibfk_2')
                    ->references('id')->on('aquabe_offers')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('aquabe_candidate_statuses');
        Schema::dropIfExists('aquabe_offers_candidates');
        Schema::dropIfExists('aquabe_offers_benefit');
        Schema::dropIfExists('aquabe_offers');
        Schema::dropIfExists('aquabe_categories');
    }
};
