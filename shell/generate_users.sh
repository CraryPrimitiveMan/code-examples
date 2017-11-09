#!/bin/bash
# vim /etc/sudoers
# %sudoer ALL=(ALL) ALL
# groupadd sudoer
# 批量添加用户，授予sudo权限，目录迁移至/data/home/username下，密码是username6666
for username in user1 user2 user3
do
    groupadd ${username}
    useradd -g ${username} -s /bin/bash ${username}
    echo ${username}6666 | passwd --stdin ${username}
    usermod -g sudoer ${username}
    #echo ${username}2017 | tee -a passwd.txt | passwd --stdin ${username} #记录密码到passwd.txt文件中
    uid=`id ${username} | awk '{print $1}' | awk -F '=' '{print $2}' | awk -F '(' '{print $1}'`
    path=/data/home/${username}
    mkdir -p ${path}
    chown ${username}:${username} ${path}
    ln -s ${path} /home/${username}
    usermod -d ${path} -u ${uid} ${username}
done