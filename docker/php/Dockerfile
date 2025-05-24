# Use a specific PHP-FPM image with Alpine Linux for smaller size
FROM php:8.2-fpm

# Set the working directory inside the container
WORKDIR /var/www/html

# Install common PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    curl \
    ca-certificates \
    gnupg2 \
    lsb-release \
    supervisor \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    libicu-dev \               
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql intl  


# Install Node.js (v18 LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create laravel group with GID 1000 (matching host)
RUN addgroup --gid 1000 laravel \
    && adduser --uid 1000 --ingroup laravel --disabled-password --gecos "" laraveluser \
    && adduser www-data laravel \
    && chown -R laraveluser:laravel /var/www/html \
    && sed -i 's/^user = www-data/user = laraveluser/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^group = www-data/group = laravel/' /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/log/supervisor \
    && chown -R laraveluser:laravel /var/log/supervisor

# Set default user to laraveluser
# USER laraveluser

# Copy the custom entrypoint script into the container
# COPY --chmod=0755 entrypoint.sh /usr/local/bin/entrypoint.sh

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]