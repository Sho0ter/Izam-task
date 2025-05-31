#!/bin/bash
set -e

# Get the current user and group
USER=www-data
GROUP=www-data

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! nc -z mysql 3306; do
    sleep 1
done
echo "MySQL is up - continuing with application setup..."

# Set directory permissions
echo "Setting up Laravel permissions..."

# Create necessary directories if they don't exist
for dir in \
    /var/www/storage/framework/views \
    /var/www/storage/framework/cache/data \
    /var/www/storage/framework/sessions \
    /var/www/storage/logs \
    /var/www/bootstrap/cache
    do
        mkdir -p "$dir"
done

# Set ownership
chown -R $USER:$GROUP /var/www

# Set directory permissions
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
chmod -R 777 /var/www/storage/framework/cache/data \
    /var/www/storage/framework/sessions \
    /var/www/storage/framework/views || true

# Install dependencies
if [ ! -d "/var/www/vendor" ]; then
    echo "Installing Composer dependencies..."
    cd /var/www && composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate application key if not set
if [ -z "$(grep '^APP_KEY=base64:' /var/www/.env)" ]; then
    echo "Generating application key..."
    cd /var/www && php artisan key:generate
fi

# Run database migrations
echo "Running database migrations..."
cd /var/www && php artisan migrate --force && php artisan db:seed

# Clear caches
echo "Clearing caches..."
cd /var/www && php artisan config:clear
cd /var/www && php artisan cache:clear
cd /var/www && php artisan view:clear

# Set ownership again after all operations
chown -R $USER:$GROUP /var/www
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
