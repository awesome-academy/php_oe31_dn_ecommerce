<?php

use Illuminate\Database\Seeder;
use App\Models\Trend;

class TrendTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_trends = [
            0 => [
                'title' => 'Đón tết vui vẻ cùng chúng tôi, đại hạ giá',
                'start_date' => '2020-01-01',
                'end_date' => '2020-01-31',
            ],
            1 => [
                'title' => 'Chào đón mùa xuân mới',
                'start_date' => '2020-02-01',
                'end_date' => '2020-02-29',
            ]
        ];
        for($i = 0; $i < sizeof($arr_trends); $i++) {
            Trend::create([
                'title' => $arr_trends[$i]['title'],
                'start_date' => $arr_trends[$i]['start_date'],
                'end_date' => $arr_trends[$i]['end_date'],
            ]);
        }
    }
}
