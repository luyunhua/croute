#php路由转发类库 支持composer加载

##install

###1.添加以下内容至project目录composer.json
添加仓库

```
"repositories": {
    "packagist": {
      "type": "composer",
      "url": "https://packagist.phpcomposer.com"
    },
    "croute": {
      "type": "vcs",
      "url": "git@github.com:luyunhua/croute.git"
    }
  }
```

添加依赖

```
  "require": {
    "php": ">=5.5.9",
    "luyunhua/croute": "dev-master"
  }

```

###2.更新依赖
`composer update`

##using

###此处假设大家的php项目支持自动加载,这样你在使用路由分发器的时候将无需在include类库等源文件等操作


###nginx 配置

####配置server

```
server {
    listen       82;
    #listen       somename:8080;
    server_name  _;
    index index.php;
    try_files $uri
              $uri/
              @rewrite;

    location @rewrite {
        rewrite ^(.*)$ /index.php?_url=$1;
    }

    location ~ \.php$ {
        root /var/wwwroot/mframe;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }


     error_page   500 502 503 504  /50x.html;
     location = /50x.html {
        root   /usr/share/nginx/html;
     }
}
```

###nginx 将php请求转发至82端口处理

```
    location ~ \.php$ {
        proxy_pass   http://127.0.0.1:82;
    }
```

###核心代码演示

```
<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/5/30
 * Time: 下午1:42
 * File: index.php
 */
include __DIR__ . '/boots/autoload.php';

$fileRoute = new \Tomato\Route\FileRoute();
$fileRoute->get('/myroute/abc/\d+' ,'App\Ctrl\DefaultController@index');
$fileRoute->post('/myroute/post/\w+/d' ,'App\Ctrl\DefaultController@index2');

$dispatcher = new \Tomato\Route\Dispatcher($fileRoute);
$dispatcher->run();

```






  
