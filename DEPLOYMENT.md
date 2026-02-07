# Deployment (Laravel 12 + Vite)

## 1. Server prerequisites
- Ubuntu 22.04/24.04 (or similar Linux)
- Nginx
- PHP 8.2+ with extensions: `mbstring`, `xml`, `curl`, `zip`, `bcmath`, `sqlite3`/`mysql`, `gd`
- PHP-FPM
- MySQL/MariaDB
- Composer
- Node.js + npm

## 2. Clone project
```bash
sudo mkdir -p /var/www
cd /var/www
sudo git clone <YOUR_REPO_URL> spice-basket
sudo chown -R $USER:$USER /var/www/spice-basket
cd /var/www/spice-basket
```

## 3. App env setup
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://yourdomain.com`
- Set database values (`DB_*`)

## 4. Deploy app
```bash
APP_DIR=/var/www/spice-basket BRANCH=main ./scripts/deploy-production.sh
```

## 5. Nginx setup
Copy template and update domain/path/socket:
```bash
sudo cp deploy/nginx/spice-basket.conf.example /etc/nginx/sites-available/spice-basket.conf
sudo ln -s /etc/nginx/sites-available/spice-basket.conf /etc/nginx/sites-enabled/spice-basket.conf
sudo nginx -t
sudo systemctl reload nginx
```

## 6. SSL (Let's Encrypt)
```bash
sudo apt-get update
sudo apt-get install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

## 7. Background workers (optional)
If you use queues later, run a worker using Supervisor/systemd.

## 8. Subsequent deploys
```bash
cd /var/www/spice-basket
APP_DIR=/var/www/spice-basket BRANCH=main ./scripts/deploy-production.sh
```
