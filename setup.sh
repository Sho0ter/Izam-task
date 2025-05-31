#!/bin/bash

# Set ownership of Laravel directories
echo "Setting up Laravel permissions..."

# Change to the web root directory
cd /var/www

# Set directory ownership
chown -R www-data:www-data /var/www

# Set directory permissions
find /var/www -type d -exec chmod 755 {} \;
find /var/www -type f -exec chmod 644 {} \;

# Set storage and bootstrap/cache permissions
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Set ownership of storage and bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Install Composer dependencies
echo "Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key if not set
if [ ! -f /var/www/.env.production ]; then
    cp /var/www/.env /var/www/.env.production
    php /var/www/artisan key:generate --force
fi

# Cache configuration
php /var/www/artisan config:clear
php /var/www/artisan config:cache
php /var/www/artisan route:cache
php /var/www/artisan view:cache
php /var/www/artisan queue:table
php /var/www/artisan migrate

# Set storage link
php /var/www/artisan storage:link

echo "Setup complete!"
