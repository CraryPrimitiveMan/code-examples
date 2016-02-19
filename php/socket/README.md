## PHP socket
-------------
# 使用 accept 阻塞的古老模型：属于同步阻塞 IO 模型
`socket_server.php` 和 `socket_client.php`

# 使用 select/poll 的同步模型：属于同步非阻塞 IO 模型
`select_server.php` 和 `select_client.php`

# 使用 epoll/kqueue 的异步模型：属于异步阻塞/非阻塞 IO 模型
`epoll_server.php` 和 `epoll_client.php`
