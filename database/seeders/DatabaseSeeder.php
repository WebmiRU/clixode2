<?php

namespace Database\Seeders;

use App\Models\Bucket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
             'name' => 'admin1@admin.admin',
             'email' => 'admin1@admin.admin',
             'password' => Hash::make('admin1@admin.admin'),
        ]);

        $bucket1 = Bucket::create([
            'title' => 'bucket',
            'uri' => 'bucket',
            'user_id' => $user1->id,
            'type' => 'FILE'
        ]);

        $this->call(AuthStatusTableSeeder::class);
    }
}
