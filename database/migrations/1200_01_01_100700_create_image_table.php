<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->string('sha256', 64)->comment('Хэш 256');
            $table->bigInteger('size')->comment('Размер');
            $table->text('mime_type')->comment('Тип mime');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE file IS 'Файл'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image');
    }
}
