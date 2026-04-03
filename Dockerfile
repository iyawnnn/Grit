FROM php:8.4-apache

# Install system dependencies and Node.js for building assets
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libpq-dev \
    libicu-dev \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql intl opcache \
    # Clean up apt cache to reduce image size
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Optimize OPcache for a 512MB server
# Reduced memory_consumption to 64MB to leave room for active PHP processes
RUN echo "opcache.memory_consumption=64" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache-recommended.ini

# Prevent a single heavy request from crashing the container
RUN echo "memory_limit=128M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Limit Apache workers. This is the most important fix for the 512MB limit.
# It restricts Apache to a maximum of 4 concurrent child processes.
RUN echo "<IfModule mpm_prefork_module>\n\
    StartServers             1\n\
    MinSpareServers          1\n\
    MaxSpareServers          2\n\
    MaxRequestWorkers        4\n\
    MaxConnectionsPerChild   100\n\
</IfModule>" > /etc/apache2/mods-available/mpm_prefork.conf

WORKDIR /var/www/html

COPY . .

# Install PHP dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies, build assets, and delete node_modules to save RAM and disk space
RUN npm install
RUN npm run build
RUN rm -rf node_modules

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Update Apache to point to the public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

# Cache everything for maximum production speed, then start Apache
CMD php artisan config:cache && \
    php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    apache2-foreground