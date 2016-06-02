#!/bin/bash
# Install mongodb

source_path=$(pwd)
software_name=mongodb
install_path=/opt/${software_name}
file_name=${source_path}/mongodb-linux-x86_64-ubuntu1404-2.8.0-rc5.tgz

# get mongodb package
if [ ! -f $file_name ]; then 
  wget http://downloads.mongodb.org/linux/mongodb-linux-x86_64-ubuntu1404-2.8.0-rc5.tgz
fi

# install the mongodb
tar xvf $file_name
mv mongodb-linux-x86_64-ubuntu1404-2.8.0-rc5 $install_path

echo "
# config for mongodb
export PATH=\$PATH:${install_path}/bin
" >> ~/.bashrc

source ~/.bashrc