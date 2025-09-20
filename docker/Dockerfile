# Use a imagem base do PHP com o Apache
FROM php:8.1-fpm

# Atualiza o sistema e instala as dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    vim \
    libicu-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Garante o functionamento do PDO com MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Ajusta permissões se necessário
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/
    
# Copia os arquivos do projeto para o diretório de trabalho
WORKDIR /var/www