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

        /*
        *飞书创建多维表格
        */
        'table_info' => [
            "name" => "bugList", // 数据表名
            "default_view_name" => "bugList", // 默认视图名
            "bug_status" => [
                [
                    "name"=>"激活",
                ],[
                    "name"=>"已解决",
                ],[
                    "name"=>"已关闭",
                ]
            ], // bug状态字段名
            "severity" => [
                [
                    "name"=>"严重",
                ],
                [
                    "name"=>"高",
                ],
                [
                    "name"=>"中",
                ],
                [
                    "name"=>"低",
                ],
                [
                    "name"=>"建议",
                ],
            ], // 严重程度
            "type" => [
                [
                    "name"=>"代码错误",
                ],[
                    "name"=>"配置相关",
                ],[
                    "name"=>"安装部署",
                ],[
                    "name"=>"安全相关",
                ],[
                    "name"=>"性能问题",
                ],[
                    "name"=>"标准规范",
                ],[
                    "name"=>"测试脚本",
                ],[
                    "name"=>"设计缺陷",
                ],[
                    "name"=>"其他",
                ],
            ], // bug类型
        ],
    ],
];
