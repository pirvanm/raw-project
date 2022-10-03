FROM php:fpm

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt-get update && apt-get -y install cron

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install vim -y

    
WORKDIR /var/www
COPY . .

# putting our test PHP script somewhere in the filesystem

RUN chmod 0777 test_cron.php

# creating the log file that will be written to at each cron iteration
RUN touch test_cron.log

RUN chmod 0777 test_cron.log

# copy the crontab in a location where it will be parsed by the system
COPY ./cronj /etc/cron.d/cronj
# owner can read and write into the crontab, group and others can read it
RUN chmod 0644 /etc/cron.d/cronj
# running our crontab using the binary from the package we installed
RUN /usr/bin/crontab /etc/cron.d/cronj