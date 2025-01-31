FROM php:8.3-apache


RUN apt-get update && \
    apt-get install -y libpq-dev tree mc && \
    docker-php-ext-install pdo pdo_pgsql

    
COPY ./public /var/www/html/public/
COPY ./bin/php /var/www/html/bin/php/
COPY ./bin/js /var/www/html/bin/js/

# или

# COPY . /var/www/html/
# тогда 
COPY ./ext/000-deafult.conf /etc/apache2/sites-available/000-default.conf

# Копируем файл .env.example в .env, если он не существует
RUN if [ ! -f /var/www/html/.env ]; then \
      cp /var/www/html/.env.example /var/www/html/.env; \
    fi

# или так, если понадобится раслирить установочные инструкции
# создав отдельный скрипт
# COPY entrypoint.sh /usr/local/bin/entrypoint.sh
# RUN chmod +x /usr/local/bin/entrypoint.sh

# ENTRYPOINT ["entrypoint.sh"]
# CMD ["apache2-foreground"]
    

#RUN a2enmod rewrite
    
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80


