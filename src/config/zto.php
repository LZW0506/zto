<?php


return [


    /*
    *禅道地址
    */
    'url' => env('ZENTAO_URL', 'localhost:80'),


    /*
    *登录账号
    */
    'account' => env('ZENTAO_ACCOUNT', ''),


    /*
    *登录密码
    */
    'password' => env('ZENTAO_PASS', ''),


    'feishu'=>[

        /*
        *飞书多应用app_id
        */
        'app_id' => env('FEISHU_APP_ID', ''),

        /*
        *飞书多应用app_secret
        */
        'app_secret' => env('FEISHU_APP_SECRET', ''),

        /*
        *飞书多维表格app_token
        */
        'app_token' => env('FEISHU_APP_TOKEN', ''),

        /*
        *飞书多维表格table_id
        */
        'table_id' => env('FEISHU_TABLE_ID', ''),

        /*
        *飞书多维表格 数据表id
        */
        'data_table_id' => env('FEISHU_DATA_TABLE_ID', ''),
    ],
];
