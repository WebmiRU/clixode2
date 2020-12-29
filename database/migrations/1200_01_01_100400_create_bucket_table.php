<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->text('type')->comment('Тип');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });

        DB::statement("ALTER TABLE bucket ALTER COLUMN type TYPE enum_bucket_type USING type::enum_bucket_type;");
        DB::statement("COMMENT ON TABLE bucket IS 'Корзина'");
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
