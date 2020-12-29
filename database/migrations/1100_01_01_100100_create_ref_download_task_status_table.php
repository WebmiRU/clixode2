<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefDownloadTaskStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref.download_task_status', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->text('title');
            $table->text('key')->unique()->comment('Ключ');
            $table->integer('sort')->default(0)->comment('Сортировка');
        });

        DB::statement("COMMENT ON TABLE ref.download_task_status IS 'Статус задачи скачивания'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref.download_task_status');
    }
}
