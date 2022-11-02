<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddCategorirs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => "Паркин Максим",
                'alias' => 'паркин'
            ],
            [
                'title' => "Сотрудник 1",
                'alias' => 'сотрудник1'
            ],
            [
                'title' => "Сотрудник 2",
                'alias' => 'сотрудник2'
            ]
        ]);
    }
}
