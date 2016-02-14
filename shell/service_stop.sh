#/bin/bash

sudo supervisorctl stop all

services=(supervisor nginx redis-server mongod mysql docker apache2 tomcat7 postfix sphinxsearch php5-fpm)
for name in ${services[@]}
do
    sudo service ${name} stop
done
