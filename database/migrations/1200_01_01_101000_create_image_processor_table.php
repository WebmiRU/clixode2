<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_processor', function (Blueprint $table) {
            $table->id();
            $table->integer('bucket_id')->comment('Id корзины');
            $table->integer('image_id')->comment('Id изображения');
            $table->text('name')->comment('Имя');
            $table->text('uri')->nullable()->comment('URI');
            $table->timestamps();

            $table->foreign('bucket_id')
                ->references('id')->on('bucket')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('image_id')
                ->references('id')->on('image')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement("COMMENT ON TABLE image_processor IS 'Процессор изображений'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_processor');
    }
}
