```sh
php ../server.php # 启动server
php sync.php # 启动同步的client
php async.php # 启动异步的client
```

+ [swoole_client](http://wiki.swoole.com/wiki/page/p-client.html) -- swoole_client提供了tcp/udp socket的客户端的封装代码，使用时仅需 new swoole_client即可。php-fpm/apache环境下只能使用同步客户端。异步客户端只能使用在cli命令行环境。
