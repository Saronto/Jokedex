#On utilise l'image debian
FROM debian:stretch
ENV DEBIAN_FRONTEND noninteractive
ENV TERM xterm

#Installation des packages requis pour faire fonctionner le serveur apache
RUN apt-get update && apt-get install -y \
    apache2 php7.0 libapache2-mod-php7.0 \
    curl php7.0-curl \
    php7.0-mb php7.0-gd php7.0-json \
    php7.0-mysql mysql-client \
    nano vim ssmtp \
    php7.0-dom

#Installation des packages pour composer install
RUN apt-get update && apt-get install -y \
    zip unzip git

#On active le mode de réecriture d'URL d'apache
RUN a2enmod rewrite
#RUN a2enmod headers
#RUN a2enmod expires

#On utilise le même userID/groupID dans le container pour ne pas créer de conflit de droits
ARG LOCAL_USER_ID
ARG LOCAL_GROUP_ID
RUN groupadd groupUser --gid ${LOCAL_GROUP_ID}
RUN useradd user --uid ${LOCAL_USER_ID} --gid groupUser --shell /bin/bash --create-home
#On rajoute le user dans le groupe apache et inversement
RUN adduser www-data groupUser
RUN adduser user www-data

#On copie dans le container les fichiers de config obligatoire pour le serveur apache
COPY ./etc/php/php.ini /etc/php/7.0/apache2/conf.d/99-php.ini
RUN rm /etc/apache2/sites-enabled/*.conf
COPY ./etc/apache/virtualhost /etc/apache2/sites-enabled
RUN mkdir /var/log/apache/

#COPY ./etc/ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf

# Install Composer
WORKDIR /root
COPY ./bin/composer/composer-setup.php /root/composer-setup.php
RUN php composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]