FROM php:8.2-apache

# 1. On installe les outils pour que PHP puisse parler à ta DB et installer Composer
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# 2. On télécharge Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. On se met dans le bon dossier
WORKDIR /var/www/html

# 4. On copie tout ton projet (index.php, composer.json, etc.)
COPY . .

# 5. C'EST ÇA QUI VA CRÉER TON DOSSIER VENDOR
RUN composer install --no-interaction --optimize-autoloader

# 6. On dit à Apache d'écouter sur le port de Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 7. Droits d'accès
RUN chown -R www-data:www-data /var/www/html