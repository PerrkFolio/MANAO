<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddStatuses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('statuses')->insert([
            [
                'title' => "Новый",
                'alias' => 'new'
            ],
            [
                'title' => "Обработка",
                'alias' => 'process'
            ],
            [
                'title' => "Завершен",
                'alias' => 'done'
            ],
        ]);
    }
}
