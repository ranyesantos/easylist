FROM php:8.2-fpm-bookworm

# atualiza pacotes e instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql intl zip opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# instala o Composer

RUN apt-get install -y curl
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# define o diretório de trabalho
WORKDIR /var/www/html

# copia o código do projeto (se você já tiver o código na pasta atual)
COPY . .

# expoem a porta para o xdebug
EXPOSE 9000

CMD ["sh", "-c", "composer install && php-fpm"]
