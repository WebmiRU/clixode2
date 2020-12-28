<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketM2mImageProcessorActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_m2m_image_processor_action', function (Blueprint $table) {
            $table->id();
            $table->integer('bucket_id');
            $table->integer('image_processor_id');
            $table->timestamps();

            $table->foreign('bucket_id')
                ->references('id')->on('bucket')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('image_processor_id')
                ->references('id')->on('image_processor')
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
        Schema::dropIfExists('bucket_m2m_image_processor_action');
    }
}
