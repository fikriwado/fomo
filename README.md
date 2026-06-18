# FOMO - Assessment Test

Project ini dibangun menggunakan Laravel dengan bahasa pemrograman **PHP**.

## Inti Project

Membuat API sederhana untuk transaksi barang dengan mempertimbangkan berebut stok, baik melalui flash sale atau lainnya. Masalah race condition tersebut akan ditangani dengan mengunci database atau di laravel bisa menggunakan `lockForUpdate()` yang sudah tersedia.

## TODO API

- GET: http://localhost:8000/api/categories
- GET: http://localhost:8000/api/categories/{id}
- GET: http://localhost:8000/api/products
- GET: http://localhost:8000/api/products/{id}
- GET: http://localhost:8000/api/transactions
- POST: http://localhost:8000/api/transactions
- GET: http://localhost:8000/api/transactions/{id}

## Cara Menjalankan Project

Lakukan setup standar Laravel pada umumnya:

```bash
git clone <url-repo-kamu>
cd <folder-repo>
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Testing

```bash
php artisan test
```
