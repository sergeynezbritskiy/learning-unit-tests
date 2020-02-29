#!/usr/bin/env bash

echo -e '\E[47;31m'"\033[1m UPGRADDE SYSTEM \033[0m"
sudo apt-get update --yes
sudo apt-get upgrade --yes

#change switch language shortcut
echo -e '\E[47;31m'"\033[1m SWITCH LANGUAGE SHORTCUT \033[0m"
gsettings set org.gnome.desktop.input-sources xkb-options "['grp:alt_shift_toggle']"

#install chrome
echo -e '\E[47;31m'"\033[1m INSTALL GOOGLE CHROME \033[0m"
cd /tmp
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt install -fy
sudo dpkg -i google-chrome-stable_current_amd64.deb

#install git
echo -e '\E[47;31m'"\033[1m INSTALL GIT \033[0m"
sudo apt install git --yes

#install skype
echo -e '\E[47;31m'"\033[1m INSTALL SKYPE \033[0m"
cd /tmp
wget https://go.skype.com/skypeforlinux-64.deb
sudo dpkg -i skypeforlinux-64.deb
sudo apt install -fy
sudo dpkg -i skypeforlinux-64.deb

#install yakuake
echo -e '\E[47;31m'"\033[1m INSTALL YAKUAKE \033[0m"
sudo apt install yakuake -y

#install mysql client
echo -e '\E[47;31m'"\033[1m INSTALL MYSQL CLIENT \033[0m"
sudo apt install mysql-client-5.7 --yes
echo -e '\E[47;31m'"\033[1m FINISH INSTALLATION \033[0m"

#install docker
echo -e '\E[47;31m'"\033[1m INSTALL DOCKER \033[0m"
cd /tmp
sudo apt update
sudo apt install apt-transport-https ca-certificates curl software-properties-common --yes
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
sudo apt update
sudo apt install docker-ce --yes

#configure docker
echo -e '\E[47;31m'"\033[1m CONFIGURE DOCKER \033[0m"
sudo systemctl enable docker
sudo systemctl start docker
sudo groupadd docker
sudo usermod -aG docker $USER
sudo  mkdir -p -m 0777 /var/www
mkdir /var/www/magento2 /var/www/nginx_conf /var/www/elasticsearch /var/www/elasticsearch /var/www/log 
wget http://conf.m-dev.info/devmagento2.conf -P /var/www/nginx_conf/
sudo docker rm -f php71 php72 php73 nginx mysql elasticsearch kibana rabbitmq
sudo docker network rm net
sudo docker network create net
uid=`id -u $USER`
guid=`id -g $USER`
echo $uid
echo $guid

#pull and run docker containers
echo -e '\E[47;31m'"\033[1m PULL AND RUN DOCKER CONTAINERS \033[0m"

sudo docker pull magecom/maria
sudo docker pull magecom/nginx
sudo docker pull magecom/php:dev71
sudo docker pull magecom/php:dev72
sudo docker pull magecom/php:dev73
sudo docker pull elasticsearch
sudo docker pull kibana
sudo docker pull rabbitmq

sudo docker run -dti --restart always --net net --name mysql			-p 3306:3306		-v /var/www/mysql/:/var/lib/mysql/ -e MARIADB_PASS="admin"  	        magecom/maria
sudo docker run -dti --restart always --net net --name php71 			-u apache  		-v /var/www/:/var/www/ 						        magecom/php:dev71
sudo docker run -dti --restart always --net net --name php72 			-u apache  		-v /var/www/:/var/www/ 						        magecom/php:dev72
sudo docker run -dti --restart always --net net --name php73 			-u apache  		-v /var/www/:/var/www/                                                  magecom/php:dev73
sudo docker run -dti --restart always --net net --name nginx                    -p80:80 -p443:443       -v /var/www/:/var/www/ -v /var/www/nginx_conf/:/etc/nginx/conf.d/       magecom/nginx
sudo docker run -dti --restart always --net net --name varnish 			-p80:80 -p443:443  										magecom/varnish
sudo docker run -dti --restart always --net net --name elasticsearch 		-p9201:9200 		-v /var/www/elasticsearch:/usr/share/elasticsearch/data 		elasticsearch
sudo docker run -dti --restart always --net net --name kibana	 		-p5601:5601 											kibana
sudo docker run -dti --restart always --net net --name rabbitmq 		-p15672:15672                                                                                   rabbitmq
sudo docker exec -ti rabbitmq rabbitmq-plugins enable rabbitmq_management

# Add UID GUID localuser to user apache in php-fpm
sudo docker exec -it -u root php71 usermod -u $uid apache
sudo docker exec -it -u root php71 groupmod -g $guid apache

sudo docker exec -it -u root php72 usermod -u $uid apache
sudo docker exec -it -u root php72 groupmod -g $guid apache

sudo docker exec -it -u root php73 usermod -u $uid apache
sudo docker exec -it -u root php73 groupmod -g $guid apache

sudo docker exec -it nginx usermod -u $uid nginx
sudo docker exec -it nginx groupmod -g $guid nginx

sudo docker restart php71 php72 php73 nginx
sudo chmod a+w /etc/hosts

#install phpstorm
echo -e '\E[47;31m'"\033[1m INSTALL PHPSTORM \033[0m"
cd /tmp
wget https://download.jetbrains.com/webide/PhpStorm-2019.3.3.tar.gz
sudo tar xfz PhpStorm-*.tar.gz -C /opt/
cd /opt/PhpStorm-*/bin
./phpstorm.sh

