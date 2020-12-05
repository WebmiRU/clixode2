<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('uri')->nullable()->comment('URI');
            $table->integer('user_id')->comment('Id юзера');
            $table->enum('type', ['IMAGE', 'FILE'])->comment('Тип');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bucket');
    }
}
