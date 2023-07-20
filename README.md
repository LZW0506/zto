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
