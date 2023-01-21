<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterLink;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("footer_linksの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/footer_links.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            FooterLink::create($data);
            $count++;
        }

        $this->command->info("footer_linksを{$count}件、作成しました。");

    }
}
