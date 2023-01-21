<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OpenTime;

class OpenTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("open_timesの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/open_times.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            OpenTime::create($data);
            $count++;
        }

        $this->command->info("open_timesを{$count}件、作成しました。");
    }
}
