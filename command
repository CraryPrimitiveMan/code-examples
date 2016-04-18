rsync -av /var/www/aug-marketing/src/modules/demo/ root@192.168.161.237:/srv/cp_stage/src/modules/demo

# 修正ubuntu依赖错误
sudo rm -rf /var/lib/dpkg/info/php5-memcache.prerm
