#!/bin/bash
# Install php56

source_path=$(pwd)
software_name=php56
install_path=/opt/${software_name}
bin_path=/opt/bin
file_name=${source_path}/php-5.6.19.tar.bz2
echo $file_name
# get php56 package
if [ ! -f $file_name ]; then
  wget http://cn2.php.net/distributions/php-5.6.19.tar.bz2
fi

# install the php56
tar xvf $file_name
cd ${source_path}/php-5.6.19/
./configure \
--prefix=${install_path} \
--with-config-file-path=${install_path}/etc \
--enable-inline-optimization \
--disable-debug \
--disable-rpath \
--enable-shared \
--enable-opcache \
--enable-fpm \
--with-fpm-user=www \
--with-fpm-group=www \
--with-mysql=mysqlnd \
--with-mysqli=mysqlnd \
--with-pdo-mysql=mysqlnd \
--with-gettext \
--enable-mbstring \
--with-iconv \
--with-mcrypt \
--with-mhash \
--with-openssl \
--enable-bcmath \
--enable-soap \
--with-libxml-dir \
--enable-pcntl \
--enable-shmop \
--enable-sysvmsg \
--enable-sysvsem \
--enable-sysvshm \
--enable-sockets \
--with-curl \
--with-zlib \
--enable-zip \
--with-bz2 \
--with-readline \
--enable-phpdbg
make -j8
make install
make install-phpdbg

tar xzf ${source_path}/mongo-1.6.13.tgz
cd ${source_path}/mongo-1.6.13
phpize
./configure
make
make install

tar xzf ${source_path}/redis-2.2.7.tgz
cd ${source_path}/redis-2.2.7
phpize
./configure
make
make install

echo "
# config for php
export PATH=\$PATH:${install_path}/bin
" >> ~/.bashrc

source ~/.bashrc

# clear
rm -rf ${source_path}/php-5.6.19/ ${source_path}/mongo-1.6.13/ ${source_path}/redis-2.2.7

# copy php config file
cp ${source_path}/conf/php.ini ${source_path}/conf/php-fpm.conf ${install_path}/etc/
