<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            0 => [
                0 =>'Áo',
                1 => [
                    1 => 'Áo Thun', 2 => 'Áo Thu Đông', 3 => 'Áo Sơ Mi',
                    4 => 'Áo Polo', 5 => 'Áo Khoác', 6 => 'Áo Hoodies',
                ]
            ],
            1 => [
                0 => 'Quần',
                1 => [
                    1 => 'Quần Short', 2 => 'Quần Kaki', 3 => 'Quần Jogger',
                    4 => 'Quần Jeans', 5 => 'Quần Âu',
                ]
            ],
            2 => [
                0 => 'Phụ kiện thời trang',
                1 => [
                    1 => 'Balo - Túi Xách', 2 => 'Mắt Kính',
                    3 => 'Nón', 4 => 'Thắt Lưng',
                ]
            ],
            3 => 'Set quần áo',
            4 => 'Giày dép',
        ];
        for ($i = 0; $i < sizeof($categories); $i++) {
            if (is_array($categories[$i][1])) {
                Category::create([
                    'name' => $categories[$i][0],
                ]);
            } else {
                Category::create([
                    'name' => $categories[$i],
                ]);
            }
        }
        for ($i = 0; $i < sizeof($categories); $i++) {
            $arr_child = $categories[$i][1];
            if (isset($arr_child) && is_array($arr_child)) {
                foreach ($arr_child as $key => $value) {
                    Category::create([
                        'parent_id' => $i + 1,
                        'name' => $value,
                    ]);
                }
            }
        }
    }
}
