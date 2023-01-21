<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sentence;

class SentencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("sentencesの作成を開始します...");

        $file = file_get_contents(__DIR__ . '/data/sentences.json');
        $json = json_decode($file, true);
        $count = 0;
        foreach ($json['data'] as $data) {
            Sentence::create($data);
            $count++;
        }
        $this->command->info("sentencesを{$count}件、作成しました。");

    }
}
