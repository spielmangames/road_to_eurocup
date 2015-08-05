#!/bin/bash

echo "Refreshing packages"
apt-get update > /tmp/vagrant_log 2>&1
apt-get upgrade > /tmp/vagrant_log 2>&1
echo "done"

echo "Setting Locale Settings"
export LANGUAGE="en_US.UTF-8"
echo 'LANGUAGE="en_US.UTF-8"' >> /etc/default/locale
echo 'LC_ALL="en_US.UTF-8"' >> /etc/default/locale

echo "Installing vim & mc and set as default editor"
apt-get install -y vim vim-doc vim-scripts mc >> /tmp/vagrant_log 2>&1
update-alternatives --set editor /usr/bin/mcedit >> /tmp/vagrant_log 2>&1
echo "done"

echo "Adding PPA"
add-apt-repository ppa:ondrej/php5-5.6 >> /tmp/vagrant_log 2>&1
apt-get update >> /tmp/vagrant_log 2>&1
apt-get install python-software-properties >> /tmp/vagrant_log 2>&1
apt-get update >> /tmp/vagrant_log 2>&1
echo "done"

echo "Installing Apache and PHP"
apt-get install -y php-apc php5 php5-cli php5-curl php5-mhash php5-gd php5-intl php5-mcrypt php5-gd php5-mysql php-pear php5-sqlite php5-dev php5-memcached php5-xdebug >> /tmp/vagrant_log 2>&1
echo "done"

echo "Configuring Apache and PHP"
a2dissite 000-default >> /tmp/vagrant_log 2>&1
cp /vagrant/dev/provision/eurocup.conf /etc/apache2/sites-available/eurocup.conf
a2ensite eurocup >> /tmp/vagrant_log 2>&1
a2enmod rewrite >> /tmp/vagrant_log 2>&1

php5enmod mcrypt >> /tmp/vagrant_log 2>&1

a2enmod ssl >> /tmp/vagrant_log 2>&1
mkdir /etc/apache2/ssl
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt -subj "/C=GB/ST=London/L=London/O=Global Security/OU=IT Department/CN=example.com" >> /tmp/vagrant_log 2>&1

cp /vagrant/dev/provision/php.ini /etc/php5/apache2/php.ini
cp /vagrant/dev/provision/php.ini /etc/php5/cli/php.ini
cp /vagrant/dev/provision/xdebug.ini /etc/php5/apache2/conf.d/20-xdebug.ini
sed -i 's/\(APACHE_RUN_USER=\)www-data/\1vagrant/g' /etc/apache2/envvars
chown vagrant:www-data /var/lock/apache2
service apache2 restart
echo "done"

echo "Installing MySQL server"
export DEBIAN_FRONTEND=noninteractive
apt-get -q -y install mysql-server-5.6 >> /tmp/vagrant_log 2>&1
echo "done"

echo "Installing Git"
apt-get install -y git-core >> /tmp/vagrant_log 2>&1
echo "done"

echo "Installing composer"
if [ ! -f "/usr/local/bin/composer" ];
then
    php -r "readfile('https://getcomposer.org/installer');" | php
    mv composer.phar /usr/local/bin/composer
fi

echo "done"

echo "Change SSH login dir"
echo "cd /vagrant" >> /home/vagrant/.bashrc
echo "done"

echo "Creating MySQL DB"
mysql -uroot -e "DROP DATABASE IF EXISTS symfony;"
mysql -uroot -e "CREATE DATABASE symfony;"
echo "done"

echo "Configuring Symfony"
cp /vagrant/app/config/parameters.yml.dist /vagrant/app/config/parameters.yml
echo "done"

echo "Composer update"
cd /vagrant
composer update >> /tmp/vagrant_log 2>&1
echo "done"
