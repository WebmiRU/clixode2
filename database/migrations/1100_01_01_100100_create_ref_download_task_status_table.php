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
            $table->string('title');
        });

        DB::statement("COMMENT ON TABLE download_task IS 'Статус задачи скачивания'");
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
