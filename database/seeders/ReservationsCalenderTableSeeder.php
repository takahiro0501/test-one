<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationCalender;

class ReservationsCalenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("reservation_calendersの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/reservation_calenders.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            ReservationCalender::create($data);
            $count++;
        }

        $this->command->info("reservation_calendersを{$count}件、作成しました。");
    }
}
