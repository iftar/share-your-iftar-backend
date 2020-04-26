sudo apt-get update -y
sudo apt-get upgrade -y
sudo apt-get install nginx -y

sudo apt install composer -y

curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
sudo apt-get install nodejs -y
sudo apt-get install npm -y
sudo apt update
sudo apt upgrade -y

#sudo cp ./nginx /etc/nginx/site-available/default

sudo mkdir /var/www/shareiftar.org
sudo chown ubuntu:www-data -R /var/www/shareiftar.org

sudo mkdir ~/.composer
sudo mkdir ~/.composer/cache
sudo chown -R $USER:$USER /home/ubuntu/.composer/
sudo chmod -R 775 /home/ubuntu/.composer/cache/

sudo mkdir /var/www/shareiftar.org/storage
sudo mkdir /var/www/shareiftar.org/storage/framework
sudo mkdir /var/www/shareiftar.org/storage/framework/cache
sudo mkdir /var/www/shareiftar.org/storage/framework/cache/data
sudo chown ubuntu:www-data -R /var/www/shareiftar.org/storage
sudo chmod -R 775 /var/www/shareiftar.org/storage

#sudo add-apt-repository ppa:ondrej/php
#sudo apt update
#sudo apt upgrade -y
dpkg -l | grep php | tee packages.txt
sudo apt install php7.2 php7.2-common php7.2-cli php7.2-fpm php7.2-xml php7.2-mbstring php7.2-curl php7.2-pgsql php7.2-json php-json-schema php-cli-prompt php7.2-common php-composer-semver php-composer-semver php-composer-spdx-licenses php-symfony-console php-symfony-filesystem php-symfony-finder php-symfony-process -y
sudo apt install zip unzip php7.2-zip -y 
sudo apt install php-bcmath -y
sudo apt install php-gd -y
