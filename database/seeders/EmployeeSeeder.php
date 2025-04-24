<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('temployee')->updateOrInsert(
            ['username' => 'admin'],
            [
                'idx' => 1509901127657,
                'prefix_short' => 'น.ส.',
                'fname' => 'แพรวพรรณ',
                'lname' => 'กองศรี',
                'password' => Hash::make('123456'),
                'unit_post' => '101-1400-0',
                'T_Work_name' => 'งานเทคโนโลยีสารสนเทศ',
                'T_Worku_id' => '101-1403-0',
                'T_Worku_name' => 'หน่วยสารสนเทศทางการบริหาร',
                'position_name' => 'นักวิชาการคอมพิวเตอร์',
            ]
        );

        DB::table('user_book')->updateOrInsert(
            ['idx' => 1509901127657],
            ['flag' => 1]
        );
    }
}
