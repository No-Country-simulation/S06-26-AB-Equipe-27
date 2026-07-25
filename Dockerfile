#######################################
# Stage 0 — Node / Vite (Frontend build)
#######################################

FROM node:20-alpine AS node_builder

WORKDIR /build

COPY package*.json ./
# Render/npm private registries toleration
RUN npm config set ignore-scripts true 2>/dev/null || true
RUN npm ci --no-audit --no-fund

COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js ./
COPY tailwind.config.js* ./ 2>/dev/null || true

RUN npm run build

#######################################
# Stage 1 — Composer (PHP deps)
#######################################

FROM composer:2 AS composer_builder

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader

COPY . .

COPY --from=node_builder /build/public ./public

RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump --no-interaction

#######################################
# Stage 2 — Python venv builder
#######################################

FROM python:3.11-slim AS python_builder

ENV PYTHONDONTWRITEBYTECODE=1 \
    PYTHONUNBUFFERED=1 \
    PIP_NO_CACHE_DIR=1 \
    PIP_DISABLE_PIP_VERSION_CHECK=1

WORKDIR /build

RUN python3 -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"

RUN pip install --upgrade pip setuptools wheel

COPY app/scripts/requirements.txt /tmp/requirements.txt
RUN if [ -s /tmp/requirements.txt ]; then \
    pip install --no-cache-dir -r /tmp/requirements.txt; \
    else \
    pip install --no-cache-dir PyPDF2 pandas google-generativeai; \
    fi

#######################################
# Stage 3 — Runtime (PHP 8.3 + Python + PostgreSQL drivers)
#######################################

FROM php:8.3-cli

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive \
    LANG=C.UTF-8 \
    LC_ALL=C.UTF-8 \
    PYTHONUNBUFFERED=1 \
    PYTHONIOENCODING=utf-8 \
    PYTHONUTF8=1 \
    PYTHONWARNINGS=ignore \
    PYTHONDONTWRITEBYTECODE=1 \
    PYTHON_BIN=/opt/venv/bin/python \
    PATH="/opt/venv/bin:$PATH"

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    curl \
    wget \
    ca-certificates \
    python3 \
    python3-pip \
    python3-venv \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
    pdo \
    pdo_pgsql \
    pdo_mysql \
    bcmath \
    intl \
    gd \
    zip \
    opcache \
    mbstring \
    pcntl \
    soap \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=python_builder /opt/venv /opt/venv

RUN /opt/venv/bin/python -c "import PyPDF2, pandas; import importlib.util; g1=importlib.util.find_spec('google.genai'); g2=importlib.util.find_spec('google.generativeai'); assert g1 or g2, 'missing google genai sdk'; print('python-ok')"

COPY --from=composer_builder /app .

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
