<?php

// https://open.feishu.cn/document/server-docs/docs/bitable-v1/app-table/create
return  [
    'table' => [
        "name" => 'bugList',
        "default_view_name" => 'bugList',
        "fields" => [
            [
                "field_name" => "id",
                "type" => 2,
            ],
            [
                "field_name" => "标题",
                "type" => 1,
            ],
            [
                "field_name" => "bug状态",
                "type" => 3,
                "property"=>[
                    "options"=>[
                        [
//                            "id"=>'active',
                            "name"=>"激活",
                        ],[
//                            "id"=>'resolved',
                            "name"=>"已解决",
                        ],[
//                            "id"=>'closed',
                            "name"=>"已关闭",
                        ]
                    ]
                ]
            ],
            [
                "field_name" => "严重程度",
                "type" => 3,
                "property"=>[
                    "options"=>[
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
                    ]
                ]
            ],
            [
                "field_name" => "类型",
                "type" => 3,
                "property"=>[
                    "options"=>[
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
                    ]
                ]
            ],
            [
                "field_name" => "由谁创建",
                "type" => 1,
            ],[
                "field_name" => "创建时间",
                "type" => 5,
            ],[
                "field_name" => "当前指派",
                "type" => 1,
            ],[
                "field_name" => "指派时间",
                "type" => 5,
            ],[
                "field_name" => "由谁解决",
                "type" => 1,
            ],[
                "field_name" => "解决时间",
                "type" => 5,
            ],[
                "field_name" => "由谁关闭",
                "type" => 1,
            ],[
                "field_name" => "关闭时间",
                "type" => 5,
            ],
        ]
    ],
];
