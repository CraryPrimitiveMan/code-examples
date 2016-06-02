#!/bin/bash
# Install Redis

source_path=$(pwd)
file_name=${source_path}/redis-3.0.7.tar.gz

# get redis package
if [ ! -f $file_name ]; then 
  wget http://download.redis.io/releases/redis-3.0.7.tar.gz
fi

# install the redis
tar xvf $file_name
cd ${source_path}/redis-3.0.7
make
cd ${source_path}/redis-3.0.7/src
sudo make install
rm -rf ${source_path}/redis-3.0.7

