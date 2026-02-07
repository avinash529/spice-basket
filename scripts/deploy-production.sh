#!/usr/bin/env bash
set -euo pipefail

# Usage:
#   APP_DIR=/var/www/spice-basket BRANCH=main ./scripts/deploy-production.sh

APP_DIR="${APP_DIR:-/var/www/spice-basket}"
BRANCH="${BRANCH:-main}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
NPM_BIN="${NPM_BIN:-npm}"
WEB_GROUP="${WEB_GROUP:-www-data}"
RUN_NPM_BUILD="${RUN_NPM_BUILD:-1}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-1}"

echo "==> Deploying Spice Basket"
echo "    APP_DIR: $APP_DIR"
echo "    BRANCH:  $BRANCH"

if [[ ! -d "$APP_DIR" ]]; then
  echo "ERROR: APP_DIR does not exist: $APP_DIR"
  exit 1
fi

cd "$APP_DIR"

if [[ -d .git ]]; then
  echo "==> Updating git branch"
  git fetch --all --prune
  git checkout "$BRANCH"
  git pull --ff-only origin "$BRANCH"
fi

if [[ ! -f .env ]]; then
  echo "==> .env missing, copying from .env.example"
  cp .env.example .env
fi

echo "==> PHP dependencies"
"$COMPOSER_BIN" install --no-dev --prefer-dist --optimize-autoloader --no-interaction

echo "==> Application key"
"$PHP_BIN" artisan key:generate --force --no-interaction || true

if [[ "$RUN_NPM_BUILD" == "1" ]]; then
  echo "==> Frontend build"
  "$NPM_BIN" ci
  "$NPM_BIN" run build
fi

if [[ "$RUN_MIGRATIONS" == "1" ]]; then
  echo "==> Database migrations"
  "$PHP_BIN" artisan migrate --force --no-interaction
fi

echo "==> Storage link"
"$PHP_BIN" artisan storage:link || true

echo "==> Cache/optimize"
"$PHP_BIN" artisan optimize:clear
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

if command -v chown >/dev/null 2>&1; then
  echo "==> Permissions"
  chown -R :"$WEB_GROUP" storage bootstrap/cache || true
  chmod -R ug+rwx storage bootstrap/cache || true
fi

echo "==> Deployment complete"
