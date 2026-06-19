# FOMO - Assessment Test

Project ini dibangun menggunakan Laravel dengan bahasa pemrograman **PHP**.

## Inti Project

Membuat API sederhana untuk transaksi barang dengan mempertimbangkan berebut stok, baik melalui flash sale atau lainnya. Masalah race condition tersebut akan ditangani dengan mengunci database atau di laravel bisa menggunakan `lockForUpdate()` yang sudah tersedia.

## Rest API

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
git clone <url-repo>
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

## Simple Game

Command ini masih belum selesai.

```bash
php artisan game:start
```

## Simple Docs API

Query params untuk endpoint list: `?page=1`, `?sort=asc|desc`.

### GET `/api/categories`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": [{ "id": 1, "name": "Atasan" }],
  "pagination": {
    "next_page": null,
    "prev_page": null,
    "current_page": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "from": 1,
    "total": 1
  }
}
```

### GET `/api/categories/{id}`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": { "id": 1, "name": "Atasan" }
}
```

### GET `/api/products`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": [
    {
      "id": 1,
      "name": "Kaos Polos Hitam",
      "price": 100000,
      "stock": 100,
      "category": { "id": 1, "name": "Atasan" }
    }
  ],
  "pagination": {}
}
```

### GET `/api/products/{id}`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": {
    "id": 1,
    "name": "Kaos Polos Hitam",
    "price": 100000,
    "stock": 100,
    "category": { "id": 1, "name": "Atasan" }
  }
}
```

### GET `/api/transactions`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": [
    {
      "id": 1,
      "code": "INV-26619-ABCDE",
      "total_amount": 100000,
      "items": []
    }
  ],
  "pagination": {}
}
```

### GET `/api/transactions/{id}`

Response:

```json
{
  "status": "success",
  "message": "Success",
  "data": {
    "id": 1,
    "code": "INV-26619-ABCDE",
    "total_amount": 100000,
    "items": [
      {
        "id": 1,
        "quantity": 1,
        "price": 100000,
        "subtotal": 100000,
        "product": {
          "id": 1,
          "name": "Kaos Polos Hitam",
          "category": { "id": 1, "name": "Atasan" }
        }
      }
    ]
  }
}
```

### POST `/api/transactions`

Body:

```json
{
  "items": [
    { "product_id": 1, "quantity": 1 }
  ]
}
```

Response:

```json
{
  "status": "success",
  "message": "Created",
  "data": {
    "id": 1,
    "code": "INV-26619-ABCDE",
    "total_amount": 100000,
    "items": []
  }
}
```
