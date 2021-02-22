<?php

namespace Database\Seeders;

use Database\Seeders\Public1\UserBucketSeeder;
use Database\Seeders\Ref\DownloadTaskStatusSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //ref
        $this->call(DownloadTaskStatusSeeder::class);

        //public1
        $this->call(UserBucketSeeder::class);
    }
}
