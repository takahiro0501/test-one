<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationTime;

class ReservationTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("reservation_timesの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/reservation_times.json');        
        $json = json_decode($file, true);
        $count = 0;

        $sun = array();
        $mon = array();
        $tue = array();
        $wed = array();
        $thu = array();
        $fri = array();
        $sat = array();

        foreach ($json['data'] as $data) {
            if($data['week_no'] == 0){
                array_push($sun, $data['reservable_time']);
            }elseif($data['week_no'] == 1 ){
                array_push($mon, $data['reservable_time']);
            }elseif($data['week_no'] == 2 ){
                array_push($tue, $data['reservable_time']);
            }elseif($data['week_no'] == 3 ){
                array_push($wed, $data['reservable_time']);
            }elseif($data['week_no'] == 4 ){
                array_push($thu, $data['reservable_time']);
            }elseif($data['week_no'] == 5 ){
                array_push($fri, $data['reservable_time']);
            }elseif($data['week_no'] == 6 ){
                array_push($sat, $data['reservable_time']);
            }
        }

        for($i=0 ; $i < 7 ; $i++){
            if($i==0){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($sun)]
                );
            }elseif($i==1){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($mon)]
                );
            }elseif($i==2){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($tue)]
                );
            }elseif($i==3){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($wed)]
                );
            }elseif($i==4){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($thu)]
                );
            }elseif($i==5){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($fri)]
                );
            }elseif($i==6){
                ReservationTime::create([
                    'week_no' => $i,
                    'reservable_time' => serialize($sat)]
                );
            }
            $count++;
        }
        $this->command->info("reservation_timesを{$count}件、作成しました。");
    }
}
