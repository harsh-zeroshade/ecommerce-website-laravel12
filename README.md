# Ecommerce Website (Laravel 12)

A modern **ecommerce** web application built with **Laravel 12** featuring:

- Customer: browse products, checkout, order success page
- Customer Account: **Profile** (edit name, phone, address/location, profile image) + **My Orders** (order history + order details)
- Admin Dashboard: full management for products, orders, categories, and users
- Product Media: **admin multi-image upload** per product + **front-end image gallery**

---

## 🚀 Live Demo
*(Add your hosted link here if available)*

---

## ✨ Features

### Customer
- Shop / Product listing
- Product detail page with **multi-image gallery**
- Checkout with shipping + tax + COD/UPI/Card placeholders
- My Orders section (authenticated users)
- Account Profile page:
  - Edit: **name, phone/number, address/location fields**
  - Change password
  - Upload/update **profile image/avatar**

### Admin
- Dashboard overview
- Products:
  - Create / Edit / Delete
  - Upload **main image + multiple images**
  - Preview images in admin UI
- Orders:
  - List + view order details
  - Update order status
- Users / Categories:
  - Basic CRUD depending on your current admin setup

---

## 🧰 Tech Stack
- PHP (Laravel 12)
- MySQL / MariaDB
- Blade templating
- Vite (frontend assets)
- Laravel Auth

---

## 📦 Requirements
- PHP 8.2+ (recommended for Laravel 12)
- Composer
- MySQL/MariaDB
- Node.js + npm (for Vite)

---

## ✅ Setup Guide (Complete)

### 1) Clone the repository
```bash
git clone <your-repo-url>
cd ecommerce-website-laravel12
```

### 2) Install PHP dependencies
```bash
composer install
```

### 3) Create your environment file
Copy `.env.example` to `.env`:

```bash
copy .env.example .env
```

### 4) Configure database
Open `.env` and update these:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5) Generate application key
```bash
php artisan key:generate
```

### 6) Run migrations
```bash
php artisan migrate
```

### 7) (Optional) Seed demo data
```bash
php artisan db:seed
```

> Note: Seeders depend on your current codebase. If you want a default admin user, ensure `UserSeeder` creates one.

### 8) Storage link (required for images)
This enables serving files from `storage/app/public` via `/storage/...`:

```bash
php artisan storage:link
```

### 9) Frontend assets (Vite)
Install node dependencies:

```bash
npm install
```

Build / dev server:

```bash
npm run dev
```

### 10) Start Laravel server (for local testing)
```bash
php artisan serve
```

Or use Apache in XAMPP and point your DocumentRoot to:

- `public/`

---

## 🧪 Admin Credentials
If you used seeders, check `database/seeders/UserSeeder.php` to find the default admin credentials.

*(If you want, we can add a section here with exact defaults once you confirm the seeder values.)*

---

## 🖼️ Uploads & Image Storage
- Product images are stored in `storage/app/public/products/...`
- Access them via:
  - `{{ asset('storage/'.$path) }}`

Ensure:
- You have run `php artisan storage:link`
- Your server has read permissions for `storage/`

---

## 📚 Project Structure (High level)
- `app/Http/Controllers/Admin/*` → admin dashboard controllers
- `app/Http/Controllers/Customer/*` → customer pages and account pages
- `app/Models/*` → Eloquent models (`Product`, `Order`, `User`, etc.)
- `resources/views/admin/*` → admin UI
- `resources/views/customer/*` → customer UI
- `routes/web.php` → route definitions

---

## 🔧 Common Troubleshooting

### Images not loading
- Run: `php artisan storage:link`
- Confirm file exists under `storage/app/public/...`

### 403 / Auth redirect issues
- Clear Laravel session and cookies
- Make sure middleware `is.admin` is correct for admin routes

---

## 📌 Next Improvements (Optional)
- Email notifications for order updates
- Payment gateway integration (Stripe/Razorpay)
- Review moderation + approval workflow
- Bulk product import (CSV)
- Search + filters on shop page

---

## 🤝 Contributing
1. Fork repository
2. Create a feature branch
3. Commit and open a Pull Request

---

## 📝 License
*(Add license if you want—MIT/Apache/etc.)*

