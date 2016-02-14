#/bin/bash

serviceName=$1
if [ "$serviceName" = "" ]; then
    services=(supervisor nginx redis-server mongod mysql docker apache2 tomcat7 postfix sphinxsearch php5-fpm)
    for name in ${services[@]}
    do
        sudo service ${name} start
    done
    sudo supervisorctl start all
else
    sudo service ${serviceName} start
fi
