<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("reservationsの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/reservations.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            Reservation::create($data);
            $count++;
        }

        $this->command->info("reservationsを{$count}件、作成しました。");
    }
}
