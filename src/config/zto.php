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


    'feishu' => [

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
        *飞书创建多维表格
        */
        'table_info' => [
            "name" => "bugList", // 数据表名
            "default_view_name" => "bugList", // 默认视图名

            /*
             *  优先级
             */
            "pri" => [
                1 => "1",
                2 => "2",
                3 => "3",
                4 => "4",
            ],

            /*
             *  bug状态
             */
            "bug_status" => [
                "active" => "激活",
                "resolved" => "已解决",
                "closed" => "已关闭",
            ],

            /*
             *  严重程度
             */
            "severity" =>  [
                1 => "1",
                2 => "2",
                3 => "3",
                4 => "4",
            ],
            /*
             *  bug类型
             */
            "type" => [
                "codeerror" => "代码错误",
                "config" => "配置相关",
                "install" => "安装部署",
                "security" => "安全相关",
                "performance" => "性能问题",
                "standard" => "标准规范",
                "automation" => "测试脚本",
                "designdefect" => "设计缺陷",
                "others" => "其他",
            ],
        ],
    ],
];
