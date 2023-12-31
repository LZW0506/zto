<?php
// 将config中key=>value 转换成飞书需要的格式
function setConfig($config): array
{
    $arr = [];
    if(!empty($config) && is_array($config) && sizeof($config) > 0){
        foreach ($config as $value ){
            $arr[] = [
                "name" => $value
            ];
        }

    }
    return $arr;
}
// https://open.feishu.cn/document/server-docs/docs/bitable-v1/app-table/create
return  [
    'table' => [
        "name" => config('zto.feishu.table_info.name'),
        "default_view_name" => config('zto.feishu.table_info.default_view_name'),
        "fields" => [
            [
                "field_name" => "id",
                "type" => 2,
                "property"=>[
                    "formatter"=>"0"
                ]
            ],
            [
                "field_name" => "标题",
                "type" => 1,
            ],
            [
                "field_name" => "所属项目",
                "type" => 1,
            ],
            [
                "field_name" => "所属产品",
                "type" => 1,
            ],
            [
                "field_name" => "所属模块",
                "type" => 1,
            ],
            [
                "field_name" => "bug状态",
                "type" => 3,
                "property"=>[
                    "options"=>setConfig(config('zto.feishu.table_info.bug_status'))
                ]
            ],
            [
                "field_name" => "优先级",
                "type" => 3,
                "property"=>[
                    "options"=>setConfig(config('zto.feishu.table_info.pri'))
                ]
            ],
            [
                "field_name" => "严重程度",
                "type" => 3,
                "property"=>[
                    "options"=>setConfig(config('zto.feishu.table_info.severity'))
                ]
            ],
            [
                "field_name" => "类型",
                "type" => 3,
                "property"=>[
                    "options"=>setConfig(config('zto.feishu.table_info.type'))
                ]
            ],
            [
                "field_name" => "由谁创建",
                "type" => 1,
            ],[
                "field_name" => "创建时间",
                "type" => 5,
                "property"=>[
                    "date_formatter"=>	"yyyy/MM/dd HH:mm"
                ]
            ],[
                "field_name" => "当前指派",
                "type" => 1,
            ],[
                "field_name" => "指派时间",
                "type" => 5,
                "property"=>[
                    "date_formatter"=>	"yyyy/MM/dd HH:mm"
                ]
            ],[
                "field_name" => "由谁解决",
                "type" => 1,
            ],[
                "field_name" => "解决时间",
                "type" => 5,
                "property"=>[
                    "date_formatter"=>	"yyyy/MM/dd HH:mm"
                ]
            ],[
                "field_name" => "由谁关闭",
                "type" => 1,
            ],[
                "field_name" => "关闭时间",
                "type" => 5,
                "property"=>[
                    "date_formatter"=>	"yyyy/MM/dd HH:mm"
                ]
            ],
        ]
    ],
];
