#!/usr/bin/env bash
#yarn
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get install yarn

#php
apt-get install -y python-software-properties
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get install -y php7.2
apt-get install -y php7.2-mbstring
apt-get install -y php7.2-intl
apt-get install -y php7.2-curl
apt-get install -y php7.2-gd
apt-get install -y php7.2-json
apt-get install -y php7.2-mcrypt
apt-get install -y php7.2-mysql

#mysql
debconf-set-selections <<< 'mysql-server mysql-server/root_password password start123'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password start123'
apt-get update
apt-get install -y mysql-server

#apache
apt install -y apache2 libapache2-mod-php7.2

apt-get install -y nodejs
apt-get install -y npm


curl -Ss https://getcomposer.org/installer | php
mv composer.phar /usr/bin/composer

apt-get install -y git

rm /var/www/html/index.html

echo "<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #ServerName www.example.com


        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
        <Directory /var/www/>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

a2enmod rewrite
service apache2 restart