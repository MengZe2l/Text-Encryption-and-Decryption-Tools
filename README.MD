# TextAes
这是一个使用PHP+composer编写的数据加解密工具，使用 AES-256 算法进行加密和解密。前端页面使用bootstrap。

## 本地调试/无root服务器搭建方法

先克隆本仓库，使用如下指令开启PHP预览服务：

```Shell
php -S localhost:8000 -t public
```

## Nginx搭建方法一

在你使用的面板上，新建一个站点，把仓库克隆在站点目录，把运行目录设置成public，然后常规操作就行了

## Nginx代理搭建方法二

如果你没有面板，可以看着(这是基础模板，需要你自己更改)，克隆本仓库到一个目录，要记住这个目录。找到Nginx配置文件，添加如下Server模块：

```Nginx
server {
    listen 443 ssl;  # 监听443端口，启用SSL
    server_name example.com;  # 替换为你的网站域名

    root 仓库克隆目录/public;
    index index.php index.html index.htm;

    ssl_certificate /etc/ssl/certs/cert.crt;  # SSL 证书文件路径
    ssl_certificate_key /etc/ssl/private/key.key;  # SSL 证书私钥文件路径
    ssl_protocols TLSv1.2 TLSv1.3;  # 支持的 SSL/TLS 协议
    ssl_ciphers HIGH:!aNULL:!MD5;  # SSL 加密套件

    # 根目录请求处理
    location / {
        try_files $uri $uri/ /index.php?$query_string;  # 尝试文件存在，如果不存在则交给 index.php 处理
    }

    # 处理 PHP 文件
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;  # 包含 FastCGI 配置
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;  # PHP-FPM 的套接字路径，可能需要根据实际情况修改
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  # 设置脚本文件名参数
        include fastcgi_params;  # 包含 FastCGI 参数
    }

    # 禁止访问 .ht 文件（通常是 Apache 配置文件）
    location ~ /\.ht {
        deny all;  # 拒绝所有对 .ht 文件的访问
    }

    # 可选：添加日志文件用于调试
    access_log /var/log/nginx/your-site_access.log;  # 访问日志路径
    error_log /var/log/nginx/your-site_error.log;  # 错误日志路径
}

# 可选：重定向 HTTP 到 HTTPS
server {
    listen 80;  # 监听80端口
    server_name example.com;  # 替换为你的网站域名

    return 301 https://$host$request_uri;  # 重定向所有HTTP请求到HTTPS
}
```