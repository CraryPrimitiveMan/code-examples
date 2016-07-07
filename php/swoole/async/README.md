```sh
php dns_lookup.php # 获取www.sina.com.cn的IP
```

+ [swoole_async_dns_lookup](http://wiki.swoole.com/wiki/page/186.html) -- 将域名解析为IP地址。调用此函数是非阻塞的，调用会立即返回。将向下执行后面的代码。

```sh
php write.php # 异步写data.txt文件
php writefile.php # 异步写data2.txt文件
```

+ [swoole_async_write](http://wiki.swoole.com/wiki/page/189.html) -- 异步写文件，与swoole_async_writefile不同，write是分段读写的。不需要一次性将要写的内容放到内存里，所以只占用少量内存。swoole_async_write通过传入的offset参数来确定写入的位置。当offset为-1时表示追加写入到文件的末尾
+ [swoole_async_writefile](http://wiki.swoole.com/wiki/page/185.html) -- 异步写文件，调用此函数后会立即返回。当写入完成时会自动回调指定的callback函数。最大可写入4M的文件，可以不指定回调函数。

```sh
php read.php # 异步读入data.txt文件
php readfile.php # 异步读入../server.php的内容，并异步写入test.copy文件
```

+ [swoole_async_read](http://wiki.swoole.com/wiki/page/188.html) -- 异步读文件，使用此函数读取文件是非阻塞的，当读操作完成时会自动回调指定的函数。
+ [swoole_async_readfile](http://wiki.swoole.com/wiki/page/184.html) -- 异步读取文件内容，此函数调用后会马上返回，当文件读取完毕时会回调制定的callback函数

以上的读写文件都只支持本地文件。
