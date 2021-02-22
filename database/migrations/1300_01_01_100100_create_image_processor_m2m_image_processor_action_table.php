<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessorM2mImageProcessorActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_processor_m2m_image_processor_action', function (Blueprint $table) {
            $table->id();
            $table->integer('image_processor_id');
            $table->integer('image_processor_action_id');
            $table->timestamps();

            $table->foreign('image_processor_id')
                ->references('id')->on('image_processor')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('image_processor_action_id')
                ->references('id')->on('image_processor_action')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_processor_m2m_image_processor_action');
    }
}
