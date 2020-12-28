<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessorActionParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_processor_action_param', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('name')->comment('Имя');
            $table->text('description')->comment('Описание');
            $table->text('type')->comment('Тип');
            $table->bigInteger('image_processor_action_id')->comment('Id действия процессора изображения');
            $table->timestamps();

            $table->foreign('image_processor_action_id')
                ->references('id')->on('image_processor_action')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement('ALTER TABLE image_processor_action_param MODIFY COLUMN type USING enum_bucket_type');
        DB::statement("COMMENT ON TABLE image_processor_action_param IS 'Параметр действия процессора изображений'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_processor_action_param');
    }
}
