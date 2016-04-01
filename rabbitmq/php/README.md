## Install
-------------

+ Install [RabbitMQ C library](https://github.com/alanxz/rabbitmq-c)
```sh
# Download the rabbitmq-c library
git clone git://github.com/alanxz/rabbitmq-c.git
cd rabbitmq-c
# Enable and update the codegen git submodule
git submodule init
git submodule update
# Configure, compile and install
autoreconf -i && ./configure && make && sudo make install
```
+ Install extension [PHP AMQP](https://github.com/pdezwart/php-amqp)

## Doc

[PHP AMQP doc](http://php.net/manual/pl/book.amqp.php)

## Code

[Tutorial one: "Hello World!"](http://www.rabbitmq.com/tutorial-one-php.html):

    php send.php
    php receive.php


[Tutorial two: Work Queues](http://www.rabbitmq.com/tutorial-two-php.html):

    php new_task.php "A very hard task which takes two seconds.."
    php worker.php


[Tutorial three: Publish/Subscribe](http://www.rabbitmq.com/tutorial-three-php.html)

    php receive_logs.php
    php emit_log.php "info: This is the log message"

[Tutorial four: Routing](http://www.rabbitmq.com/tutorial-four-php.html):

    php receive_logs_direct.php info
    php emit_log_direct.php info "The message"


[Tutorial five: Topics](http://www.rabbitmq.com/tutorial-five-php.html):

    php receive_logs_topic.php "*.rabbit"
    php emit_log_topic.php red.rabbit Hello

[Tutorial six: RPC](http://www.rabbitmq.com/tutorial-six-php.html):

    php rpc_server.php
    php rpc_client.php