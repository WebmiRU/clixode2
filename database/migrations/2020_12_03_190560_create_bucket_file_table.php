<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_file', function (Blueprint $table) {
            $table->id();
            $table->integer('bucket_id');
            $table->bigInteger('file_id');
            $table->text('name');
            $table->text('uri')->nullable()->comment('URI');
            $table->timestamps();

            $table->foreign('bucket_id')
                ->references('id')->on('bucket')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('file_id')
                ->references('id')->on('file')
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
        Schema::dropIfExists('bucket_file');
    }
}
