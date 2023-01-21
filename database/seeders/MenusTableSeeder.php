<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("メニュー情報データの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/menus.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            Menu::create($data);
            $count++;
        }

        $this->command->info("メニュー情報を{$count}件、作成しました。");
    }
}
