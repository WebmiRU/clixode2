<?php

namespace Database\Seeders\Ref;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DownloadTaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref.download_task_status')->insert([
            [
                'id' => 1,
                'title' => 'Новая задача',
                'key' => 'new',
            ],
            [
                'id' => 5,
                'title' => 'Загрузка',
                'key' => 'downloading',
            ],
            [
                'id' => 9,
                'title' => 'Ошибка',
                'key' => 'error',
            ],
            [
                'id' => 10,
                'title' => 'Завершенная задача',
                'key' => 'completed',
            ],
        ]);
    }
}
