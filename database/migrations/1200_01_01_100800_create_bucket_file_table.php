<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBucketFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_file', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Имя');
            $table->integer('bucket_id')->comment('Id корзины');
            $table->bigInteger('file_id')->comment('Id файла');
            $table->text('uri')->nullable()->comment('URI');
            $table->timestamps();

            $table->foreign('bucket_id')
                ->references('id')->on('bucket')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('file_id')
                ->references('id')->on('file')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement("COMMENT ON TABLE bucket_file IS 'Файл в корзине'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bucket_file');
    }
}
