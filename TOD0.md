## TODO - E-commerce feature upgrades (in approved order)

### 1) Multi product images + admin preview + customer product gallery
- Update `app/Http/Controllers/Admin/ProductController.php`:
  - support `images[]` upload
  - save to `products.images` (JSON array)
  - keep `products.image` as primary (set from existing or first new image)
  - validate `images.*` as images
- Update `resources/views/admin/products/create.blade.php`:
  - add `images[]` multiple file input
  - (optional) show image previews with JS
- Update `resources/views/admin/products/edit.blade.php`:
  - preview main image + thumbnails for `products.images`
  - add `images[]` multiple file input
- Update `resources/views/customer/product-detail.blade.php`:
  - render gallery from `products.images` (fallback to `products.image`)

### 2) Customer “My Orders” (order history)
- Add customer routes in `routes/web.php` (auth-protected)
- Add controller (e.g. `app/Http/Controllers/Customer/AccountController.php` or `OrdersController.php`)
  - list orders for current user
  - show one order (ownership check)
- Add views:
  - `resources/views/customer/account/orders/index.blade.php`
  - `resources/views/customer/account/orders/show.blade.php`

### 3) Customer profile page + profile image + password update
- Add migration to include `users.profile_image` column (nullable string)
- Add controller methods to show and update profile
- Add view:
  - `resources/views/customer/account/profile.blade.php`
- Update password handling:
  - require password change validation (per approved approach)

### 4) Admin user management (list users + change active)
- Add admin routes in `routes/web.php`
- Add `app/Http/Controllers/Admin/UserController.php`
- Add views:
  - `resources/views/admin/users/index.blade.php`
  - (optional) `edit.blade.php` for role/active updates
