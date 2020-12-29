<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageThumbnailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_thumbnail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('image_id')->comment('Id файла');
            $table->integer('image_processor_id')->comment('Id процессора изображений');
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')->on('image')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('image_processor_id')
                ->references('id')->on('image_processor')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement("COMMENT ON TABLE image_thumbnail IS 'Эскиз изображения'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_thumbnail');
    }
}
