softwares=(
lantern
chromium
git
zeal

lua
nodejs
php

mongo
openresty
redis
)

path=$(pwd)
for name in ${softwares[@]}
do
  if [[ -d ${path}/${name} ]] && [[ -f ${path}/${name}/install.sh ]]; then
    # sudo chmod +x ${path}/${name}/install.sh
    cd ${path}/${name}/
    ./install.sh
  fi
done
