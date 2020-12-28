<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessorActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_processor_action', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->comment('Имя');
            $table->text('description')->comment('Описание');
        });

        DB::statement("COMMENT ON TABLE image_processor_action IS 'Действие роцессор изображений'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_processor_action');
    }
}
