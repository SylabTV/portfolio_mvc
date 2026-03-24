FROM php:8.2-apache

# On installe le driver PostgreSQL pour que PHP puisse parler à Neon
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# On active le module rewrite d'Apache (utile pour ton router)
RUN a2enmod rewrite

# On copie tout ton code dans le dossier du serveur
COPY . /var/www/html/

# On s'assure que le serveur peut lire les fichiers
RUN chown -R www-data:www-data /var/www/html

# Port par défaut
EXPOSE 80