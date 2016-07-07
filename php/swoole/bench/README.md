## QPS比较
| 语言 | 脚本 | QPS |
| --- | --- | --- |
| NodeJs | ab -c 1000 -n 1000000 -k | 10693.83 |
| NodeJs | ab -c 1000 -n 1000000 -k -p post.data | 9962.67 |
| NodeJs | ab -c 100 -n 100000 -k -p post.big.data | 9042.86 |
| Go | ab -c 1000 -n 1000000 -k | 129933.73 |
| Go | ab -c 1000 -n 1000000 -k -p post.data | 115210.53 |
| Go | ab -c 100 -n 100000 -k -p post.big.data | 97914.71 |
| Swoole | ab -c 1000 -n 1000000 -k | 193957.00 |
| Swoole | ab -c 1000 -n 1000000 -k -p post.data | 214339.07 |
| Swoole | ab -c 100 -n 100000 -k -p post.big.data | 47652.27 |

## NodeJS

执行如下压力测试命令
```sh
node http.js # 启动node
ab -c 1000 -n 1000000 -k http://127.0.0.1:8080/
ab -c 1000 -n 1000000 -k -p post.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:8080/
#post 24K
ab -c 100 -n 100000 -k -p post.big.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:8080/
```

结果如下：
```sh
Server Software:        node.js
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        20 bytes

Concurrency Level:      1000
Time taken for tests:   93.512 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    0
Total transferred:      112000000 bytes
HTML transferred:       20000000 bytes
Requests per second:    10693.83 [#/sec] (mean)
Time per request:       93.512 [ms] (mean)
Time per request:       0.094 [ms] (mean, across all concurrent requests)
Transfer rate:          1169.64 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0   68 341.2      0   15032
Processing:     8   25  26.1     23    1658
Waiting:        8   25  26.1     23    1658
Total:          9   93 347.9     23   15055

Percentage of the requests served within a certain time (ms)
  50%     23
  66%     24
  75%     27
  80%     27
  90%     31
  95%   1020
  98%   1025
  99%   1033
 100%  15055 (longest request)
```

```sh
Server Software:        node.js
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        20 bytes

Concurrency Level:      1000
Time taken for tests:   100.375 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    0
Total transferred:      112000000 bytes
Total body sent:        235000000
HTML transferred:       20000000 bytes
Requests per second:    9962.67 [#/sec] (mean)
Time per request:       100.375 [ms] (mean)
Time per request:       0.100 [ms] (mean, across all concurrent requests)
Transfer rate:          1089.67 [Kbytes/sec] received
                        2286.35 kb/s sent
                        3376.02 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0   72 385.3      0   15036
Processing:     4   27  20.6     25    1043
Waiting:        4   27  20.6     25    1043
Total:         14   99 389.8     25   15252

Percentage of the requests served within a certain time (ms)
  50%     25
  66%     27
  75%     29
  80%     29
  90%     34
  95%   1022
  98%   1027
  99%   1036
 100%  15252 (longest request)
```

```sh
Server Software:        node.js
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        20 bytes

Concurrency Level:      100
Time taken for tests:   11.058 seconds
Complete requests:      100000
Failed requests:        0
Keep-Alive requests:    0
Total transferred:      11200000 bytes
Total body sent:        2481900000
HTML transferred:       2000000 bytes
Requests per second:    9042.86 [#/sec] (mean)
Time per request:       11.058 [ms] (mean)
Time per request:       0.111 [ms] (mean, across all concurrent requests)
Transfer rate:          989.06 [Kbytes/sec] received
                        219174.44 kb/s sent
                        220163.50 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       1
Processing:     2   11   2.6     10      23
Waiting:        2   11   2.6     10      23
Total:          3   11   2.6     10      23

Percentage of the requests served within a certain time (ms)
  50%     10
  66%     11
  75%     11
  80%     11
  90%     11
  95%     19
  98%     20
  99%     21
 100%     23 (longest request)
```

## Go

执行如下压力测试命令
```sh
go build http.go # 编译go文件，生成http可执行文件
./http # 执行http文件
ab -c 1000 -n 1000000 -k http://127.0.0.1:8080/
ab -c 1000 -n 1000000 -k -p post.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:8080/
#post 24K
ab -c 100 -n 100000 -k -p post.big.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:8080/
```

结果如下：
```sh
Server Software:        golang-http-server
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      1000
Time taken for tests:   7.696 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    1000000
Total transferred:      280000000 bytes
HTML transferred:       24000000 bytes
Requests per second:    129933.73 [#/sec] (mean)
Time per request:       7.696 [ms] (mean)
Time per request:       0.008 [ms] (mean, across all concurrent requests)
Transfer rate:          35528.75 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0  13.3      0    1000
Processing:     0    8   3.4      7     216
Waiting:        0    7   3.4      7     216
Total:          0    8  14.5      7    1216

Percentage of the requests served within a certain time (ms)
  50%      7
  66%      7
  75%      7
  80%      8
  90%     12
  95%     15
  98%     17
  99%     18
 100%   1216 (longest request)
```

