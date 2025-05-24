#!/bin/sh

# Set permissions for Laravel storage and bootstrap/cache directories
echo "Setting permissions for storage and bootstrap/cache..."
chown -R laraveluser:laravel /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
echo "Permissions set."

# Execute the main command passed to the container (e.g., php-fpm)
echo "Starting PHP-FPM..."
exec "$@"