<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEnumImageProcessorActionParamType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TYPE enum_image_processor_action_param_type AS ENUM ('STRING', 'INT', 'TEXT', 'IMAGE', 'BOOL')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('DROP TYPE enum_image_processor_action_param_type');
    }
}
