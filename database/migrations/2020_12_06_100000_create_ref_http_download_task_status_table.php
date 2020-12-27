<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefHttpDownloadTaskStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_http_download_task_status', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title');
        });

        DB::table('ref_http_download_task_status')->insert([
            [
                'id' => 1,
                'title' => 'Новая задача',
            ],
            [
                'id' => 10,
                'title' => 'Завершенная задача',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_http_download_task_status');
    }
}
