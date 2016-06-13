#!/bin/bash
# Install php56

source_path=$(pwd)

sudo apt-get install -y php5-cgi php5-fpm php5-curl php5-gd php5-mysql php5-mcrypt php5-memcache php5-memcached php5-dev php5-xdebug

tar xzf ${source_path}/mongo-1.6.13.tgz
cd ${source_path}/mongo-1.6.13
phpize
./configure
make
sudo make install

tar xzf ${source_path}/redis-2.2.7.tgz
cd ${source_path}/redis-2.2.7/redis-2.2.7
phpize
./configure
make
sudo make install

# clear
#rm -rf ${source_path}/mongo-1.6.13/ ${source_path}/redis-2.2.7

# copy php config file
# cp ${source_path}/conf/php.ini ${source_path}/conf/php-fpm.conf /etc/php5/fpm/

echo "; configuration for php Mongo module
extension=mongo.so
" | sudo tee /etc/php5/mods-available/mongo.ini

echo "; configuration for php Redis module
extension=redis.so
" | sudo tee /etc/php5/mods-available/redis.ini

echo "; configuration for php xdebug module
zend_extension=/usr/lib/php5/20121212/xdebug.so
xdebug.remote_enable=1
xdebug.remote_host=127.0.0.1
xdebug.remote_connect_back=1
xdebug.remote_port=9999
xdebug.remote_handler=dbgp
xdebug.remote_mode=req
xdebug.remote_autostart=true
" | sudo tee /etc/php5/mods-available/xdebug.ini

sudo php5enmod mongo redis xdebug
sudo service php5-fpm restart
