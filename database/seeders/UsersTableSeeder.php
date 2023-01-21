<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("usersの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/users.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {

            $data['password'] = Hash::make($data['password']);
            User::create($data);
            $count++;
        }

        $this->command->info("Userを{$count}件、作成しました。");
    }
}
