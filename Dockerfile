# Use a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Habilitar módulos necessários do Apache
RUN a2enmod rewrite

# Instalar dependências do Laravel e utilitários
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    mariadb-client \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mysqli zip

# Configurar o servidor Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir a variável de ambiente para o Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Instala as dependências do projeto
RUN composer install --no-interaction --optimize-autoloader


RUN composer clear-cache

# Permissões para o Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
    
# Expor a porta do Apache
EXPOSE 80

# Iniciar o Apache
CMD ["apache2-foreground"]