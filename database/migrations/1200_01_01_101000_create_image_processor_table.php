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
            $table->text('title');
            $table->text('name')->comment('Имя');
            $table->text('description')->comment('Описание');
            $table->text('uri')->nullable()->comment('URI');
            $table->integer('user_id')->comment('Id пользователя');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('user')
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
