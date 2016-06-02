#!/bin/bash
# Install openresty

source_path=$(pwd)
software_name=openresty
install_path=/opt/${software_name}
bin_path=/opt/bin
file_name=${source_path}/openresty-1.9.7.4.tar.gz

# parpear in ubuntu
sudo apt-get install -y libreadline-dev libncurses5-dev libpcre3-dev libssl-dev perl make build-essential

# get openresty package
if [ ! -f $file_name ]; then 
  wget https://openresty.org/download/openresty-1.9.7.4.tar.gz
fi

# install the openresty
tar xvf $file_name
cd ${source_path}/openresty-1.9.7.4/
./configure --prefix=$install_path --with-luajit
make
make install

# clear
rm -rf ${source_path}/openresty-1.9.7.4/

# 
ln -s ${install_path}/nginx/sbin/nginx ${bin_path}/nginx

# copy openresty config file
mkdir -p ${install_path}/nginx/conf/conf.d
cp ${source_path}/conf/fastcgi_params ${source_path}/conf/nginx.conf ${install_path}/nginx/conf/
#cp ${source_path}/conf/wm.conf /opt/openresty/nginx/conf/conf.d/