```sh
Server Software:        golang-http-server
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      1000
Time taken for tests:   8.680 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    1000000
Total transferred:      280000000 bytes
Total body sent:        235000000
HTML transferred:       24000000 bytes
Requests per second:    115210.53 [#/sec] (mean)
Time per request:       8.680 [ms] (mean)
Time per request:       0.009 [ms] (mean, across all concurrent requests)
Transfer rate:          31502.88 [Kbytes/sec] received
                        26439.92 kb/s sent
                        57942.80 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.3      0      13
Processing:     0    9   3.2      8      38
Waiting:        0    9   3.2      8      38
Total:          0    9   3.2      8      38

Percentage of the requests served within a certain time (ms)
  50%      8
  66%      8
  75%      9
  80%      9
  90%     14
  95%     16
  98%     17
  99%     19
 100%     38 (longest request)
```

```sh
Server Software:        golang-http-server
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      100
Time taken for tests:   1.021 seconds
Complete requests:      100000
Failed requests:        0
Keep-Alive requests:    100000
Total transferred:      28000000 bytes
Total body sent:        2481900000
HTML transferred:       2400000 bytes
Requests per second:    97914.71 [#/sec] (mean)
Time per request:       1.021 [ms] (mean)
Time per request:       0.010 [ms] (mean, across all concurrent requests)
Transfer rate:          26773.55 [Kbytes/sec] received
                        2373188.67 kb/s sent
                        2399962.22 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       1
Processing:     0    1   0.6      1       7
Waiting:        0    1   0.6      1       7
Total:          0    1   0.6      1       7

Percentage of the requests served within a certain time (ms)
  50%      1
  66%      1
  75%      1
  80%      1
  90%      2
  95%      2
  98%      3
  99%      3
 100%      7 (longest request)
```

## Swoole

执行如下压力测试命令
```sh
php http.php # 执行http.php文件
ab -c 1000 -n 1000000 -k http://127.0.0.1:9501/
ab -c 1000 -n 1000000 -k -p post.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:9501/
#post 24K
ab -c 100 -n 100000 -k -p post.big.data -T 'application/x-www-form-urlencoded' http://127.0.0.1:9501/
```

结果如下：
```sh
Server Software:        swoole-http-server
Server Hostname:        127.0.0.1
Server Port:            9501

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      1000
Time taken for tests:   5.156 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    1000000
Total transferred:      265000000 bytes
HTML transferred:       24000000 bytes
Requests per second:    193957.00 [#/sec] (mean)
Time per request:       5.156 [ms] (mean)
Time per request:       0.005 [ms] (mean, across all concurrent requests)
Transfer rate:          50193.95 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.4      0      17
Processing:     0    5   4.4      3      81
Waiting:        0    5   4.4      3      81
Total:          0    5   4.6      3      92

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      6
  75%      6
  80%      7
  90%     12
  95%     13
  98%     13
  99%     13
 100%     92 (longest request)
```

```sh
Server Software:        swoole-http-server
Server Hostname:        127.0.0.1
Server Port:            9501

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      1000
Time taken for tests:   4.666 seconds
Complete requests:      1000000
Failed requests:        0
Keep-Alive requests:    1000000
Total transferred:      265000000 bytes
Total body sent:        235000000
HTML transferred:       24000000 bytes
Requests per second:    214339.07 [#/sec] (mean)
Time per request:       4.666 [ms] (mean)
Time per request:       0.005 [ms] (mean, across all concurrent requests)
Transfer rate:          55468.61 [Kbytes/sec] received
                        49189.14 kb/s sent
                        104657.75 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.4      0      16
Processing:     0    5   6.2      1      37
Waiting:        0    5   6.2      1      37
Total:          0    5   6.3      1      44

Percentage of the requests served within a certain time (ms)
  50%      1
  66%      1
  75%     13
  80%     13
  90%     13
  95%     13
  98%     14
  99%     15
 100%     44 (longest request)
```

```sh
Server Software:        swoole-http-server
Server Hostname:        127.0.0.1
Server Port:            9501

Document Path:          /
Document Length:        24 bytes

Concurrency Level:      100
Time taken for tests:   2.099 seconds
Complete requests:      100000
Failed requests:        0
Keep-Alive requests:    100000
Total transferred:      26500000 bytes
Total body sent:        2481900000
HTML transferred:       2400000 bytes
Requests per second:    47652.27 [#/sec] (mean)
Time per request:       2.099 [ms] (mean)
Time per request:       0.021 [ms] (mean, across all concurrent requests)
Transfer rate:          12331.89 [Kbytes/sec] received
                        1154962.54 kb/s sent
                        1167294.43 kb/s total

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       2
Processing:     0    2   2.5      0      12
Waiting:        0    2   2.5      0      12
Total:          0    2   2.5      0      12

Percentage of the requests served within a certain time (ms)
  50%      0
  66%      5
  75%      6
  80%      6
  90%      6
  95%      6
  98%      6
  99%      6
 100%     12 (longest request)
```
