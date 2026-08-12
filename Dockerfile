# --------------------------------------------------------------------------
# Dockerfile = "recette" pour construire une image contenant tout ce dont
# l'application a besoin pour tourner, de façon identique sur n'importe
# quelle machine (poste du dev, serveur, cloud...). C'est la base du "Dev"
# dans DevOps : on élimine le "ça marche chez moi mais pas ailleurs".
# --------------------------------------------------------------------------

# On part d'une image officielle légère avec PHP 8.3 déjà installé
FROM php:8.3-fpm-alpine

# Métadonnée : bonne pratique pour tracer qui maintient l'image
LABEL maintainer="Henry"

# Répertoire de travail à l'intérieur du conteneur
WORKDIR /var/www/html

# Installation des dépendances système nécessaires à Laravel
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    mysql-client

# Installation des extensions PHP requises par Laravel + MySQL
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Installation de Composer (gestionnaire de dépendances PHP)
# --from=... copie juste le binaire depuis l'image officielle Composer,
# sans avoir à réinstaller un environnement complet (image plus légère).
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# On copie le code de l'application dans le conteneur
COPY . .

# Installation des dépendances PHP en mode "production"
# --no-dev : on n'installe pas les outils de développement (image plus légère et plus sûre)
# --optimize-autoloader : améliore les performances de chargement des classes
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Bonnes pratiques de sécurité (DevSecOps) :
# on donne les droits au bon utilisateur plutôt que de tourner en root
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel \
    && chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache
USER laravel

# Port sur lequel PHP-FPM écoute
EXPOSE 9000

CMD ["php-fpm"]
