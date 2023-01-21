<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("staffsの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/staffs.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            Staff::create($data);
            $count++;
        }

        $this->command->info("staffsを{$count}件、作成しました。");
    }
}
