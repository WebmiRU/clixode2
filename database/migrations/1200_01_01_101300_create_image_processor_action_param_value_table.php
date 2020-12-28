<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessorActionParamValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_processor_action_param_value', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('image_processor_action_id')->comment('Id действия процессора изображения');
            $table->timestamps();

            $table->foreign('image_processor_action_id')
                ->references('id')->on('image_processor_action')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });

        DB::statement("COMMENT ON TABLE image_processor_action_param_value IS 'Значение параметра действия процессора изображений'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_processor_action_param_value');
    }
}
