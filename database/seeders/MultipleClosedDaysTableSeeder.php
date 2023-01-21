<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MultipleClosedDay;

class MultipleClosedDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("multiple_closed_daysの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/multiple_closed_days.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            MultipleClosedDay::create($data);
            $count++;
        }

        $this->command->info("multiple_closed_daysを{$count}件、作成しました。");
    }
}
