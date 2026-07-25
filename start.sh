#!/bin/sh

set -e

cd /var/www/html

echo "[init] Iniciando SkillFocus em $(hostname)..."

# --- APP_KEY (essencial para Render, não persistimos .env comitted) ---
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ] || printf '%s' "$APP_KEY" | grep -qiE '^base64:\s*$'; then
  if [ -f .env ] && grep -q '^APP_KEY=' .env; then
    CURRENT_KEY=$(grep '^APP_KEY=' .env | head -n 1 | cut -d'=' -f2- | tr -d '[:space:]')
    if [ -z "$CURRENT_KEY" ] || ! printf '%s' "$CURRENT_KEY" | grep -qi '^base64:'; then
      echo "[init] Gerando nova APP_KEY..."
      php artisan key:generate --force --ansi || true
    fi
  else
    echo "[init] Gerando nova APP_KEY..."
    php artisan key:generate --force --ansi || true
  fi
else
  echo "[init] Usando APP_KEY do ambiente"
fi

echo "[init] Discover + migrations..."
php artisan package:discover --ansi || true

# Run migrations BEFORE caches so env vars are fresh-read
php artisan migrate --force --no-interaction || true
php artisan storage:link || true

# Caches (last step — after migrations, package discover, key)
php artisan config:cache 2>/dev/null || php artisan config:clear
php artisan route:cache  2>/dev/null || php artisan route:clear
php artisan view:cache   2>/dev/null || php artisan view:clear

echo "[init] Sessão de inicialização pronta. Iniciando servidor em 0.0.0.0:${PORT:-10000}"

exec php -d variables_order=EGPCS \
          -d post_max_size=32M \
          -d upload_max_filesize=32M \
          -d max_execution_time=180 \
          -d memory_limit=512M \
    artisan serve \
          --host=0.0.0.0 \
          --port="${PORT:-10000}"
