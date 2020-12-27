<?php

namespace Database\Seeders\Ref;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HttpDownloadTaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref.http_download_task_status')->insert([
            [
                'id' => 1,
                'title' => 'Новая задача',
            ],
            [
                'id' => 10,
                'title' => 'Завершенная задача',
            ],
        ]);
    }
}
