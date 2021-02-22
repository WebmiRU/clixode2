<?php

namespace Database\Seeders\Public1;

use App\Models\Bucket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserBucketSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
