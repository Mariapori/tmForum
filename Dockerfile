FROM nimmis/apache-php5
RUN echo "AddDefaultCharset UTF-8" >> /etc/apache2/apache2.conf

ADD ./src /var/www/html/

