<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //初期投入マスタデータ
        $this->call(SentencesSeeder::class);
        $this->call(FooterLinkSeeder::class);
        $this->call(StaffsTableSeeder::class);
        $this->call(MultipleClosedDaysTableSeeder::class);
        $this->call(ReservationTimesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(MenusTableSeeder::class);
//        $this->call(SingleClosedDaysTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    //サンプルデータ
        //$this->call(ReservationsTableSeeder::class);
        //$this->call(ReservationsCalenderTableSeeder::class);

    }
}
