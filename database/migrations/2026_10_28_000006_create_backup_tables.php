<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Tablas de respaldo que existen en producción. La aplicación no las usa;
 * se mantienen para conservar la estructura idéntica. Se crean solo si no existen.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('aquabe_business_meta_huerfanos_backup')) {
            Schema::create('aquabe_business_meta_huerfanos_backup', function (Blueprint $table) {
                // Tabla latin1, con las columnas de texto en utf8mb4_unicode_ci.
                $table->charset = 'latin1';
                $table->collation = 'latin1_swedish_ci';

                $mysql = in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb']);
                $text = function (string $name, bool $nullable = true, $default = null) use ($table, $mysql) {
                    $col = $table->string($name)->nullable($nullable)->default($default);
                    if ($mysql) {
                        $col->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
                    }
                    return $col;
                };

                $table->unsignedInteger('id')->default(0);
                $table->unsignedInteger('id_business');
                $text('rut_business');
                $text('business_name');
                $text('fantasy_name', true, '');
                $text('email');
                $text('activity');
                $text('address', true, '');
                $text('comune', true, '');
                $text('city', true, '');
                $text('state', true, '');
                $text('country');
                $text('phone');
                $text('logo', true, '');
                $text('entry', true, '');
                $table->integer('employees')->nullable();
                $text('rotation', true, '');
                $text('path');
                $text('picture');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('backupaq_offers')) {
            // En MySQL/MariaDB el índice conserva el nombre de producción; SQLite exige nombres únicos por base.
            Schema::create('backupaq_offers', function (Blueprint $table) {
                $table->unsignedInteger('id')->primary();
                $table->unsignedInteger('id_business')->index(in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb']) ? 'aquabe_offers_id_business_foreign' : 'backupaq_offers_id_business_foreign');
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
                $table->string('status')->nullable()->default('1')->index('backupaq_offers_status_idx');
                $table->boolean('featured')->nullable()->default(0);
                $table->tinyInteger('published')->default(1);
                $table->integer('vacancy')->nullable();
                $table->timestamp('expirated_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('user_region___user_region_')) {
            Schema::create('user_region___user_region_', function (Blueprint $table) {
                $table->charset = 'utf8mb3';
                $table->collation = 'utf8mb3_general_ci';

                $table->bigInteger('id')->nullable();
                $table->string('name', 40)->nullable();
                $table->string('surname', 33)->nullable();
                $table->string('comune', 47)->nullable();
                $table->string('city', 62)->nullable();
                $table->bigInteger('id_user')->nullable();
                $table->integer('region')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_region___user_region_');
        Schema::dropIfExists('backupaq_offers');
        Schema::dropIfExists('aquabe_business_meta_huerfanos_backup');
    }
};
