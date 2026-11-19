#!/bin/sh
set -e

cd /var/www/html

# Salin .env jika belum ada
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.docker ]; then
        cp /var/www/html/.env.docker /var/www/html/.env
    elif [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    fi
fi

# Pastikan direktori storage & cache tersedia
mkdir -p \
    /var/www/html/storage/app/public \
    /var/www/html/storage/app/dokumen_permohonan \
    /var/www/html/storage/app/jawaban_permohonan \
    /var/www/html/storage/app/dokumen_keberatan \
    /var/www/html/storage/app/backups \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    /var/log/supervisor

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate APP_KEY jika belum terisi atau variabel env APP_KEY kosong
if [ -z "${APP_KEY:-}" ]; then
    unset APP_KEY
fi
if [ -z "${APP_KEY:-}" ] && ! grep -qE '^APP_KEY=base64:' /var/www/html/.env; then
    php artisan key:generate --force
fi
if [ -z "${APP_KEY:-}" ] && grep -qE '^APP_KEY=base64:' /var/www/html/.env; then
    APP_KEY=$(grep -E '^APP_KEY=' /var/www/html/.env | head -n 1 | cut -d '=' -f2- | tr -d '"' | tr -d "'")
    export APP_KEY
fi

# Buat symlink public/storage
php artisan storage:link --force || true

# Tunggu koneksi database MySQL siap (maksimal 30 detik)
php -r '
require "/var/www/html/vendor/autoload.php";
if (file_exists("/var/www/html/.env")) {
    Dotenv\Dotenv::createImmutable("/var/www/html")->safeLoad();
}
$conn = $_ENV["DB_CONNECTION"] ?? getenv("DB_CONNECTION") ?: "mysql";
if ($conn !== "mysql") {
    exit(0);
}
$host = getenv("DB_HOST") ?: ($_ENV["DB_HOST"] ?? "db");
$port = getenv("DB_PORT") ?: ($_ENV["DB_PORT"] ?? "3306");
$db   = getenv("DB_DATABASE") ?: ($_ENV["DB_DATABASE"] ?? "ppid_dispora_db");
$user = getenv("DB_USERNAME") ?: ($_ENV["DB_USERNAME"] ?? "root");
$pass = getenv("DB_PASSWORD");
if ($pass === false) {
    $pass = $_ENV["DB_PASSWORD"] ?? "";
}
for ($i = 0; $i < 30; $i++) {
    try {
        new PDO("mysql:host={$host};port={$port};dbname={$db}", $user, $pass, [PDO::ATTR_TIMEOUT => 2]);
        echo "MySQL siap digunakan.\n";
        exit(0);
    } catch (Throwable $e) {
        echo "Menunggu koneksi MySQL ({$host}:{$port})...\n";
        sleep(1);
    }
}
fwrite(STDERR, "Gagal terhubung ke MySQL setelah 30 detik.\n");
exit(1);
'

# Jalankan migrasi & seeder idempoten
php artisan migrate --force
php artisan db:seed --class=UserSeeder --force

# Optimasi cache produksi
php artisan config:clear
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
