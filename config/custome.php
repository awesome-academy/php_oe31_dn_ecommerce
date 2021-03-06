<?php

return [
    'count_item_1' => 1,
    'number_pro_related' => 8,
    'paginate_pro' => 12,
    'paginate_history_order' => 10,
    'unit_vnd' => 'đ',
    'cf_function_sp' => [
        'convert_vnd' => [
            'counter' => 3,
            'start_jump' => 3,
            'loop_codition' => 0,
            'start_sub' => 0,
            'start_sub_codition' => 0,
            'length_sub' => 3,
            'length_sub_codition' => 1,
        ],
    ],
    'link_banner' => 'storage/images/banners/',
    'link_img_product' => 'storage/images/products/',
    'link_img_suggest' => 'storage/images/suggests/',
    'count_category' => 0,
    'count_item' => 0,
    'filter_by' => [
        'price_ascending' => 'price_ascending',
        'price_descending' => 'price_descending',
        'name_a_z' => 'name_a_z',
        'name_z_a' => 'name_z_a',
        'oldest' => 'oldest',
        'newest' => 'newest',
    ],
    'star_number_1' => 1,
    'star_number_2' => 2,
    'star_number_3' => 3,
    'star_number_4' => 4,
    'star_number_5' => 5,
    'path_storage_suggest' => 'app/public/images/suggests/',
    'path_storage_product' => 'app/public/images/products/',
    'months' => [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12'
    ],
    'email_support' => 'support_team@gmail.com',
    'cron_job_send_order' => '0 16 * * 4', //every 16h-friday
];
