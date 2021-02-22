<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** Создание схемы для справочников */
        DB::statement('CREATE SCHEMA IF NOT EXISTS ref');
        /** Создание схемы для логов */
        DB::statement('CREATE SCHEMA IF NOT EXISTS log');

        /** Комментарии */
        DB::statement("COMMENT ON SCHEMA log IS 'Логи'");
        DB::statement("COMMENT ON SCHEMA ref IS 'Справочники'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** Удаление схемы для справочников */
        Schema::dropIfExists('ref');
        /** Удаление схемы для логов */
        Schema::dropIfExists('log');
    }
}
