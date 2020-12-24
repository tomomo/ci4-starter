FROM phpmyadmin/phpmyadmin:latest

RUN cp -p /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
 sed -i -E 's/^(;| )*date\.timezone( )*=.*$/date.timezone = Asia\/Tokyo/g' /usr/local/etc/php/php.ini && \
 sed -i -E 's/^(;| )*upload_max_filesize( )*=.*$/upload_max_filesize = 256M/g' /usr/local/etc/php/php.ini && \
 sed -i -E 's/^(;| )*memory_limit( )*=.*$/memory_limit = 256M/g' /usr/local/etc/php/php.ini && \
 sed -i -E 's/^(;| )*post_max_size( )*=.*$/post_max_size = 256M/g' /usr/local/etc/php/php.ini
