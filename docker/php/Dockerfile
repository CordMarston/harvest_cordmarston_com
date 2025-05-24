# Use a specific PHP-FPM image with Alpine Linux for smaller size
FROM php:8.2-fpm-alpine

# Set the working directory inside the container
WORKDIR /var/www/html

# Install common PHP extensions required by Laravel
RUN apk add --no-cache \
    nginx \
    mysql-client \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    freetype-dev \
    icu-dev \
    git \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    supervisor \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    xml \
    mbstring \
    gd \
    zip \
    bcmath \
    fileinfo \
    intl \
    opcache \
    pcntl \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create laravel group with GID 1000 (matching host)
RUN addgroup -g 1000 laravel \
    # Create laraveluser with UID 1000 in the laravel group
    && adduser -D -u 1000 -G laravel laraveluser \
    # Add www-data to the laravel group
    && adduser www-data laravel \
    # Give ownership of the work directory to laraveluser and group
    && chown -R laraveluser:laravel /var/www/html \
    # Override PHP-FPM user and group to laraveluser and laravel
    && sed -i 's/^user = www-data/user = laraveluser/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^group = www-data/group = laravel/' /usr/local/etc/php-fpm.d/www.conf

# Set default user to laraveluser
USER laraveluser

# Copy the custom entrypoint script into the container
COPY --chmod=0755 entrypoint.sh /usr/local/bin/entrypoint.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]