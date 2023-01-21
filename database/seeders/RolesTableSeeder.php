<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("rolesの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/roles.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            Role::create($data);
            $count++;
        }

        $this->command->info("rolesを{$count}件、作成しました。");
    }
}
