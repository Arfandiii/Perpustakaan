<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EduLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('edu_levels')->insert([
            ['name' => 'X'],
            ['name' => 'XI'],
            ['name' => 'XII']
        ]);
    }
}
