# lzw/zto


```bash

// 安装
composer require lzw/zto

// 发布
php artisan vendor:publish --provider="Lzw\ZentaoToOther\ZentaoToOtherProvider"

```

#### 禅道api
```php

$zto = new ZentaoToOther();
$zto->zentaoSdk()->get('departments'); //Http::post/get

```
#### 飞书api
```php

$zto = new ZentaoToOther();
$app_token = config('zto.feishu.app_token');
$table_id = $zto->feishuSdk()->getDataTableId(); // 数据表id
$zto->feishuSdk()->post("open-apis/bitable/v1/apps/{$app_token}/tables/{$table_id}/records"); //Http::post/get/put

```
#### 创建飞书数据表
```php

$zto = new ZentaoToOther();
$zto->createFeishuTable();
// 返回的数据表id 默认存入缓存中，需手动填写入env或config中以防数据丢失
```

#### 禅道hook
```php

Route::post('/hook', function (Request $request) {
    $zto = new ZentaoToOther();
    Log::info($request->all());
    $zto->zentaoHook($request->all());
    return 'success';
});

```
