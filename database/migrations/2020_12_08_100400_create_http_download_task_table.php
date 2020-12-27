<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHttpDownloadTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_download_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('url')->comment('Ссылка, скачиваемого файла');
            $table->decimal('progress', 5, 2)->comment('Прогресс в процентах');
            $table->integer('bucket_id')->comment('Id корзины');
            $table->integer('ref_http_download_task_status_id')->comment('Id справочника статусов скачиваемого задания');
            $table->timestamps();

            $table->foreign('ref_http_download_task_status_id')->references('id')
                ->on('ref_http_download_task_status')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->foreign('bucket_id')->references('id')->on('bucket')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('http_download_task');
    }
}
