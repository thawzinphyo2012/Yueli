# Yueli Studio

Premium fashion portfolio and e-commerce website built with Laravel, Blade, Tailwind CSS, Alpine.js, and MySQL.

## Stack

- **Backend:** Laravel 12
- **Frontend:** Blade templates
- **Styling:** Tailwind CSS 4 + custom CSS
- **Database:** MySQL (`yueli_studio`)
- **JavaScript:** Alpine.js + Vanilla JS
- **Icons:** Lucide
- **Build:** Vite
- **Auth:** Laravel session authentication (admin middleware)
- **Images:** Laravel Storage (`public` disk) + URL support

## Features

### Storefront
- Brand home with full-bleed campaign hero
- Fashion collections
- Lookbook & campaign photography
- Designer portfolio
- Shop, product detail, session cart, checkout (COD / bank transfer)
- About & contact

### Admin (`/admin`)
- Dashboard
- Products, collections, lookbooks, portfolio projects
- Orders & customers
- Website content blocks
- Site settings

## Setup (XAMPP)

1. Start **Apache** and **MySQL** in XAMPP.
2. Ensure database exists:

```sql
CREATE DATABASE IF NOT EXISTS yueli_studio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Copy env if needed and confirm MySQL settings in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yueli_studio
DB_USERNAME=root
DB_PASSWORD=
```

4. Install & prepare:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

5. Run:

```bash
php artisan serve --port=8018
```

Optional Vite HMR in another terminal:

```bash
npm run dev
```

Open `http://127.0.0.1:8018`

## Admin login

- **URL:** `/login`
- **Email:** `admin@yuelistudio.com`
- **Password:** `password`

## Sample customer

- **Email:** `guest@example.com`
- **Password:** `password`
