#######################################
# Stage 0 — Node / Vite (Frontend build)
#######################################

FROM node:20-alpine AS node_builder

WORKDIR /build

COPY package*.json ./
RUN npm config set ignore-scripts true 2>/dev/null || true \
    && (npm ci --no-audit --no-fund || npm install --no-audit --no-fund)

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

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

RUN if [ ! -e /opt/venv/bin/python ]; then \
    ln -sf python3 /opt/venv/bin/python; \
    fi \
    && if [ ! -e /opt/venv/bin/pip ]; then \
    ln -sf pip3 /opt/venv/bin/pip; \
    fi

RUN pip install --upgrade pip setuptools wheel

COPY app/scripts/requirements.txt /tmp/requirements.txt
RUN if [ -s /tmp/requirements.txt ]; then \
    pip install --no-cache-dir -r /tmp/requirements.txt; \
    else \
    pip install --no-cache-dir PyPDF2 pandas google-generativeai; \
    fi \
    && /opt/venv/bin/python -c "import PyPDF2, pandas; import importlib.util; g1=importlib.util.find_spec('google.genai'); g2=importlib.util.find_spec('google.generativeai'); assert g1 or g2, 'missing google genai sdk'; print('python-builder-ok')"

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

COPY app/scripts/requirements.txt /tmp/.skillfocus-requirements.txt

RUN set -eu; \
    apt-get update 2>/dev/null || true; \
    command -v python3 >/dev/null 2>&1 || apt-get install -y --no-install-recommends python3; \
    dpkg -s python3-venv >/dev/null 2>&1 || apt-get install -y --no-install-recommends python3-venv python3-pip; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
    \
    SYS_PY="$(command -v python3)"; \
    echo "[python-venv] Using system python: $SYS_PY ($($SYS_PY --version 2>&1 || true))"; \
    \
    rm -rf /opt/venv; \
    "$SYS_PY" -m venv --without-pip /opt/venv 2>/dev/null || \
    "$SYS_PY" -m venv /opt/venv; \
    \
    if [ ! -e /opt/venv/bin/python ]; then \
    if [ -x /opt/venv/bin/python3 ]; then \
    (cd /opt/venv/bin && ln -sf python3 python); \
    else \
    ln -sf "$SYS_PY" /opt/venv/bin/python; \
    fi; \
    fi; \
    if [ ! -e /opt/venv/bin/python3 ]; then \
    if [ -x /opt/venv/bin/python ]; then \
    (cd /opt/venv/bin && ln -sf python python3); \
    else \
    ln -sf "$SYS_PY" /opt/venv/bin/python3; \
    fi; \
    fi; \
    \
    export PIP_BREAK_SYSTEM_PACKAGES=1; \
    /opt/venv/bin/python -m ensurepip --upgrade 2>/dev/null || \
    "$SYS_PY" -m ensurepip --upgrade 2>/dev/null || true; \
    \
    if ! command -v /opt/venv/bin/pip >/dev/null 2>&1; then \
    if [ -x /opt/venv/bin/pip3 ]; then \
    (cd /opt/venv/bin && ln -sf pip3 pip); \
    fi; \
    fi; \
    \
    /opt/venv/bin/python -m pip install --upgrade pip setuptools wheel 2>&1 || \
    "$SYS_PY" -m pip install --upgrade --break-system-packages pip setuptools wheel 2>&1 || true; \
    \
    if [ -s /tmp/.skillfocus-requirements.txt ]; then \
    /opt/venv/bin/python -m pip install --no-cache-dir -r /tmp/.skillfocus-requirements.txt 2>&1 || \
    "$SYS_PY" -m pip install --no-cache-dir --break-system-packages -r /tmp/.skillfocus-requirements.txt 2>&1; \
    else \
    /opt/venv/bin/python -m pip install --no-cache-dir PyPDF2 pandas google-generativeai 2>&1 || \
    "$SYS_PY" -m pip install --no-cache-dir --break-system-packages PyPDF2 pandas google-generativeai 2>&1; \
    fi; \
    rm -f /tmp/.skillfocus-requirements.txt; \
    \
    (cd /opt/venv/bin && ln -sf python3 python 2>/dev/null || true); \
    (cd /opt/venv/bin && ln -sf pip3 pip 2>/dev/null || true); \
    ls -la /opt/venv/bin/ | head -20 || true; \
    \
    /opt/venv/bin/python -c "import PyPDF2, pandas; import importlib.util; g1=importlib.util.find_spec('google.genai'); g2=importlib.util.find_spec('google.generativeai'); assert g1 or g2, 'missing google genai sdk'; print('python-ok using', __import__('sys').executable)"

COPY --from=composer_builder /app .

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
