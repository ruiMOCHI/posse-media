FROM php:8.1.17-fpm-alpine3.17
COPY php.ini /usr/local/etc/php/

# 必要なパッケージをインストール
RUN apk add --no-cache \
  libzip-dev \
  zlib-dev \
  mariadb-client \
  unzip \
  curl \
  vim \
  && docker-php-ext-install zip pdo_mysql sockets \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
  && composer self-update --2 \
  && echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc

# PHPの設定ファイルをコピー
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# ワーキングディレクトリを設定
WORKDIR /work/web

# 過去のやつ、なんまこれのせいでエラー出してた
# FROM php:8.1.17-fpm-alpine3.17
# COPY php.ini /usr/local/etc/php/

# # 必要なパッケージをインストール
# RUN apk add --no-cache \
#   libzip-dev \
#   zlib-dev \
#   mariadb-client \
#   unzip \
#   curl \
#   vim \
#   && docker-php-ext-install zip pdo_mysql sockets \
#   && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
#   && composer self-update --2 \
#   && echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc

# # PHPの設定ファイルをコピー
# COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# # ワーキングディレクトリを設定
# WORKDIR /work/web

# # Node.jsとnpmをインストール
# RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
#     && apt-get install -y nodejs

# # 作業ディレクトリを設定
# WORKDIR /var/www

# # Composerをインストール
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # アプリケーションファイルをコピー
# COPY . .

# # npmパッケージをインストール
# RUN npm install

# # Viteの開発サーバーを起動
# CMD ["npm", "run", "dev"]
