FROM php:8.2-apache

# 1. Installation des outils système nécessaires (Zip et Postgres)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# 2. On installe Composer officiellement
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. On définit le dossier de travail
WORKDIR /var/www/html

# 4. On copie TOUT ton projet dans le conteneur
COPY . .

# 5. ON LANCE L'INSTALLATION (C'est l'étape qui te manque)
RUN composer install --no-interaction --optimize-autoloader

# 6. On donne les bons droits pour Apache
RUN chown -R www-data:www-data /var/www/html

# 7. On expose le port (Render utilise 80 par défaut en Apache)
EXPOSE 80