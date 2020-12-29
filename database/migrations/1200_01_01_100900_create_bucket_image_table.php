<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBucketImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_image', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Имя');
            $table->text('uri')->nullable()->comment('URI');
            $table->integer('bucket_id')->comment('Id корзины');
            $table->bigInteger('image_id')->comment('Id файла');

            $table->foreign('bucket_id')
                ->references('id')->on('bucket')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('image_id')
                ->references('id')->on('image')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement("COMMENT ON TABLE bucket_image IS 'Изображение в корзины'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bucket_image');
    }
}
